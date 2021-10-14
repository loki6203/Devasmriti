<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Biller;
use App\Models\Setting;
use App\Models\UserDetail;
use App\Models\BillPay;
use App\Models\PaymentGateway;

class BillPayController extends Controller 
{
    public $succ = 200;
    public $err  = 202;
    public function add_builder(Request $request){
        $userid = login_User_ID();
        $data=array();
        $status = $this->err;
        $success=0;
        $message='';
        $from_user_id = login_User_ID();
        $validator = Validator::make($request->all(), [ 
            'name'        =>  'required',
            'ifsccode'   =>  'required',
            'accountnumber'   =>  'required'
        ]);
        if ($validator->fails()) {
            $message = 'Please enter all (*) fields';
            $success=0;
        }else{
            $name           = $request->name;
            $ifsccode       = $request->ifsccode;
            $accountnumber  = $request->accountnumber;
            $bank_name      = @$request->bank_name;
            $Check_Acc = Biller::where('acc_number','=',$accountnumber)->whereNotNull('fund_account_id')->whereNotNull('cont_id')->count();
            if($Check_Acc==0){
                $Check_Wallet = UserDetail::where('user_id','=',$userid)->first();
                if(is_null($Check_Wallet->beneficiary_amount)){
                    $Amount = Setting::find(1)->beneficiary_amount;
                }else{
                    $Amount = $Check_Wallet->beneficiary_amount;
                }
                if($Check_Wallet['acc_balance'] >= $Amount){
                    $Billres = Biller::where('acc_number','=',$accountnumber)->where('user_id','=',$userid)->first();
                    if(is_null($Billres)){
                        $Billres = new Biller();
                        $Billres->user_id = $userid;
                        $Billres->ifsc_code = $ifsccode;
                        $Billres->name = $name;
                        $Billres->acc_number = $accountnumber;
                        $Billres->bank_name = $bank_name;
                        $Billres->created_at = date('Y-m-d H:i:s');
                        $Billres->save();
                    }else{
                        $Billres->name = $name;
                        $Billres->bank_name = $bank_name;
                        $Billres->ifsc_code = $ifsccode;
                        $Billres->save();
                    }
                    $fund_account_id    = $Billres->fund_account_id;
                    $cont_id            = $Billres->cont_id;
                    $PaymentGateway = PaymentGateway::find(2);
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
                    $key_id='rzp_test_7ZGODqAEak9L9F';
                    $key_secret='H7Vzt0pi6cOeM6Hy7C9HFkWc';
                    if(is_null($cont_id)){
                        $posetd = array(
                            'name'=>$name,
                            'type'=>'customer',
                            'reference_id'=>'Acme Contact ID dd'
                        );
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                        CURLOPT_URL => 'https://api.razorpay.com/v1/contacts',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS =>json_encode($posetd),
                        CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json',
                        "Authorization: Basic ".base64_encode($key_id.":".$key_secret)
                        ),
                        ));
                        $response = curl_exec($curl);
                        $response = json_decode($response,TRUE);
                        if(isset($response['error'])){
                            $final_status=0;
                            if(isset($response['error']['description'])){
                                $message=$response['error']['description'];
                            }
                        }else if(curl_errno($curl)){
                            $message = 'Something went wrong try again';
                        }else{
                            $Billres->cont_id = $response['id'];
                            $Billres->save();
                            $final_status=1;
                        }
                        curl_close($curl);
                    }
                    if(is_null($fund_account_id) && !is_null($Billres->cont_id)){
                        $posetd = array(
                            'contact_id'=>$Billres->cont_id,
                            'account_type'=>'bank_account',
                            'bank_account'=>array(
                                'name'=>$name,
                                'ifsc'=>$ifsccode,
                                'account_number'=>$accountnumber
                            )
                        );
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                        CURLOPT_URL => 'https://api.razorpay.com/v1/fund_accounts',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS =>json_encode($posetd),
                        CURLOPT_HTTPHEADER => array(
                            'Content-Type: application/json',
                            "Authorization: Basic ".base64_encode($key_id.":".$key_secret)
                        ),
                        ));
                        $response = curl_exec($curl);
                        $response = json_decode($response,TRUE);
                        if(isset($response['error'])){
                            $final_status=0;
                            if(isset($response['error']['description'])){
                                $message=$response['error']['description'];
                            }
                        }else if(curl_errno($curl)){
                                $message = 'Something went wrong try again';
                        }else{
                            $Billres->fund_account_id = $response['id'];
                            $Billres->save();
                            $final_status=1;
                        }
                        curl_close($curl);
                    }
                    if($final_status==1){
                        $status = $this->succ;
                        $success=1;
                        $message='Biller added successfully';
                        $Order = new Setting();
                        $Order->id = 0;
                        $Order->txn_id = 'BILLER'.$Billres->id;;
                        $Order->description = 'Amount Debited For Biller Adding';
                        Cr_Or_Dr_Amount('bill_pay',$Amount,'debit',$userid,$Order);
                    }else{
                        if($message==''){
                            $message='Something went wrong try again';
                        }
                    }
                }else{
                    $message= 'Rs '.$Amount.' required to add biller';
                }
            }else{
                $message='Account number already added';
            }
        }
        $resp = array('success'=>$success,'message'=>$message,'data'=>$data);
        return response()->json($resp, $status);
    }
    public function update_builder(Request $request,$biller_id){
        $userid = login_User_ID();
        $data=array();
        $status = $this->err;
        $message='';
        $success=0;
        $from_user_id = login_User_ID();
        $validator = Validator::make($request->all(), [ 
            'name'        =>  'required',
        ]);
        if ($validator->fails()) {
            $message = 'Please enter all (*) fields';
            $success=0;
        }else{
            $status = $this->succ;
            $success=1;
            $name           = $request->name;
            $bank_name      = @$request->bank_name;
            $Billres = Biller::find($biller_id);
            $Billres->name = $name;
            if($bank_name!=''){
                $Billres->bank_name = $bank_name;
            }
            $Billres->updated_at = date('Y-m-d H:i:s');
            $Billres->save();
            $message='Updated successfully';
        }
        $resp = array('success'=>$success,'message'=>$message,'data'=>$Billres);
        return response()->json($resp, $status);
    }
    public function billers_list(Request $request,$keyword=''){
        $userid = login_User_ID();
        $data=array();
        $status = $this->succ;
        $message='';
        $success=1;
        if($keyword!=''){
            $Billres = Biller::where('is_active','=',1)
            ->where('name', 'like', '%' . $keyword . '%')
            ->orWhere('acc_number', 'like', '%'.$keyword.'%')
            ->where('user_id','=',$userid)->get();
        }else{
            $Billres = Biller::where('is_active','=',1)->where('user_id','=',$userid)->get();
        }
        $resp = array('success'=>$success,'message'=>$message,'data'=>$Billres);
        return response()->json($resp, $status);
    }
    public function biller_individual_history(Request $request,$biller_id){
        $userid = login_User_ID();
        $status = $this->succ;
        $BillPay =  BillPay::where('user_id','=',$userid)->where('biller_id','=',$biller_id)->get();
        $resp = array('success'=>1,'message'=>'','data'=>$BillPay);
        return response()->json($resp, $status);
    }
    public function payment_to_builder(Request $request){
        $user_id     =   login_User_ID();
        $status     =   $this->err;
        $success    =   0;
        $data       =   array();
        $message    =   '';
        $validator = Validator::make($request->all(), [ 
            'biller_id'    =>  'required',
            'amount'       =>  'required',
            'description'  =>  'required',
        ]);
        if ($validator->fails()) {
            $message = 'Please enter all (*) fields';
            $message = $validator->messages();
        }else{
            $CheckBalance = UserDetail::where('acc_balance','>=',$request->amount)->where('user_id','=',$user_id)->first();
            if(!is_null($CheckBalance)){
                $amount         = $request->amount;
                $biller_id      = $request->biller_id;
                $description    = $request->description;
                $transaction_id = Generate_Transaction('bill_pay');
                $BillPay                    = new BillPay();
                $BillPay->user_id           = $user_id;
                $BillPay->description       = $description;
                $BillPay->biller_id         = $biller_id;
                $BillPay->transaction_id    = $transaction_id;
                $BillPay->created_at        = date('Y-m-d H:i:s');
                $BillPay->save();
                $PaymentGateway = PaymentGateway::find(2);
                if($PaymentGateway->type=='test'){
                    $PaymtDetails   = $PaymentGateway->test;
                    $GateDetails    = json_decode($PaymtDetails,true);
                    $key_id = $GateDetails['KEY_ID'];
                    $key_secret =  $GateDetails['SECRET_KEY'];
                    $account_number = $GateDetails['account_number'];
                }else{
                    $PaymtDetails   = $PaymentGateway->live;
                    $GateDetails    = json_decode($PaymtDetails,true);
                    $key_id = $GateDetails['KEY_ID'];
                    $key_secret =  $GateDetails['SECRET_KEY'];
                    $account_number = $GateDetails['account_number'];
                }
                $key_id='rzp_test_7ZGODqAEak9L9F';
                $key_secret='H7Vzt0pi6cOeM6Hy7C9HFkWc';
                $Billres = Biller::find($biller_id);
                $rzdata =http_build_query(
                json_decode('{
                    "account_number": "'.$account_number.'",
                    "fund_account_id": "'.$Billres->fund_account_id.'",
                    "amount": '.$amount.',
                    "currency": "INR",
                    "mode": "IMPS",
                    "purpose": "payout",
                    "queue_if_low_balance": true
                }',true)
                );
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL,"https://api.razorpay.com/v1/payouts");
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_USERPWD,$key_id .':'.$key_secret);
                curl_setopt($ch, CURLOPT_POSTFIELDS,$rzdata);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $server_output = curl_exec($ch);
                $result = curl_exec($ch);
                $response = json_decode($result,TRUE);
                if (curl_errno($ch)){
                    $message = 'Something went wrong try again';
                }else if(!is_null($response['failure_reason'])){
                    $message=$response['failure_reason'];
                }else{
                    $status  =   $this->succ;
                    $success=1;
                    $payment_status='Success';
                    $message = 'Amount transfered successfully';
                }
                curl_close($ch);
                if($payment_status=='Success'){
                    $BillPay->invoice_id      =  $response['id'];
                    $BillPay->payment_status  =  'Success';
                    $BillPay->payment_status  =  'Success';
                }else{
                    $BillPay->payment_status  =  'Failed';
                    $BillPay->payment_status  =  'Failed';
                }
                $BillPay->payment_response  =   $result;
                $BillPay->save();
                $BillPay->txn_id = $transaction_id;
                Cr_Or_Dr_Amount('bill_pay',$amount,'debit',$user_id,$BillPay);
            }else{
                $message = 'In sufficient amount in your wallet';
            }
        }
        $resp = array('success'=>$success,'message'=>$message,'data'=>$data);
        return response()->json($resp, $status);
    }
}
