<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\UserDetail;

class UserController extends Controller 
{
    public $successStatus = 200;
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
        return response()->json($result, $this->successStatus);
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
        }else{
            if(Auth::attempt(['mobile_number'=>$request->mobile,'password'=>$request->password])){
                $user = Auth::user();
                $request->user()->tokens()->delete();
                $client = \Laravel\Passport\Client::where('password_client', 1)->first();
                $request->request->add([
                    'grant_type' => 'password',
                    'client_id' => $client->id,
                    'client_secret' => $client->secret,
                    'scope' => null,
                    'username' => request('email'),
                    'password' => request('password'),
                ]);
                $proxy = Request::create('oauth/token','POST');
                $tokens = \Route::dispatch($proxy);
                $tokrnresponse = (array) $tokens->getContent();
                $tokendata = json_decode($tokrnresponse[0]);
                $request->user()->tokens()->update([
                    'access_token' => $tokendata->access_token,
                    'expires_in' => $tokendata->expires_in,
                    'refresh_token' => $tokendata->refresh_token
                ]);
                $message = 'Logined successfully';
                $data['token'] =$tokendata->access_token;
                $data['userdetails'] =$user;
            }else{
                $message = 'Invalid credentials';
            }
        }
        $result = array('success'=>$success, 'data'=>$data , 'message'=>$message);
        return response()->json($result, $this->successStatus);
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
                        $sms_otp                        = Generate_Otp();
                        $email_otp                      = Generate_Otp();
                        $NewUser_Detail                 = new UserDetail();
                        $NewUser_Detail->user_id        = $user_id;
                        $NewUser_Detail->mobile_otp     = $email_otp;
                        $NewUser_Detail->email_otp      = $sms_otp;
                        $NewUser_Detail->first_name     = $NewUser->name;
                        $NewUser_Detail->save();
                    }else{
                        $UserDetail_Check->sms_otp      = Generate_Otp();
                        $UserDetail_Check->email_otp    = Generate_Otp();
                        $NewUser_Detail->first_name     = $NewUser->name;
                        $UserDetail_Check->save();
                    }
                    $message='Please enter email and sms otp';
                    $data = array('sms'=>$sms_otp,'email'=>$email_otp,'user_id'=>$user_id);
                }else{
                    $success=0;
                    $message='Mobile number already existed';
                }
            }else{
                $success=0;
                $message='Email is already existed';
            }
        }
        $resp = array('success'=>$status,'message'=>$message,'data'=>$data);
        return response()->json($resp, $this->successStatus);
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
        }else{
            $UserDetail_Check = UserDetail::where('user_id','=',$request->user_id)->first();
            if($request->type=='email'){
                $UserDetail_Check->sms_otp                        = Generate_Otp();
            }else{
                $UserDetail_Check->email_otp                      = Generate_Otp();
            }
            $UserDetail_Check->save();
            $message = 'Otp sent successfully';
        }
        $resp = array('success'=>$success,'message'=>$message,'data'=>$data);
        return response()->json($resp, $this->successStatus);
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
        }else{
            if($request->type=='mobile'){
                $UserDetail_Check = UserDetail::where('user_id','=',$request->user_id,'mobile_otp','=',$request->otp)->count();
            }else{
                $UserDetail_Check = UserDetail::where('user_id','=',$request->user_id,'email_otp','=',$request->otp)->count();
            }
            if($UserDetail_Check>0){
                $message = 'Otp validated';
            }else{
                $success=0;
                $message = 'Invalid otp';
            }
        }
        $resp = array('success'=>$success,'message'=>$message,'data'=>$data);
        return response()->json($resp, $this->successStatus);
    }
    public function Otp_Verification(Request $request){
        $data = array();
        $validator = Validator::make($request->all(), [
			'user_id' => 'required',
			'mobile_otp' => 'required',
			'email_otp'=> 'required',
		]);
        if ($validator->fails()) {
            $return = array("success" => 0, "message" => "fields marked * were mandatory");
		}else{
            $Mb_Check = UserDetail::where('user_id','=',$request->user_id,'mobile_otp','=',$request->mobile_otp)->count();
            if($Mb_Check>0){
                $Em_Check = UserDetail::where('user_id','=',$request->user_id,'email_otp','=',$request->email_otp)->count();
                if($Em_Check>0){
                    $UserDetails = UserDetail::where('user_id','=',$request->user_id)->first();
                    $curr_dt = curr_dt();
                    $UserDetails->email_verified_at  = $curr_dt;
                    $UserDetails->mobile_verified_at = $curr_dt;
                    $UserDetails->acc_number       = Acc_No_Generate();
                    $UserDetails->save();
                    User::where('user_id','=',$request->user_id).update(array('is_active'=>'active'));
                    $data['user_id']=$request->user_id;
                    $return = array("success" =>1, "message" => "Otp verified successfully,Please enter pan and adhar numbers",'user_id'=>$request->user_id , 'data'=>$data);
                }else{
                    $return = array("success" => 0, "message" => "Invalid emailid otp", 'data'=>$data);
                }
            }else{
                $return = array("success" => 0, "message" => "Invalid mobile number otp", 'data'=>$data);
            }
        }
        return response()->json($return, $this->successStatus);
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
                    }else{
                        $return = array("success" => 1, "message" => "Pan and adhar names not matched try again" ,'data'=>$data);
                    }
                }else{
                    $return = array("success" => 1, "message" => "Pan verified successfully and invalid adhar number" ,'data'=>$data);
                }
                $UserDetails->pan_verified_at   = $curr_dt;
                $UserDetails->pan_response      = $pan_response;
            }else{
                $return = array("success" => 0, "message" => "Invalid pan nunber" ,'data'=>$data);
            }
            $UserDetails->pan_number    = $pan_number;
            $UserDetails->adhar_number  = $adhar_number;
            $UserDetails->pan_attempts  = $UserDetails->pan_attempts+1;
            $UserDetails->first_name    = $name;
            $UserDetails->save();
        }
        return response()->json($return, $this->successStatus);
    }
    public function user_change_password(Request $request){
		$validator = Validator::make($request->all(), [
			'old_password' => 'required',
			'new_password' => 'required',
			'confirm_new_password'=> 'required',
		]);
		if ($validator->fails()) {
            $return = array("success" => 0, "message" => "fields marked * were mandatory");
		}else{
            $userid = login_User_ID();
            $old_password=($request->input('old_password'));
            $new_password=$request->input('new_password');
            $confirm_new_password=$request->input('confirm_new_password');
            $Ucheck=User::find($userid);
            if($new_password == $confirm_new_password){
                if(Auth::attempt(['email'=>$Ucheck->email, 'password'=>$old_password]) ){
                    $Ucheck->password =bcrypt($new_password);
                    $Ucheck->save();
                    $return = array("success" => 1, "message" => "Password changed successfully");
                }else{
                    $return = array("success" => 0, "message" => "Invalid old password");
                }
            }else{
                $return = array("success" =>0, "message" => "Password not matched.");
            }
        }
		return response()->json($return, $this->successStatus);
    }
    public function add_or_change_tpin(Request $request){
		$validator = Validator::make($request->all(), [
			'tpin_pin' => 'required',
		]);
		if ($validator->fails()) {
            $return = array("success" => 0, "message" => "fields marked * were mandatory");
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
        }
		return response()->json($return, $this->successStatus);
    }
    public function check_pan_adhar_tpin_status(Request $request){
        $userid = login_User_ID();
        $pan_status  = UserDetail::where('user_id','=',$request->user_id)->whereNotNull('pan_verified_at')->count();
        $adr_status  = UserDetail::where('user_id','=',$request->user_id)->whereNotNull('adhar_verified_at')->count();
        $tpin_status = UserDetail::where('user_id','=',$request->user_id)->whereNotNull('tpin')->count();
        $data['pan_stats']      = ($pan_status>0)?1:0;
        $data['adhar_status']   = ($adr_status>0)?1:0;
        $data['tpin_status']    = ($tpin_status>0)?1:0;
        $return = array("success" =>1, "message" =>"","data"=>$data);
        return response()->json(array('data' =>$return), $this->successStatus);
    }
    public function check_tpin_generated_or_not(Request $request){
        $userid = login_User_ID();
        $tpin_status = UserDetail::where('user_id','=',$request->user_id)->whereNotNull('tpin')->count();
        $data['tpin_status'] = ($tpin_status>0)?1:0;
        $return = array("success" =>1, "message" =>"","data"=>$data);
        return response()->json(array('data' =>$return), $this->successStatus);
    }
    public function check_tpin_valid_or_not(Request $request,$tpin){
        $userid = login_User_ID();
        $tpin_status  = UserDetail::where('user_id','=',$request->user_id)->where('tpin','=',$tpin)->count();
        $tpin_status  = ($tpin_status>0)?1:0;
        $data['tpin_status']=$tpin_status;
        $return = array("success" =>1, "message" =>"","data"=>$data);
        return response()->json(array('data' =>$return), $this->successStatus);
    }
}
