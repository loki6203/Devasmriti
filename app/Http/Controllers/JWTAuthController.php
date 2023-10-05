<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Validator;
// use App\Http\Resources\Commonreturn as CommonreturnResource;

class JWTAuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt', ['except' => ['login', 'login_with_otp','check_referal_code','login_with_otp']]);
    }
    public $succ = 200;
    public $err  = 202;
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request) 
    {
        $data=array();
        $message='';
        $success=1;
        $validator = Validator::make($request->all(), [
            'mobile_number' => 'required'
        ]);
        if ($validator->fails()) {
            $message = 'Please enter all (*) fields';
            $status = $this->err;
        }else{
            $password='root@$123';
            $Ph_check = User::where('mobile_number', '=', $request->mobile_number)->count();
            if($Ph_check==0){
                $NewUser->user_type     = 'user';
                $NewUser->mobile_number = $request->mobile_number;
                $NewUser->password      = Hash::make($password);
                $NewUser->save();
                $user_id = $NewUser->id;
            }else{
                $user_id = $Ph_check->id;
            }
            // SendMsg($request->mobile_number,$otp,1);
            $data = array('otp'=>$otp,'user_id'=>$user_id);
            $status = $this->succ;
        }
        $resp = array('success'=>$success,'message'=>$message,'data'=>$data);
        return response()->json($resp, $status);
        // return new CommonreturnResource($resp);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    // public function login(Request $request)
    // {
    // 	$validator = Validator::make($request->all(), [
    //         'mobile_number' => 'required',
    //         'password' => 'required'
    //     ]);
    //     $data=array();
    //     $message='';
    //     $success=0;
    //     if($validator->fails()) {
    //         $message = 'Please enter all (*) fields';
    //         $status = $this->err;
    //     }else{
    //         $token = auth('api')->attempt($validator->validated());
    //         if($token!=false){
    //             $otp = Generate_Otp();
    //             $message = 'Please enter otp';
    //             $userdetails = auth('api')->user();
    //             $data['user_id'] = $userdetails->id;
    //             $UserDetail_Check = UserDetail::where('user_id','=',$userdetails->id)->first();
    //             $UserDetail_Check->mobile_otp = $otp;
    //             $UserDetail_Check->save();
    //             $data['otp'] = $otp;
    //             SendMsg($request->mobile_number,$otp,1);
    //             $status = $this->succ;
    //             $success=1;
    //         }else{
    //             $message = 'Invalid credentials';
    //             $status = $this->err;
    //         }
    //     }
    //     $result = array('success'=>$success, 'data'=>$data , 'message'=>$message);
    //     return response()->json($result, $status);
    // }
    public function login_with_otp(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'otp' => 'required',
            'password'=>'required'
        ]);
        $data=array();
        $message='';
        $success=0;
        if($validator->fails()) {
            $message = 'Please enter all (*) fields';
            $status = $this->err;
        }else{
            $User = User::find($request->user_id);
            $UserDetail = UserDetail::where('mobile_otp','=',$request->otp)->where('user_id','=',$request->user_id)->first();
            if(!is_null($UserDetail)){
                $token = auth('api')->attempt(['id'=>$User->id,'password'=>$request->password]);
                if($token!=false){
                    $message = 'Logined successfully';
                    $data['token'] = $this->createNewToken($token);
                    $data['userdetails'] = auth('api')->user();
                    $status = $this->succ;
                    $success=1;
                    $Email_Arr = array(
                        'subject'=>'Login successfully',
                        'type'=>'login',
                        'mobile'=>$User->mobile_number,
                        'user_id'=>$data['userdetails']->id,
                        'pwd'=>$request->password
                    );
                    SendEmail($Email_Arr);
                }else{
                    $message = 'Invalid password';
                    $status = $this->err;
                }
            }else{
                $message = 'Invalid otp';
                $status = $this->err;
            }
        }
        $result = array('success'=>$success, 'data'=>$data , 'message'=>$message);
        return response()->json($result, $status);
    }
    public function check_referal_code(Request $request){
        $data=array();
        $message='';
        $success=0;
        $status = $this->err;
        $validator = Validator::make($request->all(), [
            'referel_code' => 'required',
        ]);
        if($validator->fails()) {
            $message = 'Please enter referal code';
        }else{
            $Check = User::where('mobile_number','=',$request->referel_code)->count();
            if($Check){
                $message='Referel code existed';
                $success=1;
                $status = $this->succ;
            }else{
                $message='Referel code not existed';
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
