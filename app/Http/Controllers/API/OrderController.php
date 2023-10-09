<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Commonreturn as CommonreturnResource;
use App\Models\UserReward;
use App\Models\Order;

class OrderController extends Controller
{
	public $succ = 200;
    public $err  = 202;
    public function __construct(){
        // $this->middleware('jwt', ['except' => ['login_signup','login_with_otp']]);
    }
    public function address(Request $request,$id=0){
        $data=array();
        $message='';
        $success=1;
        $userid = login_User_ID();
        if($request->method()=="POST" || $request->method()=="PUT"){
            $required = [
                "seva_price_id"         => ['required|numeric','array'],
                "extra_charges"         => 'required',
                "coupon_code"           => 'nullable',
                "final_paid_amount"     => 'required', 
                'reward_points'         => 'nullable'
            ];
            if($request->method()=="PUT"){
                $required = [];
            }
            $validator = Validator::make($request->all(),$required);
            if($validator->fails()){
                $message = $validator->errors()->first();
                $status  = $this->err;
                $success = 0;
            }else{
                if(!empty($request->all())){
                    try {
                        if($request->method()=="POST"){
                            $request['user_id']=$userid;
                            $data = Order::create($request->all());
                            $message = "Please continue with payment if your order was pending. ";
                        }else{
                            $data = Order::where('id',$id)->update($request->all());
                            if($data->reward_points>0){
                                UserReward::create(array('user_id'=>$userid,'is_credited'=>0,'points'=>$data->reward_points,'order_id'=>$id));
                            }
                            $GetAllSevaPrices =[];
                            $totalRewards = [];
                            foreach($GetAllSevaPrices as $SevaPrice){
                                if($SevaPrice->is_rewards_available>0){
                                    $totalRewards[]=1;
                                }
                            }
                            $totalRewards = array_sum($totalRewards);
                            if($totalRewards>0){
                                UserReward::create(array('user_id'=>$userid,'is_credited'=>1,'points'=>$totalRewards,'order_id'=>$id));
                            }
                            $message = "Updated successfully";
                        }
                    } catch (\Exception $ex) {
                        $message =  ERRORMESSAGE($ex->getMessage());
                    }
                }else{
                    $message = "Please send atleast one column";
                }
            }
        }else{
            $data = Order::query();
            $data = $data->with('city')->with('country')->with('state');
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
