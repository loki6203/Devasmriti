<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Commonreturn as CommonreturnResource;

use App\Models\SevaFaq;

class SevaFaqController extends Controller
{
	public $succ = 200;
    public $err  = 202;
    public function __construct(){
        // $this->middleware('jwt', ['except' => ['login_signup','login_with_otp']]);
    }
    public function index(Request $request,$seva_id,$id=0){
        $data=array();
        $message='';
        $success=1;
        $data = SevaFaq::query();
        if($seva_id>0){
            $data = $data->where('seva_id',$seva_id);
            if($id==0){
                $PAGINATELIMIT = PAGINATELIMIT($request);
                $data = $data->paginate($PAGINATELIMIT);
            }else{
                $data = $data->find($id);
            }
        }else{
            $message = "seva_id is required";
            $success = 0;
        }
        $resp = array('success'=>$success,'message'=>$message,'data'=>$data);
        return new CommonreturnResource($resp);
    }
}
