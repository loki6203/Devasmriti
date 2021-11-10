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
use App\Models\Notification;

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
        $data = PaymentGateway::where('name','!=','payout')->where('is_active','=','active')->get();
        $resp = array('success'=>1,'message'=>'','data'=>$data);
        return response()->json($resp, $this->succ);
    }
    public function modules(){
        $dt=array(
            'referel'           =>'referel',
            'internal_transfer' =>'internal_transfer',
            'deposit'           =>'deposit',
            'prepaid_recharge'  =>'prepaid_recharge',
            'postpaid_recharge' =>'postpaid_recharge',
            'dth_recharge'      =>'dth_recharge',
            'bbps'              =>'bbps',
            'bill_pay'          =>'bill_pay',
            'rent_pay'          =>'rent_pay',
            'admin'             =>'admin'
        );
        return response()->json($dt, $this->succ);
    }
    public function gateway(){
        echo '<h2>zackpay</h2><hr>';

        echo 'TEST</br><hr></br>';
        $dt=array(
        'Merchant_ID'=>'889653b03ce04a57b54db6463b1e5445 ',
        'SECRET_KEY'=>'0678056d96914a8583fb518caf42828a',
        'API_KEY'=>'',
        'URL'=>'https://zaakstaging.zaakpay.com/'
        );
        echo $test = json_encode($dt);
        echo'<hr>';echo 'LIVE';echo'<br><br>';
            $dt=array(
                'Merchant_ID'=>'242254d9a5f14a688d623bb05b9c9500',
                'SECRET_KEY'=>'190472e7272f4dad910932460cfe89a4',
                'API_KEY'=>'48ff8e97f2c24f0986e7ee389b53f8d7',
                'URL'=>'https://api.zaakpay.com/'
            );
        echo $live = json_encode($dt);
        PaymentGateway::where('id',1)->update(['test'=>$test,'live'=>$live]);

        
        echo '<h2>RAZORPAY</h2><hr>';
        echo 'TEST</br><hr></br>';
            $dt=array(
                'KEY_ID'=>'rzp_test_keeXcoyuO0njIB',
                'SECRET_KEY'=>'pgXZhMznTB4XPVKeWWPnqu4L',
                'URL'=>'',
                'account_number'=>'2323230022957804'
            );
        echo $test =  json_encode($dt);
        echo'<hr>';echo 'LIVE';echo'<br><br>';
            $dt=array(
                'KEY_ID'=>'rzp_live_SCCUPJYTWQvAVQ',
                'SECRET_KEY'=>'jAUskVzf4hwRbFVCf0qFXPDe',
                'URL'=>'',
                'account_number'=>'2323230022957804'
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
    public function notif(){
        $all_count          = Notification::orderBy('id', 'desc')->get();
        foreach($all_count as $v){
            echo '<br><hr>'.$v['message'];
        }
    }
    public function sample(){
        $type='signup';
        $type='login';
        // $type='chpwd';
        // $type='fgpwd';
        // $type='tpin';
        // $type='adhar';
        // $type='pan';
        // $type='addmoney';
        // $type='internal';
        // $type='bill';
        // $type='builder';
        $dt=array(
            'type'=>$type,
            'name'=>'venkat'
        );
        echo view('template',$dt);exit;
        echo "SIGNUP<hr>";
        echo view('signup');
        echo "LOGIN<hr>";
        echo view('signup');
        echo "CHANGEPWD<hr>";
        echo view('signup');
        echo "FORGOT<hr>";
        echo view('signup');
        echo "TPIN<hr>";
        echo view('signup');
        echo "ADHAR<hr>";
        echo view('signup');
        echo "PAN<hr>";
        echo view('signup');
        echo "ADDMONEY<hr>";
        echo view('signup');
        echo "INTERNAL<hr>";
        echo view('signup');
        echo "BUILDER<hr>";
        echo view('signup');
        echo "BILL<hr>";
        echo view('signup');

    }
}
