<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Commonreturn as CommonreturnResource;
use App\Models\UserAddress;

class UserAddressController extends Controller
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
                'fname' => 'required',
                'lname' => 'required',
                'email' => 'required',
                'phone_no' => 'required',
                'whatsup_no' => 'required',
                'country_id' => 'required',
                'state_id' => 'required',
                'city_id' => 'required',
                'address_1' => 'required',
                'address_2' => 'nullable',
                'address_name'=>'required',
                'pincode'=>'required',
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
                            $request['user_id']=$userid;
                            $WhereArr = array(
                                'user_id'=>$request->family_type,
                                'address_name'=>$request->address_name
                            );
                            if(UserAddress::where($WhereArr)->exists()){
                                $success = 0;
                                $message = "address_name already existed";
                            }else{
                                $data = UserAddress::create($request->all());
                            }
                            $message = "Added successfully";
                        }else{
                            $data = UserAddress::where('id',$id)->update($request->all());
                            if($data>0){
                                $message = "Updated successfully";
                            }else{
                                $message = "Updating failed";
                            }
                            $data = UserAddress::find($id);
                        }
                    } catch (\Exception $ex) {
                        $message =  ERRORMESSAGE($ex->getMessage());
                    }
                }else{
                    $message = "Please send atleast one column";
                }
            }
        }else{
            $data = UserAddress::query();
            $data = $data->where('user_id',$userid);
            $data = $data->with('city')->with('country')->with('state');
            if($id==0){
                $PAGINATELIMIT = PAGINATELIMIT($request);
                $data = $data->paginate($PAGINATELIMIT);
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
