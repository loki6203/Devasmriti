<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\InternalTransfer;
use App\Models\AccountHistory;

class InternalController extends Controller 
{
    public $succ = 200;
    public $err  = 202;
    public function internal_transfer_Search(Request $request){
        $status = $this->err;
        $validator = Validator::make($request->all(), ['keyword' => 'required']);
        $status=1;
        $message='';
        $data=array();
        if ($validator->fails()) {
            $message = 'Please enter atleast one letter';
        }else{
            $data = User::where('mobile_number', 'like', '%'.$request->keyword.'%')->orWhere('name', 'like', '%'.$request->keyword.'%')->get();
            $status = $this->succ;
        }
        $resp = array('success'=>1,'message'=>$message,'data'=>$data);
        return response()->json($resp, $status);
    }
    public function int_trnsf_individual_history(Request $request,$user_id){
        $status = $this->succ;
        $Int_Trans = InternalTransfer::where('from_user_id','=',$user_id)->orWhere('to_user_id','=',$user_id)->with('from_user')->with('to_user_id')->get();
        $resp = array('success'=>1,'message'=>'','data'=>$Int_Trans);
        return response()->json($resp, $status);
    }
    public function int_trnsf_all_history(Request $request){
        $status = $this->succ;
        $user_id = login_User_ID();
        $Int_Trans = InternalTransfer::where('from_user_id','=',$user_id)->orWhere('to_user_id','=',$user_id)->with('from_user')->with('to_user_id')->paginate(10);
        $resp = array('success'=>1,'message'=>'','data'=>$Int_Trans);
        return response()->json($resp, $status);
    }
    public function int_trnsf_amount_paying(Request $request){
        $status = $this->err;
        $data=array();
        $message='';
        $success=1;
        $from_user_id = login_User_ID();
        $validator = Validator::make($request->all(), [ 
            'amount' => 'required', 
            'to_user_id' => 'required',
        ]);
        if ($validator->fails()) {
            $message = 'Please enter all (*) fields';
            $success=0;
        }else{
            $UserDetail = UserDetail::where('acc_balance','>=',$request->amount)->where('user_id','=',$from_user_id)->first();
            if(!is_null($UserDetail)){
                $InternalTransfer = new InternalTransfer();
                $InternalTransfer->amount = $request->amount;
                $InternalTransfer->from_user_id = $from_user_id;
                $InternalTransfer->to_user_id = $request->to_user_id;
                if($request->has('message')){
                    $InternalTransfer->message = $request->message;
                }
                $InternalTransfer->description          = '';
                $InternalTransfer->transaction_id       = Generate_Transaction('internal_transfer');
                $InternalTransfer->payment_status       = 'Success';
                $InternalTransfer->acc_debited_status   = 'Success';
                $InternalTransfer->save();
                $InternalTransfer->invoice_id           = Invoice_id('internal_transfer',$InternalTransfer->id);
                $InternalTransfer->save();

                $AccountHistory           =   new AccountHistory();
                $AccountHistory->user_id  =   $from_user_id;
                $AccountHistory->amount   =   $request->amount;
                $AccountHistory->cr_or_dr =   'debit';
                $AccountHistory->action_type =  'internal_transfer';
                $AccountHistory->description =   '';
                $AccountHistory->transaction_id =   $InternalTransfer->id;
                $AccountHistory->save();
                $Updated_User_Amt = Updated_User_Amt($from_user_id);
                $success=1;
                $message='Payment compleated successfully';
                $data = $InternalTransfer;
                $status = $this->succ;
            }else{
                $message = 'Insufficient amount please recharge and pay';
                $success=0;
            }
        }
        $resp = array('success'=>$success,'message'=>$message,'data'=>$data);
        return response()->json($resp, $status);
    }
    public function TransactionId(Request $request){
        $length=15;
        $trans = substr(str_shuffle(str_repeat($x='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ@$#', ceil($length/strlen($x)) )),1,$length);
        $Check = InternalTransfer::where('transaction_id','=',$trans)->count();
        if($Check==0){
            return $trans;
        }else{
            $this->TransactionId();
        }
    }
    public function check_wallet_amount(Request $request){
        $status = $this->err;
        $data=array();
        $message='';
        $success=1;
        $user_id = login_User_ID();
        $validator = Validator::make($request->all(), [ 
            'amount' => 'required',
        ]);
        if ($validator->fails()) {
            $message = 'Please enter all (*) fields';
            $success=0;
        }else{
            $UserDetail = UserDetail::where('acc_balance','>=',$request->amount)->where('user_id','=',$user_id)->first();
            if(!is_null($UserDetail)){
                $message = 'Amount existed continue payment';
                $status = $this->succ;
            }else{
                $message = 'In sufficient amount';
                $success=0; 
            }
        }
        $resp = array('success'=>$success,'message'=>$message,'data'=>$data);
        return response()->json($resp, $status);
    }
}
