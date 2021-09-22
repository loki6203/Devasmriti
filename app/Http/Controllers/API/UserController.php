<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserDetail;

class UserController extends Controller 
{
    public $succ = 200;
    public $err  = 202;
    /** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function getTokenAndRefreshToken(OClient $oClient, $email, $password){
        $oClient = OClient::where('password_client', 1)->first();
        $http = new Client;
        $response = $http->request('POST', 'http://mylemp-nginx/oauth/token', [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => $oClient->id,
                'client_secret' => $oClient->secret,
                'username' => $email,
                'password' => $password,
                'scope' => '*',
            ],
        ]);
        $result = json_decode((string) $response->getBody(), true);
        return response()->json($result, $status);
    }
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'mobile' => 'required',
            'password' => 'required'
        ]);
        $data=array();
        $message='';
        $success=1;
        if($validator->fails()) {
            $message = 'Please enter all (*) fields';
            $status = $this->err;
        }else{
            if(Auth::attempt(['mobile_number'=>$request->mobile,'password'=>$request->password])){
                $user = Auth::user();
                if(is_null($user->email_verified_at)){
                    $user->email_verified_at  = date('Y-m-d H:i:s');
                }
                // $request->user()->tokens()->delete();
                $client = \Laravel\Passport\Client::where('password_client', 1)->first();
                $request->request->add([
                    'grant_type' => 'password',
                    'client_id' => $client->id,
                    'client_secret' => $client->secret,
                    'scope' => null,
                    'username' => $user->email,
                    'password' => request('password'),
                ]);
                $proxy = Request::create('oauth/token','POST');
                $tokens = \Route::dispatch($proxy);
                $tokrnresponse = (array) $tokens->getContent();
                $tokendata = json_decode($tokrnresponse[0]);
                // $request->user()->tokens()->update([
                //     'access_token' => $tokendata->access_token,
                //     'expires_in' => $tokendata->expires_in,
                //     'refresh_token' => $tokendata->refresh_token
                // ]);
                $message = 'Logined successfully';
                $data['token'] = $tokendata->access_token;
                $data['userdetails'] = $user;
                $status = $this->succ;
            }else{
                $message = 'Invalid credentials';
                $status = $this->err;
            }
        }
        $result = array('success'=>$success, 'data'=>$data , 'message'=>$message);
        return response()->json($result, $status);
    }
    public function signup(Request $request) 
    {
        $data=array();
        $message='';
        $success=1;
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'email' => 'required', 
            'mobile_number' => 'required', 
            'user_type' => 'required',
            'password' => 'required', 
            'c_password' => 'required',
        ]);
        if ($validator->fails()) {
            $message = 'Please enter all (*) fields';
            $status = $this->err;
        }else{
            $Em_check = User::where('email', '=', $request->email)->count();
            if($Em_check==0){
                $Ph_check = User::where('mobile_number', '=', $request->mobile_number)->count();
                if($Ph_check==0){
                    $NewUser                = new User();
                    if($request->user_type=='user'){
                        $NewUser->name          = $request->name;
                    }else{
                        $NewUser->name          = $request->company_name;
                        $NewUser->company_name  = $request->company_name;
                    }
                    $NewUser->user_type     = $request->user_type;
                    $NewUser->email         = $request->email;
                    $NewUser->mobile_number = $request->mobile_number;
                    $NewUser->password      = Hash::make($request->password);
                    if($request->has('referel_code')){
                        $NewUser->referel_code  = $request->referel_code;
                    }
                    $NewUser->save();
                    $user_id = $NewUser->id;
                    $UserDetail_Check = UserDetail::where('user_id','=',$user_id)->first();
                    if(is_null($UserDetail_Check)){
                        $otp                            = Generate_Otp();
                        $NewUser_Detail                 = new UserDetail();
                        $NewUser_Detail->user_id        = $user_id;
                        $NewUser_Detail->mobile_otp     = $otp;
                        $NewUser_Detail->email_otp      = $otp;
                        $NewUser_Detail->first_name     = $NewUser->name;
                        $NewUser_Detail->pan_attempts   = 0;
                        $NewUser_Detail->save();
                    }else{
                        $otp                            = Generate_Otp();
                        $UserDetail_Check->sms_otp      = $otp;
                        $UserDetail_Check->email_otp    = $otp;
                        $UserDetail_Check->first_name   = $NewUser->name;
                        $UserDetail_Check->pan_attempts = 0;
                        $UserDetail_Check->save();
                    }
                    $message='Please enter otp';
                    $data = array('otp'=>$otp,'user_id'=>$user_id);
                    $status = $this->succ;
                }else{
                    $success=0;
                    $message='Mobile number already existed';
                    $status = $this->err;
                }
            }else{
                $success=0;
                $message='Email is already existed';
                $status = $this->err;
            }
        }
        $resp = array('success'=>$success,'message'=>$message,'data'=>$data);
        return response()->json($resp, $status);
    }
    public function resend_otp(Request $request){
        $data=array();
        $message='';
        $success=1;
        $validator = Validator::make($request->all(), [ 
            'type' => 'required', 
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            $message = 'Please enter all (*) fields';
            $status = $this->err;
        }else{
            $UserDetail_Check = UserDetail::where('user_id','=',$request->user_id)->first();
            if($request->type=='email'){
                $UserDetail_Check->sms_otp                        = Generate_Otp();
            }else{
                $UserDetail_Check->email_otp                      = Generate_Otp();
            }
            $UserDetail_Check->save();
            $message = 'Otp sent successfully';
            $status = $this->succ;
        }
        $resp = array('success'=>$success,'message'=>$message,'data'=>$data);
        return response()->json($resp, $status);
    }
    public function Check_Otp(Request $request){
        $data=array();
        $message='';
        $success=1;
        $validator = Validator::make($request->all(), [ 
            'otp' => 'required', 
            'user_id' => 'required',
            'type' => 'required',
        ]);
        if ($validator->fails()) {
            $message = 'Please enter all (*) fields';
            $status = $this->err;
        }else{
            if($request->type=='mobile'){
                $UserDetail_Check = UserDetail::where([['user_id','=',$request->user_id],['mobile_otp','=',$request->otp]])->count();
            }else{
                $UserDetail_Check = UserDetail::where([['user_id','=',$request->user_id],['email_otp','=',$request->otp]])->count();
            }
            if($UserDetail_Check>0){
                $message = 'Otp validated successfully';
                $status = $this->succ;
            }else{
                $success=0;
                $message = 'Invalid otp';
                $status = $this->err;
            }
        }
        $resp = array('success'=>$success,'message'=>$message,'data'=>$data);
        return response()->json($resp, $status);
    }
    public function Otp_Verification(Request $request){
        $data = array();
        $validator = Validator::make($request->all(), [
			'user_id' => 'required',
			'mobile_otp' => 'required',
		]);
        if ($validator->fails()) {
            $return = array("success" => 0, "message" => "fields marked * were mandatory");
            $status = $this->err;
		}else{
            $Mb_Check = UserDetail::where('user_id','=',$request->user_id)->where('mobile_otp','=',$request->mobile_otp)->count();
            if($Mb_Check>0){ 
                    $UserDetails = UserDetail::where('user_id','=',$request->user_id)->first();
                    $curr_dt = curr_dt();
                    $UserDetails->mobile_verified_at = $curr_dt;
                    $UserDetails->acc_number       = Acc_No_Generate();
                    $UserDetails->save();
                    User::where('id','=',$request->user_id)->update(array('is_active'=>'active'));
                    $data['user_id']=$request->user_id;
                    $return = array("success" =>1, "message" => "Otp verified successfully",'data'=>$data);
                    $status = $this->succ;
            }else{
                $return = array("success" => 0, "message" => "Invalid mobile number otp", 'data'=>$data);
                $status = $this->err;
            }
        }
        return response()->json($return, $status);
    }
    public function pan_adhar_verification(Request $request){
        $data = array();
        $validator = Validator::make($request->all(), [
			'user_id' => 'required',
			'pan_number' => 'required',
			'adhar_number'=> 'required',
		]);
        $name='';
        if ($validator->fails()) {
            $return = array("success" => 0, "message" => "fields marked * were mandatory");
            $status = $this->err;
		}else{
            $UserDetails = UserDetail::where('user_id','=',$request->user_id)->first();
            $pan_check=1;
            $pan_name='';
            $name = $pan_name;
            if($pan_check==1){
                $pan_response='test';
                $curr_dt = curr_dt();
                $Adhar = 1;
                if($Adhar==1){
                    $adhar_otp = 1;
                    $adhar_name='';
                    $adhar_response='';
                    if(strtolower(trim($adhar_name))==strtolower(trim($pan_name))){
                        $UserDetails->adhar_otp        = $adhar_otp;
                        $UserDetails->adhar_response   = $adhar_response;
                        User::where('user_id','=',$request->user_id).update(array('name'=>$name));
                        $return = array("success" => 1, "message" => "Pan && adhar verified successfully" ,'data'=>$data);
                        $status = $this->succ;
                    }else{
                        $return = array("success" => 1, "message" => "Pan and adhar names not matched try again" ,'data'=>$data);
                        $status = $this->err;
                    }
                }else{
                    $return = array("success" => 1, "message" => "Pan verified successfully and invalid adhar number" ,'data'=>$data);
                    $status = $this->err;
                }
                $UserDetails->pan_verified_at   = $curr_dt;
                $UserDetails->pan_response      = $pan_response;
            }else{
                $return = array("success" => 0, "message" => "Invalid pan nunber" ,'data'=>$data);
                $status = $this->err;
            }
            $UserDetails->pan_number    = $pan_number;
            $UserDetails->adhar_number  = $adhar_number;
            $UserDetails->pan_attempts  = $UserDetails->pan_attempts+1;
            $UserDetails->first_name    = $name;
            $UserDetails->save();
        }
        return response()->json($return, $status);
    }
    public function user_change_password(Request $request){
		$validator = Validator::make($request->all(), [
			'old_password' => 'required',
			'new_password' => 'required',
			'confirm_new_password'=> 'required',
		]);
		if ($validator->fails()) {
            $return = array("success" => 0, "message" => "fields marked * were mandatory");
            $status = $this->err;
		}else{
            $userid = login_User_ID();
            
            $old_password=$request->old_password;
            $new_password=$request->new_password;
            $confirm_new_password=$request->confirm_new_password;
            $Ucheck=User::find($userid);
            $request['mobile_number'] = $Ucheck->mobile_number;
            if($new_password == $confirm_new_password){
                if(Hash::check($old_password, auth()->user()->password)){
                    $Ucheck->password = bcrypt($new_password);
                    $Ucheck->save();
                    $return = array("success" => 1, "message" => "Password changed successfully");
                    $status = $this->succ;
                }else{
                    $return = array("success" => 0, "message" => "Invalid old password");
                    $status = $this->err;
                }
            }else{
                $return = array("success" =>0, "message" => "Password not matched.");
                $status = $this->err;
            }
        }
		return response()->json($return, $status);
    }
    public function add_or_change_tpin(Request $request){
		$validator = Validator::make($request->all(), [
			'tpin_pin' => 'required',
		]);
		if ($validator->fails()) {
            $return = array("success" => 0, "message" => "fields marked * were mandatory");
            $status = $this->err;
		}else{
            $userid = login_User_ID();
            $UserDetail = UserDetail::where('user_id','=',$userid)->first();
            if(is_null($UserDetail->tpin)){
                $type = 'added';
            }else{
                $type = 'updated';
            }
            $UserDetail->tpin = $request->tpin_pin;
            $UserDetail->save();
            $return = array("success" => 1, "message" => "Pin ".$type." successfully");
            $status = $this->succ;
        }
		return response()->json($return, $status);
    }
    public function check_pan_adhar_tpin_status(Request $request){
        $userid = login_User_ID();
        $pan_status  = UserDetail::where('user_id','=',$userid)->whereNotNull('pan_verified_at')->count();
        $adr_status  = UserDetail::where('user_id','=',$userid)->whereNotNull('adhar_verified_at')->count();
        $tpin_status = UserDetail::where('user_id','=',$userid)->whereNotNull('tpin')->count();
        $data['pan_status']      = ($pan_status>0)?1:0;
        $data['adhar_status']   = ($adr_status>0)?1:0;
        $data['tpin_status']    = ($tpin_status>0)?1:0;
        $return = array("success" =>1, "message" =>"","data"=>$data);
        return response()->json($return, $this->succ);
    }
    public function check_tpin_generated_or_not(Request $request){
        $userid = login_User_ID();
        $tpin_status = UserDetail::where('user_id','=',$userid)->whereNotNull('tpin')->count();
        $data['tpin_status'] = ($tpin_status>0)?1:0;
        $return = array("success" =>1, "message" =>"","data"=>$data);
        return response()->json($return, $this->succ);
    }
    public function check_tpin_valid_or_not(Request $request,$tpin){
        $userid = login_User_ID();
        $tpin_status  = UserDetail::where('user_id','=',$userid)->where('tpin','=',$tpin)->count();
        $tpin_status  = ($tpin_status>0)?1:0;
        $data['tpin_status']=$tpin_status;
        $return = array("success" =>1, "message" =>"","data"=>$data);
        return response()->json($return, $this->succ);
    }
    public function verify_adhar_or_resend_otp(Request $request,$adharnumber){
        $userid = login_User_ID();
        $status  = $this->err;
        $success = 0;
        $data    = array();
        if($adharnumber!=''){
            $YOUR_TOKEN=1;
            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://kyc-api.aadhaarkyc.io/api/v1/aadhaar-v2/generate-otp',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS =>'{
                "id_number": "'.$adharnumber.'"
              }',
              CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer '.$YOUR_TOKEN
              ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            if($response!=''){
                $resp = json_decode($response,true);
                if(trim($resp['success'])==true){
                    $data = $resp['data'];
                    $UserDetails = UserDetail::where('user_id',$userid)->first();
                    $UserDetails->adhar_response = $response;
                    $UserDetails->save();
                    $return = array("success" =>1, "message" =>"Otp sent to register mobile number","data"=>$data);
                }else{
                    $return = array("success" =>0, "message" =>$resp['message'],"data"=>$data);
                }
            }else{
                $return = array("success" =>0, "message" =>"Try again","data"=>$data);
            }
        }else{
            $return = array("success" =>0, "message" =>"Please enter adharnumber","data"=>$data);
        }
        return response()->json($return, $status);
    }
    public function submit_adhar_with_otp(Request $request){
        $userid = login_User_ID();
        $YOUR_TOKEN=1;
        $data=array();
        $message='';
        $success=0;
        $status = $this->err;
        $validator = Validator::make($request->all(), [
            'mobile' => 'required',
            'password' => 'required'
        ]);
        if($validator->fails()) {
            $message = 'Please enter all (*) fields';
        }else{
            $client_id      = $request->client_id;
            $mobile_number  = $request->mobile_number;
            $otp            = $request->otp;
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://kyc-api.aadhaarkyc.io/api/v1/aadhaar-v2/submit-otp',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "client_id": "'.$client_id.'",
                "otp": "'.$otp.'",
                "mobile_number": "'.$mobile_number.'"
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer '.$YOUR_TOKEN
            ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            if($response!=''){
                $resp = json_decode($response,true);
                if(trim($resp['status_code'])==200){
                    $data = $resp['data'];
                    $UserDetails = UserDetail::where('user_id',$userid)->first();
                    $UserDetails = UserDetail::where('user_id',$userid)->first();
                    if(!is_null($UserDetails->aadhaar_number)){
                        $Pan_Det    = $UserDetails->pan_response;
                        $Pan_Arr_Dt = json_decode($Pan_Det,true);
                        $pan_name   = trim(strtolower($Pan_Arr_Dt['full_name']));
                        $adhar_name = trim(strtolower($data['full_name']));
                        if($pan_name==$adhar_name){
                            UserDetail::where('user_id',$userid)->update(['adhar_number'=>$data['aadhaar_number'],'adhar_verified_at'=>$date('Y-m-d H:i:s'),'adhar_response'=>$response]);
                            $return = array("success" =>1, "message" =>"Adhar verified successfully","data"=>$data);
                        }else{
                            $return = array("success" =>0, "message" =>"Adhar name not matching with pan please verify proper pancard first","data"=>$data);
                        }
                    }else{
                        $return = array("success" =>0, "message" =>"Please verify pan card","data"=>$data);
                    }
                }else{
                    $return = array("success" =>0, "message" =>$resp['message'],"data"=>$data);
                }
            }else{
                $return = array("success" =>$success, "message" =>"Invalid otp","data"=>$data);
            }
        }
        $return = array("success" =>$success, "message" =>$message,"data"=>$data);
        return response()->json($return, $status);
    }
    public function verify_pan(Request $request,$pannumber){
        $YOUR_TOKEN=1;
        $data = array();
        if($pannumber!=''){
            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://kyc-api.aadhaarkyc.io/api/v1/pan/pan',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS =>'{
                "id_number": "'.$pannumber.'"
            }',
              CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization:Bearer '.$YOUR_TOKEN
              ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            if($response!=''){
                $resp = json_decode($response,true);
                if(trim($resp['status_code'])==200){
                    $data = $resp['data'];
                    $pan_number = $data['pan_number'];
                    $full_name  = $data['full_name'];
                    $client_id  = $data['client_id'];
                    $userid     = login_User_ID();
                    $Us_Detail  = User::find($userid);
                    UserDetail::where('user_id',$userid)->update(['pan_number'=>$pan_number,'pan_verified_at'=>$date('Y-m-d H:i:s'),'pan_response'=>$response]);
                    $return = array("success" =>1, "message" =>'Pan verified successfully',"data"=>$data);
                    $status = $this->succ;
                }else{
                    $return = array("success" =>0, "message" =>$resp['message'],"data"=>$data);
                    $status = $this->err;
                }
            }else{
                $return = array("success" =>0, "message"=>"Try again","data"=>$data);
                $status = $this->err;
            }
        }else{
            $return = array("success" =>0, "message" =>"Please enter pannumber","data"=>$data);
            $status = $this->err;
        }
        return response()->json($return, $status);
    }
    public function forgot_password(Request $request){
        $data=array();
        $status = $this->err;
        $message='';
        $success=0;
        $validator = Validator::make($request->all(),['mobile' => 'required']);
        if($validator->fails()) {
            $message = 'Mobile number is required';
        }else{
            $Check_Mobile = User::where('mobile_number','=',$request->mobile)->first();
            if(is_null($Check_Mobile)){
                $message = 'Invalid mobile number';
            }else{
                $otp = Generate_Otp();
                $User_Detail = UserDetail::where('user_id','=',$Check_Mobile->id)->first();
                $User_Detail->email_otp  = $otp;
                $User_Detail->mobile_otp = $otp;
                $User_Detail->save();
                $success = 1;
                $status = $this->succ;
                $message = 'Your new password sent to registered mobilenumber successfully';
            }
        }
        $resp = array('success'=>$success,'message'=>$message,'data'=>$data);
        return response()->json($resp, $status);
    }
    public function upload_photo(Request $request){

    }
    public function update_contact_details(Request $request){
        $userid = login_User_ID();
        $data=array();
        $status = $this->err;
        $message='';
        $success=0;
        $validator = Validator::make($request->all(),[
            'address'       => 'required',
            'pincode'       => 'required',
            'country_id'    => 'required',
            'state_id'      => 'required',
            'city_id'       => 'required'
        ]);
        if($validator->fails()) {
            $message = 'Please enter all (*) fields';
        }else{
            $User_Detail = UserDetail::where('user_id','=',$userid)->first();
            $User_Detail->address       = $address;
            $User_Detail->pincode       = $pincode;
            $User_Detail->country_id    = $country_id;
            $User_Detail->state_id      = $state_id;
            $User_Detail->city_id       = $city_id;
            $User_Detail->save();
            $message = 'Contact details added successfully';
        }
        $resp = array('success'=>$success,'message'=>$message,'data'=>$data);
        return response()->json($resp, $status);
    }
    public function user_details(Request $request){
        $userid = login_User_ID();
        $User = User::with('user_details')->find($userid);
        $resp = array('success'=>1,'message'=>'','data'=>$User);
        return response()->json($resp, $this->succ);
    }
}
