<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Commonreturn as CommonreturnResource;
use App\Models\User;

class UserController extends Controller
{
    public $succ = 200;
    public $err  = 202;
    public function __construct()
    {
        // $this->middleware('jwt', ['except' => ['login_signup','login_with_otp']]);
    }
    public function login_signup(Request $request) 
    {
        $data=array();
        $message='Please login with otp';
        $success=1;
        $validator = Validator::make($request->all(), [
            'mobile_number' => 'required'
        ]);
        if ($validator->fails()) {
            $message = 'Please enter all (*) fields';
            $status = $this->err;
        }else{
            $password='root@$123';
            $Ph_check = User::where('mobile_number', '=', $request->mobile_number)->first();
            $otp = Generate_Otp();
            if(is_null($Ph_check)){
                $NewUser = new User();
                $NewUser->user_type     = 'user';
                $NewUser->mobile_number = $request->mobile_number;
                $NewUser->password      = Hash::make($password);
                $NewUser->otp = $otp;
                $NewUser->save();
                $user_id = $NewUser->id;
            }else{
                $Ph_check->otp = $otp;
                $Ph_check->save();
                $user_id = $Ph_check->id;
            }
            // SendMsg($request->mobile_number,$otp,1);
            $data = array('otp'=>$otp,'user_id'=>$user_id);
            $status = $this->succ;
        }
        $resp = array('success'=>$success,'message'=>$message,'data'=>$data);
        return new CommonreturnResource($resp);
    }
    public function login_with_otp(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'otp' => 'required'
        ]);
        $data=array();
        $message='';
        $success=0;
        if($validator->fails()) {
            $message = 'Please enter all (*) fields';
            $status = $this->err;
        }else{
            $UserDetail = User::where('otp','=',$request->otp)->where('id','=',$request->user_id)->first();
            if(!is_null($UserDetail)){
                $password='root@$123';
                $token = auth('api')->attempt(['id'=>$UserDetail->id,'password'=>$password]);
                if($token!=false){
                    $message = 'Logined successfully';
                    $data['token'] = $this->createNewToken($token);
                    $data['user'] = auth('api')->user();
                    $status = $this->succ;
                    $success=1;
                    $Email_Arr = array(
                        'subject'=>'Login successfully',
                        'type'=>'login',
                        'mobile'=>$UserDetail->mobile_number,
                        'user_id'=>$data['user']->id
                    );
                    // SendEmail($Email_Arr);
                }else{
                    $message = 'Invalid otp';
                    $status = $this->err;
                }
            }else{
                $message = 'Invalid otp';
                $status = $this->err;
            }
        }
        $resp = array('success'=>$success, 'data'=>$data , 'message'=>$message);
        return new CommonreturnResource($resp);
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
