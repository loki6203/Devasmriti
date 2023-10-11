<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Commonreturn as CommonreturnResource;
use App\Models\City;

class CityController extends Controller
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
        if($request->method()=="POST" || $request->method()=="PUT"){
            $required = [
                'name' => 'required',
                'state_id' => 'required',
            ];
            if($request->method()=="PUT"){$required = [];}
            $validator = Validator::make($request->all(),$required);
            if($validator->fails()){
                $message = $validator->errors()->first();
                $status  = $this->err;
                $success = 0;
            }else{
                if(!empty($request->all())){
                    try {
                        if($request->method()=="POST"){
                            City::update(['is_latest'=>0]);
                            $data = City::create($request->all());
                            $message = "Added successfully";
                        }else{
                            $data = City::where('id',$id)->update($request->all());
                            if($data>0){
                                $message = "Updated successfully";
                            }else{
                                $message = "Updating failed";
                            }
                            $data = City::find($id);
                        }
                    } catch (\Exception $ex) {
                        $message =  ERRORMESSAGE($ex->getMessage());
                    }
                }else{
                    $message = "Please send atleast one column";
                }
            }
        }else{
            $data = City::query();
            $data = $data->with('state.country');
            if($request->has('state_id')){
                $data = $data->where('state_id',$request->get('state_id'));
            }
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
