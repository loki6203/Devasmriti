<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\PaymentGateway;
use App\Models\AccountDeposit;
use App\Models\AccountHistory;
use App\Models\UserDetail;
use App\Models\Setting;
use App\Models\UserCardDetail;
use App\Models\CommonGatewayCard;
use Razorpay\Api\Api as Razorpay;

class RechargeController extends Controller 
{
    public $succ = 200;
    public $err  = 202;
    public function deposit_money_to_account(Request $request){
        $userid = login_User_ID();
        $data=array();
        $status = $this->err;
        $message='';
        $success=1;
        $from_user_id = login_User_ID();
        $validator = Validator::make($request->all(), [ 
            'amount'        =>  'required',
            'gate_way_id'   =>  'required'
        ]);
        if ($validator->fails()) {
            $message = 'Please enter all (*) fields';
            $success=0;
        }else{
            $amount         = $request->amount;
            $gate_way_id    = $request->gate_way_id;
            $PaymentGateway = PaymentGateway::find($gate_way_id);
            if($PaymentGateway->name=='zaakpay'){
                if($PaymentGateway->type=='test'){
                    $PaymtDetails   = $PaymentGateway->test;
                    $GateDetails    = json_decode($PaymtDetails,true);
                    $Merchant_ID    = $GateDetails['Merchant_ID'];
                    $SECRET_KEY     = $GateDetails['SECRET_KEY'];
                    $API_KEY        =  $GateDetails['API_KEY'];
                    $URL            =  $GateDetails['URL'];
                }else{
                    $PaymtDetails   = $PaymentGateway->live;
                    $GateDetails    = json_decode($PaymtDetails,true);
                    $Merchant_ID    = $GateDetails['Merchant_ID'];
                    $SECRET_KEY     = $GateDetails['SECRET_KEY'];
                    $API_KEY        =  $GateDetails['API_KEY'];
                    $URL            =  $GateDetails['URL'];
                }
            }else if($PaymentGateway->name=='razorpay'){
                if($PaymentGateway->type=='test'){
                    $PaymtDetails   = $PaymentGateway->test;
                    $GateDetails    = json_decode($PaymtDetails,true);
                    $key_id = $GateDetails['KEY_ID'];
                    $key_secret =  $GateDetails['SECRET_KEY'];
                }else{
                    $PaymtDetails   = $PaymentGateway->live;
                    $GateDetails    = json_decode($PaymtDetails,true);
                    $key_id = $GateDetails['KEY_ID'];
                    $key_secret =  $GateDetails['SECRET_KEY'];
                }
                $api = new Razorpay($key_id,$key_secret);
                $transaction_id = Generate_Transaction('deposit');
                $amount = $amount/100;
                $order = $api->order->create(array(
                    'receipt' => $transaction_id,
                    'amount' => $amount,
                    'payment_capture' => 1,
                    'currency' => 'INR'
                ));
                if(isset($order['id']) && !empty($order)) {
                    $dt = array(
                        'id'=>$order['id'],
                        'entity'=>$order['entity'],
                        'receipt'=>$order['receipt'],
                        'offer_id'=>$order['offer_id'],
                        'attempts'=>$order['attempts']
                    );
                    $success=1;
                    $AccountDeposit = new AccountDeposit();
                    $AccountDeposit->user_id        = $userid;
                    $AccountDeposit->amount         = $amount;
                    $AccountDeposit->description    = '';
                    $AccountDeposit->transaction_id = $transaction_id;
                    $AccountDeposit->gate_way_id    = $gate_way_id;
                    $AccountDeposit->created_at     = curr_dt();
                    $AccountDeposit->save();
                    $AccountDeposit->invoice_id     = $order['id'];
                    $AccountDeposit->save();
                    $data = array(
                        'payment_id' => $AccountDeposit->id,
                        'key_id'=>$key_id,
                        'order_details'=>$dt
                    );
                    $message = "Order created successfully";
                }else{
                    $message="Invalid amount";
                }
            }else if($PaymentGateway->name=='safexpay'){

            }else{
                $message = "Tray again";
            }
        }
        $resp = array('success'=>$success,'message'=>$message,'data'=>$data);
        return response()->json($resp, $status);
    }
    public function deposit_money_to_payment_status(Request $request){
        $card_det='';
        $userid = login_User_ID();
        $data=array();
        $status = $this->err;
        $message='';
        $success=1;
        $validator = Validator::make($request->all(), [ 
            'payment_id'       =>  'required',
            'payment_status'   =>  'required',
            'payment_response' =>  'required'
        ]);
        $payment_status=0;
        if ($validator->fails()) {
            $message = 'Please enter all (*) fields';
            $success=0;
        }else{
            $AccountDeposit = AccountDeposit::find($request->payment_id);
            $charges=0;
            $cardname=0;
            if($AccountDeposit && trim($AccountDeposit->payment_status)=='Pending'){
                $AccountDeposit->payment_response   = $request->payment_response;
                $AccountDeposit->payment_status     = $request->payment_status;
                $AccountDeposit->acc_debited_status = $request->payment_status;
                $AccountDeposit->created_at       = curr_dt();
                $AccountDeposit->save();
                if($request->payment_status=='Success'){
                    $PaymentGateway = PaymentGateway::find($AccountDeposit->gate_way_id);
                    if($AccountDeposit->gate_way_id==2){
                        if($PaymentGateway->type=='test'){
                            $PaymtDetails   = $PaymentGateway->test;
                            $GateDetails    = json_decode($PaymtDetails,true);
                            $key_id = $GateDetails['KEY_ID'];
                            $key_secret =  $GateDetails['SECRET_KEY'];
                        }else{
                            $PaymtDetails   = $PaymentGateway->live;
                            $GateDetails    = json_decode($PaymtDetails,true);
                            $key_id = $GateDetails['KEY_ID'];
                            $key_secret =  $GateDetails['SECRET_KEY'];
                        }
                        $razorpay_signature     =   1;
                        $razorpay_order_id      =   1;
                        $razorpay_payment_id    = $request->razorpay_payment_id;
                        //$api = new Razorpay($key_id,$key_secret);
                        //$attributes  = array('razorpay_signature'  => $razorpay_signature,  'razorpay_payment_id'  => $razorpay_payment_id ,  'razorpay_order_id' => $razorpay_order_id);
                        //$order  = $api->utility->verifyPaymentSignature($attributes);
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                        CURLOPT_URL => 'https://api.razorpay.com/v1/payments/'.$razorpay_payment_id.'/card',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'GET',
                        CURLOPT_HTTPHEADER => array(
                            "Authorization: Basic ".base64_encode($key_id.":".$key_secret)
                        ),
                        ));
                        $response = curl_exec($curl);
                        curl_close($curl);
                        //$AccountDeposit->card_details = $razorpay_payment_id;
                        $AccountDeposit->card_details = $response;
                        $AccountDeposit->save();
                        $resp = json_decode($response,true);
                        $card_det = $resp;
                        if(isset($resp['network'])){
                            $cardname = strtolower($resp['network']);
                            $charges = 1;
                        }
                    }else if($AccountDeposit->gate_way_id==1){
                        if($PaymentGateway->type=='test'){
                            $PaymtDetails   = $PaymentGateway->test;
                            $GateDetails    = json_decode($PaymtDetails,true);
                            $Merchant_ID    = $GateDetails['Merchant_ID'];
                            $SECRET_KEY     = $GateDetails['SECRET_KEY'];
                            $API_KEY        =  $GateDetails['API_KEY'];
                            $URL            =  $GateDetails['URL'];
                        }else{
                            $PaymtDetails   = $PaymentGateway->live;
                            $GateDetails    = json_decode($PaymtDetails,true);
                            $Merchant_ID    = $GateDetails['Merchant_ID'];
                            $SECRET_KEY     = $GateDetails['SECRET_KEY'];
                            $API_KEY        =  $GateDetails['API_KEY'];
                            $URL            =  $GateDetails['URL'];
                        }
                    }
                    $payment_status=1;         
                    $AccountDeposit->txn_id = $AccountDeposit->transaction_id;
                    Cr_Or_Dr_Amount('deposit',$AccountDeposit->amount,'credit',$userid,$AccountDeposit);
                    $User = User::find($userid);
                    ####################### Add Money Notification Start ##################
                    $msg = '₹'. $AccountDeposit->amount.' Credited to your account';
                    Add_Notif('deposit',$userid,0,$msg);
                    $Email_Arr = array(
                        'subject'=>'Money added to account',
                        'type'=>'addmoney',
                        'status'=>1,
                        'user_id'=>$userid,
                        'amount'=>$AccountDeposit->amount
                    );
                    SendEmail($Email_Arr);
                    ####################### Add Money Notification End ##################
                    if($charges==1){
                        $CardCharge_Det  = UserCardDetail::where('user_id','=',$userid)->where('card','=',$cardname)->first();
                        if(is_null($CardCharge_Det) || is_null($CardCharge_Det->gateway_charge)){
                            $CrdDetails = CommonGatewayCard::where('name','=',$cardname)->first();
                            if(is_null($CrdDetails)){
                                $cardcharge = ($AccountDeposit->amount*$PaymentGateway->gateway_charge)/100;
                            }else{
                                $cardcharge = ($AccountDeposit->amount*$CrdDetails->gateway_charge)/100;
                            }
                        }else{
                            $cardcharge = ($AccountDeposit->amount*$CardCharge_Det->gateway_charge)/100;
                        }
                        $AccountDeposit->txn_id      = Generate_Transaction('deposit');
                        Cr_Or_Dr_Amount('deposit',$cardcharge,'debit',$userid,$AccountDeposit);
                        ####################### Card Charge Notification Start ##################
                        $msg = '₹'. $cardcharge.' Card charge debited from your account';
                        Add_Notif('deposit',$userid,0,$msg);
                        ####################### Card Charge Notification End ##################
                    }
                    if(!is_null($User->referel_code) && $User->about_me!=1){
                        $Refereal_Check = User::where('mobile_number','=',$User->referel_code)->first();
                        if(!is_null($Refereal_Check)){
                            $RefUserDet         = UserDetail::where('user_id','=',$Refereal_Check->id)->first();
                            if(is_null($RefUserDet) || is_null($RefUserDet->referal_code_percentage)){
                                $Setting = Setting::find(1);
                                $refamt = ($AccountDeposit->amount*$Setting->common_code_percentage)/100;
                            }else{
                                $refamt = ($AccountDeposit->amount*$RefUserDet->referal_code_percentage)/100;
                            }
                            $Order              = new Setting();
                            $Order->txn_id      = Generate_Transaction('referel');
                            $Order->description = 'Refer By '.$User->name;
                            $Order->id          = 0;
                            Cr_Or_Dr_Amount('referel',$refamt,'credit',$Refereal_Check->id,$Order);
                            $Refereal_Check->about_me = 1;
                            $Refereal_Check->save();
                            ####################### Card Charge Notification Start ##################
                            $msg = '₹'. $refamt.' referral amount credited';
                            Add_Notif('referel',$userid,0,$msg);
                            $Email_Arr = array(
                                'subject'=>'Referral amount added to account',
                                'type'=>'referral',
                                'user_id'=>$userid,
                                'amount'=>$refamt
                            );
                            SendEmail($Email_Arr);
                            ####################### Card Charge Notification End ##################
                        }
                    }
                    $message='Amount added to your account successfully';
                }else{
                    $message='Amount added to your account failed';
                    $Email_Arr = array(
                        'subject'=>'Money added to account',
                        'type'=>'addmoney',
                        'user_id'=>$userid,
                        'status'=>0,
                        'amount'=>$AccountDeposit->amount
                    );
                    SendEmail($Email_Arr);
                }
            }else{
                $message='Already submitted';
            }
        }
        $resp = array('success'=>$success,'payment_status'=>$payment_status,'message'=>$message,'data'=>$data,'card_det'=>$card_det);
        return response()->json($resp, $status);
    }
    public function recharge_payment(Request $request){
        $userid = login_User_ID();
        $data=array();
        $status = $this->err;
        $message='';
        $success=1;
        $validator = Validator::make($request->all(), [ 
            'recharge_type'             =>  'required',
            'operator'                  =>  'required',
            'customer_or_mobilenumber'  =>  'required',
            'amount'                    =>  'required',
        ]);
        if ($validator->fails()) {
            $message = 'Please enter all (*) fields';
            $success=0;
        }else{
            $transaction_id  = 1;
            $RechargeHistory = new RechargeHistory();
            $RechargeHistory->recharge_type     = $request->recharge_type;
            $RechargeHistory->operator          = $request->operator;
            $RechargeHistory->mobile_number     = $request->customer_or_mobilenumber;
            $RechargeHistory->amount            = $request->amount;
            $RechargeHistory->description       = '';
            $RechargeHistory->transaction_id    = $transaction_id;
            $RechargeHistory->created_at        = curr_dt();
            $RechargeHistory->save();
            $RechargeHistory->invoice_id        = Invoice_id($request->recharge_type,$RechargeHistory->id);
            $RechargeHistory->save();
            $Recharge_Status  = 0;
            $payment_response = '';
            if($Recharge_Status==1){
                $RechargeHistory->txn_id = 'RECHARGE';
                Cr_Or_Dr_Amount($request->recharge_type,$RechargeHistory->amount,'debit',$userid,$RechargeHistory);
            }
        }
        $resp = array('success'=>$success,'message'=>$message,'data'=>$data);
        return response()->json($resp, $status);
    }
    public function payment_history(Request $request){
        $userid = login_User_ID();
        $data=array();
        $status = $this->err;
        $message='';
        $success=0;
        $type       = @$request->input('type');
        $from_date  = @$request->input('from_date');
        $to_date    = @$request->input('to_date');
        $module     = @$request->input('module');
        $txn        = @$request->input('txn_id');
        if($from_date!=''){
            if($to_date!=''){
                if($from_date>$to_date){
                    $message='From date must be lessthan or equal to date';
                }
            }else{
                $message='Please enter to date';
            }
        }
        $query = AccountHistory::query();
        $query = $query->where('user_id', '=', $userid);
        if($from_date!='' && $to_date!=''){
            $fr_dt = YY_MM_DD($from_date);
            $to_dt = YY_MM_DD($to_date);
            $query->whereBetween('created_at', [$fr_dt, $to_dt]);
        }
        if($type!=''){
            $query = $query->where('cr_or_dr', '=', $type);
        }
        if($module!=''){
            $query = $query->where('action_type', '=', $module);
        }
        if($txn!=''){
            $query = $query->where('txn_id', '=', $txn);
        }
        $query = $query->paginate(PAGINATE());
        $resp = array('success'=>$success,'message'=>$message,'data'=>$query);
        return response()->json($resp, $status);
    }
}
