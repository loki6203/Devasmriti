<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Commonreturn as CommonreturnResource;

use App\Models\EventFaq;

class EventFaqController extends Controller
{
	public $succ = 200;
    public $err  = 202;
    public function __construct(){
        // $this->middleware('jwt', ['except' => ['login_signup','login_with_otp']]);
    }
    public function index(Request $request,$event_id,$id=0){
        $data=array();
        $message='';
        $success=1;
        $data = EventFaq::query();
        if($event_id>0){
            $data = $data->where('event_id',$event_id);
            if($id==0){
                $PAGINATELIMIT = PAGINATELIMIT($request);
                $data = $data->paginate($PAGINATELIMIT);
            }else{
                $data = $data->find($id);
            }
        }else{
            $message = "event_id is required";
            $success = 0;
        }
        $resp = array('success'=>$success,'message'=>$message,'data'=>$data);
        return new CommonreturnResource($resp);
    }
}
