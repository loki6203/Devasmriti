<?php

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

if(!function_exists('UniqueMachineID')){
    function UniqueMachineID($salt = "") {
        $fingerprint = [php_uname(), disk_total_space('.'), filectime('/'), phpversion()];
        return hash('sha256', json_encode($fingerprint));
    }
}

if(!function_exists('PAGINATELIMIT')){
    function PAGINATELIMIT($request){
        $headers = $request->header();
        // print_r($headers);
        if(isset($headers['paginate'][0]) && $headers['paginate'][0]>0){
            return $headers['paginate'][0];
        }elseif(isset($headers['paginate'][0]) && $headers['paginate'][0]==0){
                return 1000;
        }else{
            return 15;
        }
    }
}
if(!function_exists('ERRORMESSAGE')){
    function ERRORMESSAGE($msg){
        return $msg;
    }
}
if(!function_exists('curr_dt')){
    function curr_dt(){
        return date('Y-m-d H:i:s');
    }
}
if(!function_exists('user_email')){
    function user_email(){
        $user = auth('api')->user();
        return @$user->email;
    }
}
if(!function_exists('logined_User')){
    function logined_User(){
        if(auth('api')){
            return @auth('api')->user();
        }else{
            return null;
        }
    }
}
if(!function_exists('login_User_ID')){
    function login_User_ID(){
        if(auth('api')){
            if(isset(auth('api')->user()->id)){
                return @auth('api')->user()->id;
            }
        }else{
            return 0;
        }
    }
}
if(!function_exists('Generate_Otp')){
    function Generate_Otp(){
        return 1234;
        //return substr(str_shuffle("0123456789"), 0, 5);
    }
}
if(!function_exists('Generate_Password')){
    function Generate_Password(){
        return 'root123';
        //return substr(str_shuffle("0123456789"), 0, 5);
    }
}
if(!function_exists('Generate_Tpin')){
    function Generate_Tpin(){
        return substr(str_shuffle("0123456789"), 0, 5);
    }
}
if(!function_exists('Reff_No_Generate')){
    function Reff_No_Generate(){
        $Acc_Num = substr(str_shuffle("0123456789"), 0, 12);
        $Acc_Check = Order::where('reference_id','=',$Acc_Num)->count();
        if($Acc_Check>0){
            $this->Reff_No_Generate();
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
if(!function_exists('Date_With_Time')){
    function Date_With_Time($original_date){
        return date("H:i:s", strtotime($original_date));
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
        $string='';
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

if(!function_exists('Generate_Transaction')){
    function Generate_Transaction($paymtype)
    {
        $transaction_id = str_replace(".","",microtime(true)).rand(000,999);
        $AccountHistory = AccountHistory::where('txn_id','=',$transaction_id)->count();
        if($AccountHistory==0){
            return $transaction_id;
        }else{
            Generate_Transaction($paymtype);
        }
    }
}

if(!function_exists('SendMsg')){
    function SendMsg($mobile,$otp)
    {
        $senderid = 'STRIMS';
        $msg = "Your OTP ".$otp." for Devasmriti and Valid for 15 minutes - Devasmriti";
        $url = "https://smslogin.co/v3/api.php?username=S3Micro&apikey=71f2b686e90adbc08c65&senderid=$senderid&mobile=$mobile&message=".urlencode($msg);
        $ret = file($url);
    }
}

if(!function_exists('Add_Notif')){
    function Add_Notif($action_type,$user_id,$is_read,$message)
    {
        
    }
}
if(!function_exists('SendEmail')){
    function SendEmail($ArrayData)
    {
        // $User = User::find($ArrayData['user_id']);
        // $ArrayData['name'] = @($User->name)?$User->name:'';
        // $message = View::make('template', $ArrayData)->render();
        // $Notification               = new Notification();
        // $Notification->user_id      = $ArrayData['user_id'];
        // $Notification->is_read      = 1;
        // $Notification->message      = $message;
        // $Notification->save();
        // return Mail::send('template', $ArrayData, function ($message) use ($to , $subject) {
		// 	$message->to($to,config('global.SITE_NAME'))->from(config('global.FROM_MAIL'))->subject($subject);
		// });
    }
}

if(!function_exists('WEB_API_LINK')){
    function WEB_API_LINK()
    {
        return 'https://devasmrithi.netlify.app/';
    }
}
if(!function_exists('encrypt')){
    function encrypt($plainText,$key)
    {
        $key = hextobin(md5($key));
        $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
        $openMode = openssl_encrypt($plainText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
        $encryptedText = bin2hex($openMode);
        return $encryptedText;
    }
}
if(!function_exists('decrypt')){
    function decrypt($encryptedText,$key)
    {
        $key = hextobin(md5($key));
        $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
        $encryptedText = hextobin($encryptedText);
        $decryptedText = openssl_decrypt($encryptedText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
        return $decryptedText;
    }
}
if(!function_exists('hextobin')){
    function hextobin($hexString){ 
        $length = strlen($hexString); 
        $binString="";   
        $count=0; 
        while($count<$length) 
        {       
            $subString =substr($hexString,$count,2);           
            $packedString = pack("H*",$subString); 
            if ($count==0)
            {
                $binString=$packedString;
            }else{
                $binString.=$packedString;
            } 
            $count+=2; 
        } 
        return $binString; 
  }
}
if(!function_exists('dateDiff')){
    function dateDiff($start, $end) {
        $start_ts = strtotime($start);
        $end_ts = strtotime($end);
        $diff = $end_ts - $start_ts;
        return round($diff / 86400);
    }
}