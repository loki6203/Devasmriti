<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Hash;
use App\Models\Setting;
use App\Models\State;
use App\Models\City;
use App\Models\Country;

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
}
