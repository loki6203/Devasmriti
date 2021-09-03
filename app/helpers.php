<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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
        return (rand(10,100));
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