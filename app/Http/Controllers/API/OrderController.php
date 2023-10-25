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
use App\Models\SevaPrice;
use App\Models\OrderSevaFamilyDetail;
use App\Models\UserFamilyDetail;
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
        if($userid>0){
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
                        'cart.*.user_family_detail_id'  => 'required|array',
                        "shipping_user_address_id"      => 'required', 
                        "billing_user_address_id"       => 'required', 
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
                                $ProdData['invoice_id'] = $ProdData['reference_id'];
                                // $ProdData['order_id'] = $ProdData['reference_id'];
                                $orderData = Order::create($ProdData);
                                if($orderData){
                                    foreach($Cart as $ord){
                                        $user_family_detail_id = $ord['user_family_detail_id'];
                                        unset($ord['user_family_detail_id']);
                                        $ord['qty'] = 1;
                                        $ord['order_id'] = $orderData->id;
                                        $OrderSeva = OrderSeva::create($ord);
                                        try{
                                            $seva_price_information = SevaPrice::find($ord['seva_price_id']);
                                            $uPsV = array('seva_price_information'=>$seva_price_information);
                                            OrderSeva::where('id',$OrderSeva->id)->update($uPsV);
                                        } catch (\Exception $ex) {
                                            // $message =  ERRORMESSAGE($ex->getMessage());
                                        }
                                        if($user_family_detail_id){
                                            foreach($user_family_detail_id as $id){
                                                $user_family_details =  UserFamilyDetail::find($id);
                                                if(!is_null($user_family_details)){
                                                    $InstArr = array(
                                                        'user_family_detail_id'=>$id,
                                                        'user_family_details'=>$user_family_details,
                                                        'order_seva_id'=>$OrderSeva->id
                                                    );
                                                    OrderSevaFamilyDetail::create($InstArr);
                                                }
                                            }
                                        }
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
                                $data = Order::find($id);
                                if($ProdData['payment_status']=='Success'){
                                    if($data['reward_points']>0){
                                        $WhereDr = array('user_id'=>$userid,'is_credited'=>0,'points'=>$data['reward_points'],'order_id'=>$id);
                                        if(UserReward::where($WhereDr)->count()==0){
                                            UserReward::create($WhereDr);
                                        }
                                    }
                                    $GetAllSevaPrices = OrderSeva::where('order_id',$id)->with('order')->with('seva_price.seva')->get();
                                    $totalRewards = [];
                                    foreach($GetAllSevaPrices as $SevaPrice){
                                        if($SevaPrice['seva_price']['is_rewards_available']==1){
                                            $totalRewards[]=$SevaPrice['seva_price']['seva']['reward_points'];
                                        }
                                        try{
                                            $UserDetails = logined_User();
                                            $phonenumber = @$UserDetails->mobile_number;
                                            if(strstr($phonenumber,'+')==""){
                                                $phonenumber = '91'.trim($phonenumber);
                                            }else{
                                                $phonenumber = str_replace("+"," ",$phonenumber);
                                            }
                                            $phonenumber = trim($phonenumber);
                                            $fname = @$UserDetails->fname;
                                            $lname = @$UserDetails->lname;
                                            if($fname=="" && $lname==""){
                                                $name=$phonenumber;
                                            }else if($fname==""){
                                                $name=$lname;
                                            }else if($lname==""){
                                                $name=$fname;
                                            }else{
                                                $name = $fname.' '.$lname;
                                            }
                                            $amount=$SevaPrice['order']['final_paid_amount'];
                                            $seva=$SevaPrice['seva_price']['title'].'('.$SevaPrice['seva_price']['seva']['title'].')';
                                            $booking_ref=$SevaPrice['order']['invoice_id'];
                                            $time=$SevaPrice['order']['created_at'];
                                            $date=$SevaPrice['order']['created_at'];
                                            $event_link=$SevaPrice['seva_price']['seva']['event'];
                                            
                                            $SbArr = array(
                                                array(
                                                "name"=> "name",
                                                "value"=>$name
                                                ),array(
                                                "name"=> "booking_ref",
                                                "value"=>$booking_ref
                                                ),array(
                                                "name"=> "seva",
                                                "value"=>$seva                                                
                                                ),array(
                                                "name"=> "amount",
                                                "value"=>$amount                                                
                                                ),array(
                                                "name"=> "date",
                                                "value"=>Date_Month_Name($date)                                                
                                                ),array(
                                                "name"=> "time",
                                                "value"=>Date_With_Time($time)                                                
                                                ),array(
                                                "name"=> "event_link",
                                                "value"=>$event_link
                                                )
                                            );
                                            $PostData = array(
                                                "template_name"=>"order_success_website_integration",
                                                "broadcast_name"=>"order_success_website_integration",
                                                "parameters"=>$SbArr
                                            );
                                            $JsonData = json_encode($PostData,true);
                                            $curl = curl_init();
                                            curl_setopt_array($curl, array(
                                            CURLOPT_URL => 'https://live-server-114472.wati.io/api/v1/sendTemplateMessage?whatsappNumber='.$phonenumber.'',
                                            CURLOPT_RETURNTRANSFER => true,
                                            CURLOPT_ENCODING => '',
                                            CURLOPT_MAXREDIRS => 10,
                                            CURLOPT_TIMEOUT => 0,
                                            CURLOPT_FOLLOWLOCATION => true,
                                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                            CURLOPT_CUSTOMREQUEST => 'POST',
                                            CURLOPT_POSTFIELDS =>$JsonData,
                                            CURLOPT_HTTPHEADER => array(
                                                'Content-Type: application/json',
                                                'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJqdGkiOiIyZWM4MDc5NC04YjY1LTRlODgtYTdmYy1hMTJkM2Q5Zjk3OWIiLCJ1bmlxdWVfbmFtZSI6InZlbmthdEB2aWJob3RlY2guY29tIiwibmFtZWlkIjoidmVua2F0QHZpYmhvdGVjaC5jb20iLCJlbWFpbCI6InZlbmthdEB2aWJob3RlY2guY29tIiwiYXV0aF90aW1lIjoiMTAvMjMvMjAyMyAxMDoyNTo1OSIsImRiX25hbWUiOiIxMTQ0NzIiLCJodHRwOi8vc2NoZW1hcy5taWNyb3NvZnQuY29tL3dzLzIwMDgvMDYvaWRlbnRpdHkvY2xhaW1zL3JvbGUiOiJERVZFTE9QRVIiLCJleHAiOjI1MzQwMjMwMDgwMCwiaXNzIjoiQ2xhcmVfQUkiLCJhdWQiOiJDbGFyZV9BSSJ9.kSErsJx8l9vHj4D-AK59vzdesikF5WXe8Oodu9sbQWM'
                                            ),
                                            ));
                                            $response = curl_exec($curl);
                                            curl_close($curl);
                                            $message = $response;
                                            // $message = $PostData;
                                        } catch (\Exception $ex) {
                                            // $message =  ERRORMESSAGE($ex->getMessage());
                                            // $message = "Failed";
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
                                // $message = "Updated successfully";
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
                $data = $data->with('order_sevas.order_seva_family_details');
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
        }else{
            $success=0;
            $message="Please login to continue";
        }
        $resp = array('success'=>$success,'message'=>$message,'data'=>$data);
        return new CommonreturnResource($resp);
    }
}
