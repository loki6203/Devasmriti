<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\AccountHistory;

if(!function_exists('curr_dt')){
    function curr_dt(){
        return date('Y-m-d H:i:s');
    }
}
if(!function_exists('user_email')){
    function user_email(){
        $user = Auth::user();
        return $user->email;
    }
}
if(!function_exists('logined_User')){
    function logined_User(){
        return Auth::user();
    }
}
if(!function_exists('login_User_ID')){
    function login_User_ID(){
        return Auth::user()->id;
    }
}
if(!function_exists('Generate_Otp')){
    function Generate_Otp(){
        return 12345;
        //return substr(str_shuffle("0123456789"), 0, 5);
    }
}
if(!function_exists('Acc_No_Generate')){
    function Acc_No_Generate(){
        $Acc_Num = substr(str_shuffle("0123456789"), 0, 12);
        $Acc_Check = UserDetail::where('acc_number','=',$Acc_Num)->count();
        if($Acc_Check>0){
            $this->Acc_No_Generate();
        }else{
            return $Acc_Num;
        }
    }
}
if(!function_exists('Acc_No_Generate')){
    function Acc_No_Generate(){
        $Acc_Num = substr(str_shuffle("0123456789"), 0, 12);
        $Acc_Check = User::where('acc_number','=',$Acc_Num)->count();
        if($Acc_Check>0){
            $this->Acc_No_Generate();
        }else{
            return $Acc_Num;
        }
    }
}
if(!function_exists('str_preg_replace')){
    function str_preg_replace($string){
        $string = str_replace(array('[\', \']'), '', $string);
        $string = preg_replace('/\[.*\]/U', '', $string);
        $string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);
        $string = htmlentities($string, ENT_COMPAT, 'utf-8');
        $string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string );
        $string = preg_replace(array('/[^a-z0-9]/i', '/[-]+/') , '-', $string);
        return (trim($string, '-'));
    }
}
if(!function_exists('YY_MM_DD')){
    function YY_MM_DD($date){
        return date('Y-m-d', strtotime($date));
    }
}
if(!function_exists('Date_Month_Name')){
    function Date_Month_Name($original_date){
        return date("M-d-Y", strtotime($original_date));
    }
}
if(!function_exists('Delivery_Date_With_Time')){
    function Delivery_Date_With_Time($original_date){
        return date("M-d-Y H:i:s", strtotime($original_date));
    }
}
if(!function_exists('asset')) {
    function asset($path, $secure = null)
    {
        return app('url')->asset($path, $secure);
    }
}
if(!function_exists('Invoice_id')) {
    function Invoice_id($gateway_type,$last_id)
    {
        if(strlen($last_id) == 1){
            $dynamic_id   = $string. '000' . $last_id;
        }else if(strlen($last_id) == 2){
            $dynamic_id   = $string. '00' . $last_id;
        }else if(strlen($last_id) == 3){
            $dynamic_id   = $string. '0' . $last_id;
        }else if(strlen($last_id) == 4){
            $dynamic_id   = $string. $last_id;
        }
        return  $dynamic_id;
    }
}
if(!function_exists('Updated_User_Amt')){
    function Updated_User_Amt($user_id)
    {
       $AccountHistory = AccountHistory::where('user_id','=',$user_id)->get();
       $credit = array();
       $debit  = array();
       if(count($AccountHistory)>0){
            foreach($AccountHistory as $history){
                if($history->cr_or_dr=='credit'){
                    $credit[]= $history->amount;
                }else{
                    $debit[]= $history->amount;
                }
            }
       }
       $Amount  = array_sum($credit)-array_sum($debit);
       $Tot_Amt = round($Amount,2);
       $UserDetail = UserDetail::where('user_id','=',$user_id)->first();
       $UserDetail->acc_balance = $Tot_Amt;
       $UserDetail->save();
    }
}
if(!function_exists('Cr_Or_Dr_Amount')){
    function Cr_Or_Dr_Amount($paymtype,$amount,$cr_or_dr,$user_id,$Details)
    {
        $AccountHistory = new AccountHistory();
        $AccountHistory->user_id = $user_id;
        $AccountHistory->amount = $amount;
        $AccountHistory->action_type = $paymtype;
        $AccountHistory->description = $Details->description;
        $AccountHistory->transaction_id = $Details->id;
        $AccountHistory->created_at = curr_dt();
        $AccountHistory->payment_details = $Details;
        $AccountHistory->save();
        $this->Updated_User_Amt($user_id);
    }
}