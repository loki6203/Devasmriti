<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Commonreturn as CommonreturnResource;
use App\Models\UserCart;
use App\Models\SevaCoupon;

class SevaCouponController extends Controller
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
        $data = SevaCoupon::query();
        if($request->has('code')){
            $data = $data->where('code', 'like', '%' . $request->get('code') . '%');
        }
        if($userid>0){
            
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
    public function checkCoupon(Request $request,$code){
        $data['coupon_amount']=array();
        $message='';
        $success=1;
        $userid = login_User_ID();
        if($code!=""){
            $message='Coupon applied successfully';
            $coUpValid = 0;
            if($coUpValid){
                $data['coupon_amount'] = UserCart::where('user_id',$userid)->sum('seva_price.selling_price');
            }else{
                $message='Invali coupon';
            }
        }else{
            $success=0;
            $message='Please enter coupon code';
        }
        $resp = array('success'=>$success,'message'=>$message,'data'=>$data);
        return new CommonreturnResource($resp);
    }
}
