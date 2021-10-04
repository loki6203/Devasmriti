<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\PaymentGateway;
use App\Models\AccountDeposit;
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
                $api = new Razorpay('rzp_live_SCCUPJYTWQvAVQ','jAUskVzf4hwRbFVCf0qFXPDe');
                $transaction_id = Generate_Transaction('deposit');
                $order = $api->order->create(array(
                    'receipt' => $transaction_id,
                    'amount' => $amount,
                    'payment_capture' => 1,
                    'currency' => 'INR'
                ));
                if(isset($order['id'])) {
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
                    $AccountDeposit->invoice_id     = Invoice_id('deposit',$AccountDeposit->id);
                    $AccountDeposit->save();
                    $data = array(
                        'payment_id' => $AccountDeposit->id,
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
            $AccountDeposit->payment_response = $request->payment_response;
            $AccountDeposit->payment_status   = $request->payment_status;
            $AccountDeposit->card_details     = '';
            $AccountDeposit->created_at       = curr_dt();
            $AccountDeposit->save();
            if($AccountDeposit->payment_status=='Success'){
                $payment_status=1;         
                Cr_Or_Dr_Amount('deposit',$AccountDeposit->amount,'credit',$userid,$AccountDeposit);
            }
            $message='Status changed successfully';
        }
        $resp = array('success'=>$success,'payment_status'=>$payment_status,'message'=>$message,'data'=>$data);
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
        $success=1;
    }
}
