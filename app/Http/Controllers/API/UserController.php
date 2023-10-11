<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Commonreturn as CommonreturnResource;
use App\Models\User;
use App\Models\Image;
use App\Models\UserReward;

class UserController extends Controller
{
    public $succ = 200;
    public $err  = 202;
    public function __construct(){
        // $this->middleware('jwt', ['except' => ['login_signup','login_with_otp']]);
    }
    public function login_signup(Request $request){
        $data=array();
        $message='Please login with otp';
        $success=1;
        $validator = Validator::make($request->all(), [
            'mobile_number' => 'required'
        ]);
        if ($validator->fails()) {
            $message = 'Please enter all (*) fields';
            $status = $this->err;
            $success=0;
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
            $message = $validator->errors()->first();
            $status  = $this->err;
            $success = 0;
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
    public function profile_update(Request $request,$id=0){
        $data=array();
        $message='';
        $success=1;
        $userid = login_User_ID();
        try{
            if($request->method()=="PUT"){
                $data = User::where('id',$userid)->update($request->all());
                if($data>0){
                    $message = "Updated successfully";
                }else{
                    $message = "Updating failed";
                }
                $data           = User::where('id',$userid)->with('image')->first();
                $credited       = UserReward::where('user_id',$userid)->where('is_credited',1)->sum('points');
                $debited        = UserReward::where('user_id',$userid)->where('is_credited',0)->sum('points');
                $rewars         = $credited-$debited;
                $data['wallet'] = ($rewars>0)?$rewars:0;
            }else if($request->method()=="POST"){
                $file = @$request->file('file');
                if ($file != '' && $file != null && $file != 'undefined') {
                    if (!file_exists(public_path('User'))){
                        mkdir(public_path('User'),0777,true);
                    }
                    $destinationPath = public_path('User');
                    $url = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                    $file->move($destinationPath,$url);
                    $orgname = $file->getClientOriginalName();
                    $data = new Image();
                    $data->url          = $destinationPath.'/'.$url;
                    $data->domain       = url('/');
                    $data->image_type   = 'User';
                    $data->name         = $orgname;
                    $data->save();
                }else{
                    $success=0;
                    $message = "Uploading failed try again";
                }
            }else{
                $data           = User::where('id',$userid)->with('image')->first();
                $credited       = UserReward::where('user_id',$userid)->where('is_credited',1)->sum('points');
                $debited        = UserReward::where('user_id',$userid)->where('is_credited',0)->sum('points');
                $rewars         = $credited-$debited;
                $data['wallet'] = ($rewars>0)?$rewars:0;
            }
        } catch (\Exception $ex) {
            $message =  ERRORMESSAGE($ex->getMessage());
        }
        $resp = array('success'=>$success,'message'=>$message,'data'=>$data);
        return new CommonreturnResource($resp);
    }
}
