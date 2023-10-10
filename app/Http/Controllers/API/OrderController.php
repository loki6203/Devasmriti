<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Commonreturn as CommonreturnResource;
use App\Models\UserReward;
use App\Models\Order;
use App\Models\OrderSeva;
use Illuminate\Validation\Rule;

class OrderController extends Controller
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
        if($request->method()=="POST" || $request->method()=="PUT"){
            // $required = [
            //     "seva_price_id"         => ['required|numeric','array'],
            //     "extra_charges"         => 'required',
            //     "coupon_code"           => 'nullable',
            //     "final_paid_amount"     => 'required', 
            //     'reward_points'         => 'nullable'
            // ];
            if($request->method()=="POST"){
                $required = [
                    'cart'                          => 'present|array',
                    'cart.*.is_prasadam_available'  => 'nullable|boolean',
                    'cart.*.seva_id'                => 'required|integer',
                    'cart.*.seva_price_id'          => 'required|integer',
                    "shipping_user_address_id"      => 'required', 
                    "billing_user_address_id "      => 'required', 
                    "coupon_code"                   => 'nullable',
                    "original_price"                => 'required',
                    "reward_points"                 => 'nullable', 
                    "extra_charges"                 => 'nullable', 
                    "coupon_amount"                 => 'nullable', 
                    "final_paid_amount"             => 'required', 
                    'is_from_cart'                  => 'required|boolean',
                ];
            }else{
                $required = [
                    'payment_status'        => ['required',Rule::in(['Processing','Failed','Success'])],
                    "transaction_id"        => 'required',
                    "transaction_response"  => 'required|json'
                ];
            }
            $validator = Validator::make($request->all(),$required);
            if($validator->fails()){
                $message = $validator->errors()->first();
                $status  = $this->err;
                $success = 0;
            }else{
                if(!empty($request->all())){
                    $ProdData = $request->all();
                    try {
                        if($request->method()=="POST"){
                            $ProdData['user_id']=$userid;
                            $Cart     = $ProdData['cart'];
                            unset($ProdData['cart']);
                            unset($ProdData['is_from_cart']);
                            $ProdData['reference_id'] = Reff_No_Generate();
                            $orderData = Order::create($ProdData);
                            if($orderData){
                                foreach($Cart as $ord){
                                    OrderSeva::create($ord);
                                }
                                $message = "Please continue with payment if your order was pending. ";
                                $data = Order::with('order_sevas')->find($orderData->id);
                            }else{
                                $success = 0;
                                $message = "Ordering failed try again...";
                                $data = null;
                            }
                        }else{
                            $data = Order::where('id',$id)->update($request->all());
                            if($ProdData['payment_status']=='Success'){
                                if($data->reward_points>0){
                                    $WhereDr = array('user_id'=>$userid,'is_credited'=>0,'points'=>$data->reward_points,'order_id'=>$id);
                                    if(UserReward::where($WhereDr)->count()==0){
                                        UserReward::create($WhereDr);
                                    }
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
                                    $WhereCr = array('user_id'=>$userid,'is_credited'=>1,'points'=>$totalRewards,'order_id'=>$id);
                                    if(UserReward::where($WhereCr)->count()==0){
                                        UserReward::create($WhereCr);
                                    }
                                }
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
            $data = $data->with('order_sevas');
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
