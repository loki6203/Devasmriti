<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Commonreturn as CommonreturnResource;

use App\Models\UserCart;

class UserCartController extends Controller
{
	public $succ = 200;
    public $err  = 202;
    public function __construct(){
        // $this->middleware('jwt', ['except' => ['login_signup','login_with_otp']]);
    }
    public function index(Request $request,$id=0){
        $data=array();
        $message='';
        $success=1;
        $userid = login_User_ID();
        if($request->method()=="POST" || $request->method()=="PUT"){
            $required = [
                "user_id"    => ['required|numeric','array'],
                "seva_id"    => ['required|numeric','array'],
                "seva_price_id"    => ['required|numeric','array'],
                "qty"    => ['required|numeric','array']
            ];
            if($request->method()=="PUT"){
                $required = [];
            }
            $validator = Validator::make($request->all(),$required);
            if($validator->fails()){
                $message = $validator->errors()->first();
                $status  = $this->err;
                $success = 0;
            }else{
                if(!empty($request->all())){
                    try {
                        if($request->method()=="POST"){
                            // $request['user_id']=$userid;
                            $data = UserCart::create($request->all());
                            $message = "Added successfully";
                        }else{
                            $data = UserCart::where('id',$id)->update($request->all());
                            $message = "Updated successfully";
                        }
                    } catch (\Exception $ex) {
                        $message =  ERRORMESSAGE($ex->getMessage());
                    }
                }else{
                    $message = "Please send atleast one column";
                }
            }
        }else{
            $data = UserCart::query();
            $data = $data->with('seva')->with('seva_price');
            if($id==0){
                if($request->method()=="DELETE"){
                    $data = $data->where('user_id',$userid)->forceDelete();
                }else{
                    $PAGINATELIMIT = PAGINATELIMIT($request);
                    $data = $data->paginate($PAGINATELIMIT);
                }
            }else{
                $data = $data->find($id);
                if($request->method()=="DELETE"){
                    $data->delete();
                    $message = "Deleted successfully";
                }
            }
        }
        $resp = array('success'=>$success,'message'=>$message,'data'=>$data);
        return new CommonreturnResource($resp);
    }
}
