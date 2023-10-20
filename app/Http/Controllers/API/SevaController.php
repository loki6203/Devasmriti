<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Commonreturn as CommonreturnResource;
use App\Models\Seva;

class SevaController extends Controller
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
        if($userid!='' && $userid>0){
            $userid = $userid;
        }else{
            $userid = 0;
        }
        $data = Seva::query();
        if($request->has('is_suggested') && $request->get('is_suggested')==1){
            if($id>0){

            }else{
                if($request->has('event_id')){
                    
                }else{

                }
            }
        }
        $data = $data
        ->with('temple')
        ->with('seva_type')
        ->with('anouncements')
        ->with('seva_faqs')
        ->with('background_image_id')
        ->with('feature_image_id')
        ->with('banner_image_id')
        ->with('seva_updates')
        ->with('seva_prices');
        $data = $data->withCount(['user_carts' => function ($q) use ($userid) {
            $q->where('user_id',$userid);
        }]);
        $data = $data->with(["seva_prices.user_carts" => function ($q) use ($userid) {
            $q->where('user_id',$userid);
        }]);
        if($request->has('seva_type_id')){
            $data = $data->where('seva_type_id',$request->get('seva_type_id'));
        }
        if($id==0){
            $data = $data->orderBy('ordering_number', 'ASC');
            $PAGINATELIMIT = PAGINATELIMIT($request);
            $data = $data->paginate($PAGINATELIMIT);
        }else{
            $data = $data->find($id);
        }
        $resp = array('success'=>$success,'message'=>$message,'data'=>$data);
        return new CommonreturnResource($resp);
    }
}
