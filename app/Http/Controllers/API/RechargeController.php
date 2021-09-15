<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\InternalTransfer;

class RechargeController extends Controller 
{
    public $successStatus = 200;
    public function add_money_to_wallet(Request $request){
        $data=array();
        $message='';
        $success=1;
        $from_user_id = login_User_ID();
        $validator = Validator::make($request->all(), [ 
            'amount' => 'required',
        ]);
        if ($validator->fails()) {
            $message = 'Please enter all (*) fields';
            $success=0;
        }else{
            
        }
        $resp = array('success'=>$success,'message'=>$message,'data'=>$data);
        return response()->json($resp, $this->successStatus);
    }
}
