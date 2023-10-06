<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Commonreturn as CommonreturnResource;
use App\Models\Testimonial;

class TestimonialController extends Controller
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
        $data = Testimonial::query();
        // $data = $data->with('state.country');
        // if($request->has('state_id')){
        //     $data = $data->where('state_id',$request->get('state_id'));
        // }
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
