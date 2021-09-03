<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Hash;
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
        if($request->email=='' || $request->email =='undefined'){
        return response()->json([
        'token' =>'','user_details'=>array(),'candidate_details'=>array(),'status'=>'0','message'=>'Please enter email id'
        ]);
        }
        if($request->password=='' || $request->password =='undefined'){
        return response()->json([
        'token' =>'','user_details'=>array(),'candidate_details'=>array(),'status'=>'0','message'=>'Please enter password'
        ]);
        }
        if(Auth::attempt(['email'=>$request->email, 'password'=>$request->password])){
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
            $Candidate = Candidate::where('user_id', '=',$user->id)->get();
            $cand = $Candidate[0]->id;
            $user->candidate_id=$cand;
            $token=rand(100000000,1000000000);
            //$token = $user->createToken($request->email.$time)->accessToken;
            $user->api_token=$tokendata->access_token;
            $user->save();
            $cnt = CandidatePlacementOfficer::where('candidate_id','=',$cand)->count();
            $is_placement = ($cnt>0)?1:0;
            return response()->json([
            'token' =>$tokendata->access_token,'is_placement'=>$is_placement,'user_details'=>$user,'candidate_details'=>$Candidate,'status'=>'1','message'=>'Login successfully'
            ]);
        }else{
            return response()->json([
                'token' =>'','is_placement'=>'','user_details'=>array(),'candidate_details'=>array(),'status'=>'0','message'=>'Please enter valid credentials'
            ]);
        }
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
                    $NewUser->name          = $request->name;
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
                        $NewUser_Detail->save();
                    }else{
                        $UserDetail_Check->sms_otp                        = Generate_Otp();
                        $UserDetail_Check->email_otp                      = Generate_Otp();
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
        return response()->json($resp,200);
    }
    public function resend_otp(Request $request , $sms_type){
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
        return response()->json($resp,200);
    }
    public function Check_Otp(Request $request , $sms_type){
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
        return response()->json($resp,200);
    }
    public function Otp_Verification(Request $request){
        
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
		return response()->json(array('data' =>$return),200);
    }
}
