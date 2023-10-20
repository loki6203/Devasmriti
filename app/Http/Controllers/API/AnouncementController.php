<?php

/**
 * Created by Reliese Controller.
 */

 namespace App\Http\Controllers\API;
 use App\Http\Controllers\Controller; 
 use Illuminate\Support\Facades\Hash;
 use Illuminate\Support\Facades\Validator;
 use App\Http\Resources\Commonreturn as CommonreturnResource;
use App\Models\Anouncement;
use Illuminate\Http\Request;

class AnouncementController extends Controller
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
        $data = Anouncement::query();
        $data = $data->where('is_active',1);
        if($id==0){
            $data = $data->orderBy('ordering_number', 'ASC');
            $PAGINATELIMIT = PAGINATELIMIT($request);
            $data = $data->paginate($PAGINATELIMIT);
        }else{
            $data = $data->find($id);
            if($request->method()=="DELETE"){
                $data->delete();
                $message = "Deleted successfully";
            }
        }
        $resp = array('success'=>$success,'message'=>$message,'data'=>$data);
        return new CommonreturnResource($resp);
    }
}
