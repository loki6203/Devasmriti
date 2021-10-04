<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Hash;
use App\Models\Setting;
use App\Models\State;
use App\Models\City;
use App\Models\Country;
use App\Models\PaymentGateway;

class CmsController extends Controller 
{
    public $succ = 200;
    public $err  = 202;
    public function contact_us(Request $request){
        $Setting = Setting::first(['address','emails']);
        $resp = array('success'=>1,'message'=>'','data'=>$Setting);
        return response()->json($resp, $this->succ);
    }
    public function countries(Request $request){
        $data = Country::all();
        $resp = array('success'=>1,'message'=>'','data'=>$data);
        return response()->json($resp, $this->succ);
    }
    public function states(Request $request){
        $data = State::with('country')->get();
        $resp = array('success'=>1,'message'=>'','data'=>$data);
        return response()->json($resp, $this->succ);
    }
    public function cities(Request $request){
        $data = City::with('country')->with('state')->get();
        $resp = array('success'=>1,'message'=>'','data'=>$data);
        return response()->json($resp, $this->succ);
    }
    public function state_based_on_country(Request $request,$country_id){
        $data = State::with('country')->where('country_id','=',$country_id)->get();
        $resp = array('success'=>1,'message'=>'','data'=>$data);
        return response()->json($resp, $this->succ);
    }
    public function city_based_on_country_and_state(Request $request,$country_id,$state_id){
        $data = State::with('country')->where('country_id','=',$country_id)->where('id','=',$state_id)->get();
        $resp = array('success'=>1,'message'=>'','data'=>$data);
        return response()->json($resp, $this->succ);
    }
    public function payment_gateway_list(Request $request){
        $data = PaymentGateway::where('name','!=','payout')->get();
        $resp = array('success'=>1,'message'=>'','data'=>$data);
        return response()->json($resp, $this->succ);
    }
    public function gateway(){
        echo '<h2>zackpay</h2><hr>';

        echo 'TEST</br><hr></br>';
        $dt=array(
        'Merchant_ID'=>'889653b03ce04a57b54db6463b1e5445 ',
        'SECRET_KEY'=>'0678056d96914a8583fb518caf42828a',
        'API_KEY'=>'',
        'URL'=>''
        );
        echo $test = json_encode($dt);
        echo'<hr>';echo 'LIVE';echo'<br><br>';
            $dt=array(
                'Merchant_ID'=>'242254d9a5f14a688d623bb05b9c9500',
                'SECRET_KEY'=>'190472e7272f4dad910932460cfe89a4',
                'API_KEY'=>'48ff8e97f2c24f0986e7ee389b53f8d7',
                'URL'=>''
            );
        echo $live = json_encode($dt);
        PaymentGateway::where('id',1)->update(['test'=>$test,'live'=>$live]);

        
        echo '<h2>RAZORPAY</h2><hr>';
        echo 'TEST</br><hr></br>';
            $dt=array(
                'KEY_ID'=>'rzp_test_cjT5SUSriGCr6a ',
                'SECRET_KEY'=>'mpRGDhO00aPZIzTwAewXVuMn',
                'URL'=>''
            );
        echo $test =  json_encode($dt);
        echo'<hr>';echo 'LIVE';echo'<br><br>';
            $dt=array(
                'KEY_ID'=>'jAUskVzf4hwRbFVCf0qFXPDe ',
                'SECRET_KEY'=>'rzp_live_SCCUPJYTWQvAVQ',
                'URL'=>''
            );
        echo $live = json_encode($dt);
        PaymentGateway::where('id',2)->update(['test'=>$test,'live'=>$live]);


        echo '<h2>SAFEXPAY</h2><hr>';
        echo 'TEST</br><hr></br>';
            $dt=array(
                'MARCHANT_ID'=>'202104210302',
                'MARCHANT_KEY'=>'B808GWxEls3oFzOz6wfxgEpSfPaQunLCU54vDJty4=',
                'AGGREGATOR_ID'=>'Paygate',
                'URL'=>''
            );
        echo $test = json_encode($dt);
        echo'<hr>';echo 'LIVE';echo'<br><br>';
            $dt=array(
                'MARCHANT_ID'=>' ',
                'MARCHANT_KEY'=>'',
                'AGGREGATOR_ID'=>'',
                'URL'=>''
            );
        echo $live = json_encode($dt);
        PaymentGateway::where('id',3)->update(['test'=>$test,'live'=>$live]);
    }
}
