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
        ->with('seva_prices')
        ->with('background_image_id')
        ->with('feature_image_id')
        ->with('banner_image_id')
        ->with('seva_updates');
        if($request->has('seva_type_id')){
            $data = $data->where('seva_type_id',$request->get('seva_type_id'));
        }
        if($id==0){
            $PAGINATELIMIT = PAGINATELIMIT($request);
            $data = $data->paginate($PAGINATELIMIT);
        }else{
            $data = $data->find($id);
        }
        $resp = array('success'=>$success,'message'=>$message,'data'=>$data);
        return new CommonreturnResource($resp);
    }
}