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
}
