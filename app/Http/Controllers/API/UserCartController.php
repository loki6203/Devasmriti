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
            if($request->method()=="POST"){
                $required = [
                    'cart'                          => 'present|array',
                    'cart.*.is_prasadam_available'  => 'nullable|boolean',
                    'cart.*.user_id'                => 'required|integer',
                    'cart.*.seva_id'                => 'required|integer',
                    'cart.*.seva_price_id'          => 'required|integer',
                    // 'cart.*.qty'                 => 'required|integer'
                ];
            }else{
                $required = ['is_prasadam_available' => 'required|boolean'];
                // $required = ['qty' => 'required|integer'];
            }
            $validator = Validator::make($request->all(),$required);
            if($validator->fails()){
                $message = $validator->errors()->first();
                $status  = $this->err;
                $success = 0;
            }else{
                if(!empty($request->all())){
                    try {
                        $PostedData = $request->all();
                        if($request->method()=="POST"){
                            $data = [];
                            foreach($PostedData['cart'] as $cart){
                                $data[] =   UserCart::create($cart);
                            }
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
            $data = $data->where('user_id',$userid)->with('seva')->with('seva_price');
            if($id==0){
                if($request->method()=="DELETE"){
                    $data = $data->forceDelete();
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
