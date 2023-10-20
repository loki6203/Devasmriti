<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Commonreturn as CommonreturnResource;
use App\Models\Event;

class EventSevaController extends Controller
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
        $data = Event::query();
        $data = $data
        ->with('banner_image_id')
        ->with('background_image_id')
        ->with('feature_image_id')
        ->with('event_faqs')
        ->with('event_updates')
        ->with('sevas')
        ->with('sevas.temple')
        ->with('sevas.seva_type')
        ->with('sevas.anouncements')
        ->with('sevas.seva_faqs')
        ->with('sevas.seva_prices')
        ->with('sevas.background_image_id')
        ->with('sevas.feature_image_id')
        ->with('sevas.banner_image_id')
        ->with('sevas.seva_updates');
        // if($request->has('state_id')){
        //     $data = $data->where('state_id',$request->get('state_id'));
        // }
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