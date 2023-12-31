<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Commonreturn as CommonreturnResource;
use App\Models\SevaPrice;

class SevaPriceController extends Controller
{
    public $succ = 200;
    public $err  = 202;
    public function __construct(){
        // $this->middleware('jwt', ['except' => ['login_signup','login_with_otp']]);
    }
    public function index(Request $request,$seva_id=0,$id=0){
        $data=array();
        $message='';
        $success=1;
        $data = SevaPrice::query();
        $userid = login_User_ID();
        if($userid!='' && $userid>0){
            $userid = $userid;
        }else{
            $userid = 0;
        }
        $data = $data->withCount(['user_carts' => function ($q) use ($userid) {
            $q->where('user_id',$userid);
        }]);
        if($seva_id>0){
            $data = $data->where('seva_id',$seva_id);
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
