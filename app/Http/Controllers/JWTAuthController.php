<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDetail;

class JWTAuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt', ['except' => ['login', 'signup']]);
    }
    public $succ = 200;
    public $err  = 202;
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'mobile_number' => 'required',
            'password' => 'required'
        ]);
        $data=array();
        $message='';
        $success=0;
        if($validator->fails()) {
            $message = 'Please enter all (*) fields';
            $status = $this->err;
        }else{
            $token = auth('api')->attempt($validator->validated());
            if($token!=false){
                $message = 'Logined successfully';
                $data['token'] = $this->createNewToken($token);
                $data['userdetails'] = auth('api')->user();
                $status = $this->succ;
                $success=1;
            }else{
                $message = 'Invalid credentials';
                $status = $this->err;
            }
        }
        $result = array('success'=>$success, 'data'=>$data , 'message'=>$message);
        return response()->json($result, $status);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function user_details()
    {
        $userid = login_User_ID();
        $User = User::with('user_details')->find($userid);
        $resp = array('success'=>1,'message'=>'','data'=>$User);
        return response()->json($resp, $this->succ);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ];
    }
}
