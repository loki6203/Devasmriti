<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Hash;
use App\Models\Setting;

class CmsController extends Controller 
{
    public $succ = 200;
    public $err  = 202;
    public function check_tpin_generated_or_not(Request $request){
        $Setting = Setting::first('address','emails');
        $resp = array('success'=>$status,'message'=>$message,'data'=>$data);
        return response()->json($resp, $this->succ);
    }
    public function countries(Request $request){}
    public function states(Request $request){}
    public function cities(Request $request){}
    public function state_based_on_country(Request $request){}
    public function city_based_on_country_and_state(Request $request){}
}
