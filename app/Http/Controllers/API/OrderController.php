<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Commonreturn as CommonreturnResource;
use App\Models\User;
use App\Models\UserReward;
use App\Models\Order;
use App\Models\OrderSeva;
use App\Models\SevaPrice;
use App\Models\OrderSevaFamilyDetail;
use App\Models\UserFamilyDetail;
use App\Models\State;
use App\Models\City;
use App\Models\Country;
use App\Models\UserAddress;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
	public $succ = 200;
    public $err  = 202;

    public $working_key = '664AB39BBF9119447E372FEF436DCA7D';
    public $access_code = 'AVHN05KJ30CF33NHFC';
    public $merchant_id = '2742697';
    public $ccurl = ' https://test.ccavenue.com/transaction/transaction.do?command=initiateTransaction';

    // public $working_key = 'D31380092DBE36A182BC8FEF363A6E95';
    // public $access_code = 'AVPB26KJ94CL28BPLC';
    // public $merchant_id = '2742697';
    // public $ccurl = 'https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction';


    public function __construct(){
    }
    public function payment(Request $request){
        $data['working_key']            = $this->working_key;
        $data['access_code']            = $this->access_code;
        $data['ccurl']                  = $this->ccurl;
        $data['merchant_id']            = $this->merchant_id;
        return view('ccpayment',$data);
    }
    public function requestHandler(Request $request,$order_id='',$isTesting=0){
        $Shipping=array();
        if($order_id==""){
            $order_id = 83;
        }
        $orderData = Order::find($order_id);
        $data=array();
        if(!is_null($orderData)){
            $data['isValid']=1;
            $data['working_key']            = $this->working_key;
            $data['access_code']            = $this->access_code;
            $data['ccurl']                  = $this->ccurl;
            $Shipping['tid']                = time();
            $Shipping['merchant_id']        = $this->merchant_id;
            $Shipping['order_id']           = $orderData->invoice_id;
            $Shipping['amount']             = $orderData->final_paid_amount;
            $Shipping['currency']           = 'INR';
            $Shipping['redirect_url']       = 'https://api-backend.devasmriti.com/cc/ccavResponseHandler.php';
            $Shipping['cancel_url']         = 'https://api-backend.devasmriti.com/cc/ccavResponseHandler.php';
            $Shipping['language']           = 'EN';
            $biilingDetails                 = json_decode($orderData->billing_address,true);
            $DeliveryDetails                = json_decode($orderData->shipping_address,true);
            if(empty($biilingDetails)){
                $biilingDetails             = $DeliveryDetails;
            }
            if(empty($DeliveryDetails)){
                $DeliveryDetails             = $biilingDetails;
            }
            $BENVnAME = '';
            if(isset($biilingDetails['lname']) && $biilingDetails['lname']!=''){
                $BENVnAME = $biilingDetails['fname'].' '.$biilingDetails['lname'];
            }else{
                $BENVnAME = @$biilingDetails['lname'];
            }
            $Shipping['billing_name']       = $BENVnAME;
            $Shipping['billing_address']    = @$biilingDetails['address_1'];
            $Shipping['billing_city']       = @$biilingDetails['city']['name'];
            $Shipping['billing_state']      = @$biilingDetails['state']['name'];
            $Shipping['billing_zip']        = @$biilingDetails['pincode'];
            $Shipping['billing_country']    = @$biilingDetails['country']['name'];
            $Shipping['billing_tel']        = @$biilingDetails['phone_no'];
            $Shipping['billing_email']      = @$biilingDetails['email'];
            $dENVnAME = '';
            if(isset($DeliveryDetails['lname']) && $DeliveryDetails['lname']!=''){
                $dENVnAME = $DeliveryDetails['fname'].' '.$DeliveryDetails['lname'];
            }else{
                $dENVnAME = @$DeliveryDetails['lname'];
            }
            $Shipping['delivery_name']      = $dENVnAME;
            $Shipping['delivery_address']   = @$DeliveryDetails['address_1'];
            $Shipping['delivery_city']      = @$DeliveryDetails['city']['name'];
            $Shipping['delivery_state']     = @$DeliveryDetails['state']['name'];
            $Shipping['delivery_zip']       = @$DeliveryDetails['pincode'];
            $Shipping['delivery_country']   = @$DeliveryDetails['country']['name'];
            $Shipping['delivery_tel']       = @$DeliveryDetails['phone_no'];
            $Shipping['merchant_param1']    = 'additional Info.';
            $Shipping['merchant_param2']    = 'additional Info.';
            $Shipping['merchant_param3']    = 'additional Info.';
            $Shipping['merchant_param4']    = 'additional Info.';
            $Shipping['promo_code']         = '';
            $Shipping['customer_identifier']='';
            $data['respdata']               =$Shipping;
            if($isTesting==1){
                echo '<pre>Billing =>';print_r($biilingDetails);
                echo '<pre>Shipping =>';print_r($DeliveryDetails);
                echo '<hr><pre>Order =>';print_r($data);exit;
            }
        }else{
            $data['isValid']=0;
            return redirect(WEB_API_LINK().'payment/0/Invalid');
        }
		return view('ccavRequestHandler',$data);
	}
	public function responseHandler(Request $request){
        $json       = file_get_contents('php://input');
        $postData   = json_decode($json,TRUE);
        if(empty($postData)){
            $postData = $_POST;
        }
        echo '<pre>';print_r($postData);exit;
        // if(!empty($postData)){
        //     $encResponse=$postData["encResp"];		
        //     //This is the response sent by the CCAvenue Server
        //     $workingKey=$this->working_key;
        //     $rcvdString=decrypt($encResponse,$workingKey);		
        //     //Crypto Decryption used as per the specified working key.
        //     $order_status="";
        //     $order_id = 0;
        //     $decryptValues=explode('&', $rcvdString);
        //     $dataSize=sizeof($decryptValues);
        //     for($i = 0; $i < $dataSize; $i++){
        //         $information=explode('=',$decryptValues[$i]);
        //         if($i==3)	$order_status=$information[1];
        //         if($i==0)	$order_id=$information[1];
        //     }
        //     $payment_status = $order_status;
        //     if($order_status==="Success"){
        //         // echo "<br>Thank you for shopping with us. Your credit card has been charged and your transaction is successful. We will be shipping your order to you soon.";
        //     }else if($order_status==="Aborted"){
        //         $payment_status = 'Processing';
        //         // echo "<br>Thank you for shopping with us.We will keep you posted regarding the status of your order through e-mail";
        //     }else if($order_status==="Failure"){
        //         $payment_status = 'Faield';
        //         // echo "<br>Thank you for shopping with us.However,the transaction has been declined.";
        //     }else{
        //         $payment_status = 'Processing';
        //         $order_status = "Securityerror";
        //         // echo "<br>Security Error. Illegal access detected";
        //     }
        //     $UserAddressUp = array('payment_status'=>$payment_status);
        //     Order::where('id',$order_id)->update($UserAddressUp);
        //     if($order_status==="Success"){
        //         $data   = Order::find($order_id);
        //         $invoice_id = $data->invoice_id;
        //         $this->SuccPaymentData($data);
        //     }
        // }else{
        //     $invoice_id = 0;
        //     $order_status = 'Invalid';
        // }
        // return redirect(WEB_API_LINK().'payment/'.$invoice_id.'/'.$order_status);
	}
    function SuccPaymentData($data){
        $userid = $data->user_id;
        $id     = $data->id;
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
                $UserDetails = User::find($userid);
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
    public function index(Request $request,$id=0){
        $data=array();
        $message='';
        $success=1;
        $userid = login_User_ID();
        if($userid){
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
                                if($userid>0){
                                    $ProdData['user_id']=$userid;
                                    $Cart     = $ProdData['cart'];
                                    unset($ProdData['cart']);
                                    unset($ProdData['is_from_cart']);
                                    $ProdData['reference_id'] = Reff_No_Generate();
                                    $ProdData['invoice_id'] = $ProdData['reference_id'];
                                    // $ProdData['order_id'] = $ProdData['reference_id'];
                                    $orderData = Order::create($ProdData);
                                    if($orderData->shipping_user_address_id){
                                        $UserAddress = UserAddress::find($orderData->shipping_user_address_id);
                                        $UserAddress['state'] = State::find($UserAddress->state_id);
                                        $UserAddress['city'] = City::find($UserAddress->city_id);
                                        $UserAddress['country'] = Country::find($UserAddress->country_id);
                                        $UserAddressUp = array('shipping_address'=>$UserAddress);
                                        Order::where('id',$orderData->id)->update($UserAddressUp);
                                    }
                                    if($orderData->billing_user_address_id){
                                        $UserAddress = UserAddress::find($orderData->billing_user_address_id);
                                        $UserAddress['state'] = State::find($UserAddress->state_id);
                                        $UserAddress['city'] = City::find($UserAddress->city_id);
                                        $UserAddress['country'] = Country::find($UserAddress->country_id);
                                        $UserAddressUp = array('billing_address'=>$UserAddress);
                                        Order::where('id',$orderData->id)->update($UserAddressUp);
                                    }
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
                                        $message        = "Please continue with payment if your order was pending. ";
                                        $data           = Order::with('order_sevas')->find($orderData->id);
                                        $Reference_id   = $ProdData['reference_id'];
                                        $UserDetails    = User::find($userid);
                                        $data['checkout_url'] = url('ccavenue/requestHandler/'.$orderData->id);
                                        $phonenumber = @$UserDetails->mobile_number;
                                        $merchantId     = 'DEVASMRITIONLINE';
                                        $merchantIdKey  = '9fbd4b68-81b1-4ccb-9788-00ff26e0d641';
                                        $keyIndex       = '1';
                                        // $merchantId     = 'PGTESTPAYUAT';
                                        // $merchantIdKey  = '099eb0cd-02cf-4e2a-8aca-3e6c6aff0399';
                                        // $keyIndex       = '1';

                                        // try{
                                            // $Pay_Load_Request = array(
                                            //     'merchantId'            =>  $merchantId,
                                            //     'merchantTransactionId' =>  $Reference_id,
                                            //     'merchantUserId'        =>  1234,
                                            //     'amount'                =>  100,
                                            //     'redirectUrl'           =>  url('/api/payment_checksum'),
                                            //     // 'redirectUrl'           =>  WEB_API_LINK().'payment/status',
                                            //     'redirectMode'          =>  'REDIRECT',
                                            //     'callbackUrl'           =>  url('/api/payment_checksum'),
                                            //     'mobileNumber'          =>  $phonenumber,
                                            //     'paymentInstrument'     =>  array('type'=>'PAY_PAGE')
                                            // );
                                            // $curl = curl_init();
                                            // curl_setopt_array($curl,array(
                                            //     CURLOPT_URL => 'https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay',
                                            //     CURLOPT_RETURNTRANSFER => true,
                                            //     CURLOPT_ENCODING => '',
                                            //     CURLOPT_MAXREDIRS => 10,
                                            //     CURLOPT_TIMEOUT => 0,
                                            //     CURLOPT_FOLLOWLOCATION => true,
                                            //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                            //     CURLOPT_CUSTOMREQUEST => 'POST',
                                            //     CURLOPT_POSTFIELDS =>json_encode($Pay_Load_Request,true),
                                            //     CURLOPT_HTTPHEADER => array(
                                            //         'Content-Type' => 'application/json',
                                            //         'accept'       => 'application/json',
                                            //     ),
                                            // ));
                                            // $data = curl_exec($curl);
                                            // curl_close($curl);

                                            // $body = json_encode($Pay_Load_Request,true);
                                            // $Sha_256=hash('sha256',$body."/pg/v1/pay".$merchantIdKey)."###".$keyIndex;
                                            // $client = new \GuzzleHttp\Client();
                                            // $response = $client->request('POST','https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay',[
                                            //     'body'      =>  $body,
                                            //     'headers'   => [
                                            //         'Content-Type' => 'application/json',
                                            //         'accept' => 'application/json',
                                            //         'X-VERIFY'=>$Sha_256
                                            //     ],
                                            // ]);
                                            // $data = $response->getBody();

                                            // $body ='{"merchantId":"DEVASMRITIONLINE","merchantTransactionId":"'.$Reference_id.'","merchantUserId":"'.$userid.'","amount":100,"redirectUrl":"'.WEB_API_LINK().'payment/status","redirectMode":"REDIRECT","callbackUrl":"'.url('/api/payment_checksum').',"mobileNumber":"'.$phonenumber.'"","paymentInstrument":{"type":"PAY_PAGE"}}';
                                            // $client = new \GuzzleHttp\Client();
                                            // $response = $client->request('POST', 'https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay', [
                                            //     'body' =>$body,
                                            //     'headers' => [
                                            //     'Content-Type' => 'application/json',
                                            //     'accept' => 'application/json',
                                            // ],
                                            // ]);
                                            // $data = $response->getBody();

                                            // $client = new \GuzzleHttp\Client();
                                            // $headers = [
                                            //     'Content-Type' => 'application/json',
                                            //     'accept' => 'application/json'
                                            // ];
                                            // $requestData = new Request('POST','https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay',$headers,$body);
                                            // $res = $client->sendAsync(new Request('POST','https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay',$headers,$body))->wait();
                                            // $data = $res->getBody();
                                            // $data = $body;

                                        // } catch (\Exception $ex) {
                                        //     $message =  ERRORMESSAGE($ex->getMessage());
                                        //     // $data = ["Fail"];
                                        //     $data =$Pay_Load_Request;
                                        // }
                                        $Shipping['tid']                = time();
                                        $Shipping['merchant_id']        = $this->merchant_id;
                                        $Shipping['order_id']           = $orderData->invoice_id;
                                        $Shipping['amount']             = $orderData->final_paid_amount;
                                        $Shipping['currency']           = 'INR';
                                        $Shipping['redirect_url']       = 'https://api-backend.devasmriti.com/cc/ccavResponseHandler.php';
                                        $Shipping['cancel_url']         = 'https://api-backend.devasmriti.com/cc/ccavResponseHandler.php';
                                        $Shipping['language']           = 'EN';
                                        $biilingDetails                 = json_decode($orderData->billing_address,true);
                                        $DeliveryDetails                = json_decode($orderData->shipping_address,true);
                                        if(empty($biilingDetails)){
                                            $biilingDetails             = $DeliveryDetails;
                                        }
                                        if(empty($DeliveryDetails)){
                                            $DeliveryDetails             = $biilingDetails;
                                        }
                                        $BENVnAME = '';
                                        if(isset($biilingDetails['lname']) && $biilingDetails['lname']!=''){
                                            $BENVnAME = $biilingDetails['fname'].' '.$biilingDetails['lname'];
                                        }else{
                                            $BENVnAME = @$biilingDetails['lname'];
                                        }
                                        $Shipping['billing_name']       = $BENVnAME;
                                        $Shipping['billing_address']    = @$biilingDetails['address_1'];
                                        $Shipping['billing_city']       = @$biilingDetails['city']['name'];
                                        $Shipping['billing_state']      = @$biilingDetails['state']['name'];
                                        $Shipping['billing_zip']        = @$biilingDetails['pincode'];
                                        $Shipping['billing_country']    = @$biilingDetails['country']['name'];
                                        $Shipping['billing_tel']        = @$biilingDetails['phone_no'];
                                        $Shipping['billing_email']      = @$biilingDetails['email'];
                                        $dENVnAME = '';
                                        if(isset($DeliveryDetails['lname']) && $DeliveryDetails['lname']!=''){
                                            $dENVnAME = $DeliveryDetails['fname'].' '.$DeliveryDetails['lname'];
                                        }else{
                                            $dENVnAME = @$DeliveryDetails['lname'];
                                        }
                                        $Shipping['delivery_name']      = $dENVnAME;
                                        $Shipping['delivery_address']   = @$DeliveryDetails['address_1'];
                                        $Shipping['delivery_city']      = @$DeliveryDetails['city']['name'];
                                        $Shipping['delivery_state']     = @$DeliveryDetails['state']['name'];
                                        $Shipping['delivery_zip']       = @$DeliveryDetails['pincode'];
                                        $Shipping['delivery_country']   = @$DeliveryDetails['country']['name'];
                                        $Shipping['delivery_tel']       = @$DeliveryDetails['phone_no'];
                                        $Shipping['merchant_param1']    = 'additional Info.';
                                        $Shipping['merchant_param2']    = 'additional Info.';
                                        $Shipping['merchant_param3']    = 'additional Info.';
                                        $Shipping['merchant_param4']    = 'additional Info.';
                                        $Shipping['promo_code']         = '';
                                        $Shipping['customer_identifier']='';
                                        $data['respdata']               =$Shipping;
                                    }else{
                                        $success=0;
                                        $message="Please login to continue";
                                    }
                                }else{
                                    $success = 0;
                                    $message = "Ordering failed try again...";
                                    $data = null;
                                }
                            }else{
                                $data = Order::find($id);
                                if(is_null($data)){
                                    $data = Order::where('invoice_id',$id)->first();
                                }
                                $data = Order::where('id',$id)->update($request->all());
                                $data = Order::find($id);
                                if(is_null($data)){
                                    $data = Order::where('invoice_id',$id)->first();
                                }
                                $userid = $data->user_id;
                                if($ProdData['payment_status']=='Success'){
                                    $this->SuccPaymentData($data);
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
                $data = $data->with('order_sevas.order_seva_family_details');
                if($id==0){
                    $PAGINATELIMIT = PAGINATELIMIT($request);
                    $data = $data->paginate($PAGINATELIMIT);
                }else{
                    $data = $data->find($id);
                    if(is_null($data)){
                        $data = Order::where('invoice_id',$id)->with('order_sevas.order_seva_family_details')->first();
                    }
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
