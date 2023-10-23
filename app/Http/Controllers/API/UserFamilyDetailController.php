<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Commonreturn as CommonreturnResource;
use App\Models\UserFamilyDetail;

class UserFamilyDetailController extends Controller
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
                'family_type' => 'nullable',
                'full_name' => 'required',
                'dob' => 'required',
                'relation_id' => 'required',
                'rasi_id' => 'required',
                'gothram' => 'required',
                'nakshatram' => 'required',
                'description' => 'required'
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
                                'family_type'=>$request->family_type,
                                'full_name'=>$request->family_type
                            );
                            if(UserFamilyDetail::where($WhereArr)->exists()){
                                $success = 0;
                                $message = "family_type and full_name should be unique";
                            }else{
                                $data = UserFamilyDetail::create($request->all());
                                $message = "Added successfully";
                            }
                        }else{
                            $data = UserFamilyDetail::where('id',$id)->update($request->all());
                            if($data>0){
                                $message = "Updated successfully";
                            }else{
                                $message = "Updating failed";
                            }
                            $data = UserFamilyDetail::find($id);
                        }
                    } catch (\Exception $ex) {
                        $message =  ERRORMESSAGE($ex->getMessage());
                    }
                }else{
                    $message = "Please send atleast one column";
                }
            }
        }else{
            $data = UserFamilyDetail::query();
            if($request->has('is_kartha')){
                if($request->get('is_kartha')==1 || $request->get('is_kartha')==true){
                    $data = $data->where('family_type','kartha');
                }else{
                    $data = $data->where('family_type','!=','kartha');
                }
            }
            if($request->has('is_ancestors')){
                if($request->get('is_ancestors')==1 || $request->get('is_ancestors')==true){
                    $data = $data->where('family_type','ancestors');
                }else{
                    $data = $data->where('family_type','!=','ancestors');
                }
            }
            if($request->has('is_kartha_ancestors')){
                if($request->get('is_kartha_ancestors')==1 || $request->get('is_kartha_ancestors')==true){
                    $data = $data->where('family_type','kartha_ancestors');
                }else{
                    $data = $data->where('family_type','!=','kartha_ancestors');
                }
            }
            if($request->has('is_my_family')){
                if($request->get('is_my_family')==1 || $request->get('is_my_family')==true){
                    $data = $data->where('family_type',NULL)->or_where('family_type', '');
                }else{
                    $data = $data->where('family_type','!=','')->or_where('family_type','!=',NULL);
                }
            }
            $data = $data->where('user_id',$userid);
            $data = $data->with('rasi')->with('relation');
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
