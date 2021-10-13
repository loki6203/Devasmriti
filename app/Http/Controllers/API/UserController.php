<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserDetail;

class UserController extends Controller 
{
    public $succ = 200;
    public $err  = 202;
    /** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function resend_otp(Request $request){
        $data=array();
        $message='';
        $success=1;
        $validator = Validator::make($request->all(), [ 
            'type' => 'required', 
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            $message = 'Please enter all (*) fields';
            $status = $this->err;
            $success=0;
        }else{
            $UserDetail_Check = UserDetail::where('user_id','=',$request->user_id)->first();
            if(!is_null($UserDetail_Check)){
                if($request->type=='email'){
                    $UserDetail_Check->sms_otp                        = Generate_Otp();
                }else{
                    $UserDetail_Check->email_otp                      = Generate_Otp();
                }
                $UserDetail_Check->save();
                $message = 'Otp sent successfully';
                $status = $this->succ;
            }else{
                $message = 'Invalid user';
                $success=0;
                $status = $this->err;
            }
        }
        $resp = array('success'=>$success,'message'=>$message,'data'=>$data);
        return response()->json($resp, $status);
    }
    public function Check_Otp(Request $request){
        $data=array();
        $message='';
        $success=1;
        $validator = Validator::make($request->all(), [ 
            'otp' => 'required', 
            'user_id' => 'required',
            'type' => 'required',
        ]);
        if ($validator->fails()) {
            $message = 'Please enter all (*) fields';
            $status = $this->err;
        }else{
            if($request->type=='mobile'){
                $UserDetail_Check = UserDetail::where([['user_id','=',$request->user_id],['mobile_otp','=',$request->otp]])->count();
            }else{
                $UserDetail_Check = UserDetail::where([['user_id','=',$request->user_id],['email_otp','=',$request->otp]])->count();
            }
            if($UserDetail_Check>0){
                $message = 'Otp validated successfully';
                $status = $this->succ;
            }else{
                $success=0;
                $message = 'Invalid otp';
                $status = $this->err;
            }
        }
        $resp = array('success'=>$success,'message'=>$message,'data'=>$data);
        return response()->json($resp, $status);
    }
    public function Otp_Verification(Request $request){
        $data = array();
        $validator = Validator::make($request->all(), [
			'user_id' => 'required',
			'mobile_otp' => 'required',
		]);
        if ($validator->fails()) {
            $return = array("success" => 0, "message" => "fields marked * were mandatory");
            $status = $this->err;
		}else{
            $Mb_Check = UserDetail::where('user_id','=',$request->user_id)->where('mobile_otp','=',$request->mobile_otp)->count();
            if($Mb_Check>0){
                    $UserDetails = UserDetail::where('user_id','=',$request->user_id)->first();
                    $curr_dt = curr_dt();
                    $UserDetails->mobile_verified_at = $curr_dt;
                    $UserDetails->acc_number       = Acc_No_Generate();
                    $UserDetails->save();
                    User::where('id','=',$request->user_id)->update(array('is_active'=>'active'));
                    $data['user_id']=$request->user_id;
                    $User = User::find($request->user_id);
                    $token = auth('api')->attempt(['mobile_number'=>$User->mobile_number,'password'=>'root']);
                    $data['token'] = $this->createNewToken($token);
                    $data['userdetails'] = auth('api')->user();
                    $return = array("success" =>1, "message" => "Otp verified successfully",'data'=>$data);
                    $status = $this->succ;
            }else{
                $return = array("success" => 0, "message" => "Invalid mobile number otp", 'data'=>$data);
                $status = $this->err;
            }
        }
        return response()->json($return, $status);
    }
    public function pan_adhar_verification(Request $request){
        $data = array();
        $validator = Validator::make($request->all(), [
			'user_id' => 'required',
			'pan_number' => 'required',
			'adhar_number'=> 'required',
		]);
        $name='';
        if ($validator->fails()) {
            $return = array("success" => 0, "message" => "fields marked * were mandatory");
            $status = $this->err;
		}else{
            $UserDetails = UserDetail::where('user_id','=',$request->user_id)->first();
            $pan_check=1;
            $pan_name='';
            $name = $pan_name;
            if($pan_check==1){
                $pan_response='test';
                $curr_dt = curr_dt();
                $Adhar = 1;
                if($Adhar==1){
                    $adhar_otp = 1;
                    $adhar_name='';
                    $adhar_response='';
                    if(strtolower(trim($adhar_name))==strtolower(trim($pan_name))){
                        $UserDetails->adhar_otp        = $adhar_otp;
                        $UserDetails->adhar_response   = $adhar_response;
                        User::where('user_id','=',$request->user_id).update(array('name'=>$name));
                        $return = array("success" => 1, "message" => "Pan && adhar verified successfully" ,'data'=>$data);
                        $status = $this->succ;
                    }else{
                        $return = array("success" => 1, "message" => "Pan and adhar names not matched try again" ,'data'=>$data);
                        $status = $this->err;
                    }
                }else{
                    $return = array("success" => 1, "message" => "Pan verified successfully and invalid adhar number" ,'data'=>$data);
                    $status = $this->err;
                }
                $UserDetails->pan_verified_at   = $curr_dt;
                $UserDetails->pan_response      = $pan_response;
            }else{
                $return = array("success" => 0, "message" => "Invalid pan nunber" ,'data'=>$data);
                $status = $this->err;
            }
            $UserDetails->pan_number    = $pan_number;
            $UserDetails->adhar_number  = $adhar_number;
            $UserDetails->pan_attempts  = $UserDetails->pan_attempts+1;
            $UserDetails->first_name    = $name;
            $UserDetails->save();
        }
        return response()->json($return, $status);
    }
    public function user_change_password(Request $request){
		$validator = Validator::make($request->all(), [
			'old_password' => 'required',
			'new_password' => 'required',
			'confirm_new_password'=> 'required',
		]);
		if ($validator->fails()) {
            $return = array("success" => 0, "message" => "fields marked * were mandatory");
            $status = $this->err;
		}else{
            $userid = login_User_ID();
            
            $old_password=$request->old_password;
            $new_password=$request->new_password;
            $confirm_new_password=$request->confirm_new_password;
            $Ucheck=User::find($userid);
            $request['mobile_number'] = $Ucheck->mobile_number;
            if($new_password == $confirm_new_password){
                if(Hash::check($old_password, auth()->user()->password)){
                    $Ucheck->password = bcrypt($new_password);
                    $Ucheck->save();
                    $return = array("success" => 1, "message" => "Password changed successfully");
                    $status = $this->succ;
                }else{
                    $return = array("success" => 0, "message" => "Invalid old password");
                    $status = $this->err;
                }
            }else{
                $return = array("success" =>0, "message" => "Password not matched.");
                $status = $this->err;
            }
        }
		return response()->json($return, $status);
    }
    public function add_or_change_tpin(Request $request){
		$validator = Validator::make($request->all(), [
			'new_tpin' => 'required',
            'reenter_tpin' => 'required',
            'old_tpin' => 'required',
		]);
		if ($validator->fails()) {
            $return = array("success" => 0, "message" => "fields marked * were mandatory");
            $status = $this->err;
		}else{
            if(trim($request->new_tpin)==trim($request->reenter_tpin)){
                $userid = login_User_ID();
                $UserDetail = UserDetail::where(['user_id'=>$userid])->first();
                $tpin = $request->old_tpin;
                if($UserDetail->tpin!=$tpin && !is_null($UserDetail->tpin)){
                    $return = array("success" => 0, "message" => "Invalid old tpin");
                    $status = $this->err;
                }else{
                    $UserDetail->tpin = $request->new_tpin;
                    $UserDetail->save();
                    $return = array("success" => 1, "message" => "Tpin updated successfully");
                    $status = $this->succ;
                }
            }else{
                $return = array("success" => 0, "message" => "New and re enter tpin not matched");
                $status = $this->err;
            }
        }
		return response()->json($return, $status);
    }
    public function check_pan_adhar_tpin_status(Request $request){
        $userid = login_User_ID();
        $pan_status  = UserDetail::where('user_id','=',$userid)->whereNotNull('pan_verified_at')->count();
        $adr_status  = UserDetail::where('user_id','=',$userid)->whereNotNull('adhar_verified_at')->count();
        $tpin_status = UserDetail::where('user_id','=',$userid)->whereNotNull('tpin')->count();
        $data['pan_status']      = ($pan_status>0)?1:0;
        $data['adhar_status']   = ($adr_status>0)?1:0;
        $data['tpin_status']    = ($tpin_status>0)?1:0;
        $return = array("success" =>1, "message" =>"","data"=>$data);
        return response()->json($return, $this->succ);
    }
    public function check_tpin_generated_or_not(Request $request){
        $userid = login_User_ID();
        $tpin_status = UserDetail::where('user_id','=',$userid)->whereNotNull('tpin')->count();
        $data['tpin_status'] = ($tpin_status>0)?1:0;
        $return = array("success" =>1, "message" =>"","data"=>$data);
        return response()->json($return, $this->succ);
    }
    public function check_tpin_valid_or_not(Request $request,$tpin){
        $userid = login_User_ID();
        $tpin_status  = UserDetail::where('user_id','=',$userid)->where('tpin','=',$tpin)->count();
        $tpin_status  = ($tpin_status>0)?1:0;
        $data['tpin_status']=$tpin_status;
        $return = array("success" =>1, "message" =>"","data"=>$data);
        return response()->json($return, $this->succ);
    }
    public function verify_adhar_or_resend_otp(Request $request,$adharnumber){
        $userid = login_User_ID();
        $status  = $this->err;
        $success = 0;
        $data    = array();
        if($adharnumber!=''){
            $UserDetails = UserDetail::where('user_id',$userid)->first();
            if(!is_null($UserDetails->pan_verified_at)){
                $YOUR_TOKEN=PAN_ADHAR_TOKEN();
                $curl = curl_init();
                curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://kyc-api.aadhaarkyc.io/api/v1/aadhaar-v2/generate-otp',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>'{
                    "id_number": "'.$adharnumber.'"
                }',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Authorization: Bearer '.$YOUR_TOKEN
                ),
                ));
                $response = curl_exec($curl);
                curl_close($curl);
                if($response!=''){
                    $resp = json_decode($response,true);
                    if(trim($resp['success'])==true){
                        $data = $resp['data'];
                        $UserDetails = UserDetail::where('user_id',$userid)->first();
                        $UserDetails->adhar_response = $response;
                        $UserDetails->save();
                        $return = array("success" =>1, "message" =>"Otp sent to register mobile number","data"=>$data);
                    }else{
                        $return = array("success" =>0, "message" =>$resp['message'],"data"=>$data);
                    }
                }else{
                    $return = array("success" =>0, "message" =>"Try again","data"=>$data);
                }
            }else{
                $return = array("success" =>0, "message" =>"Before verifying the adhar first verify your  pancard","data"=>$data);
            }
        }else{
            $return = array("success" =>0, "message" =>"Please enter adharnumber","data"=>$data);
        }
        return response()->json($return, $status);
    }
    public function submit_adhar_with_otp(Request $request){
        $userid = login_User_ID();
        $YOUR_TOKEN=PAN_ADHAR_TOKEN();
        $data=array();
        $message='';
        $success=0;
        $status = $this->err;
        $validator = Validator::make($request->all(), [
            'client_id' => 'required',
            'mobile_number' => 'required',
            'otp' => 'required'
        ]);
        if($validator->fails()) {
            $message = 'Please enter all (*) fields';
        }else{
            $client_id      = $request->client_id;
            $mobile_number  = $request->mobile_number;
            $otp            = $request->otp;
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://kyc-api.aadhaarkyc.io/api/v1/aadhaar-v2/submit-otp',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "client_id": "'.$client_id.'",
                "otp": "'.$otp.'",
                "mobile_number": "'.$mobile_number.'"
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer '.$YOUR_TOKEN
            ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            if($response!=''){
                $resp = json_decode($response,true);
                if(trim($resp['status_code'])==200){
                    $data = $resp['data'];
                    $UserDetails = UserDetail::where('user_id',$userid)->first();
                    if(!is_null($UserDetails->pan_verified_at)){
                        $Pan_Det    = $UserDetails->pan_response;
                        $Pan_Arr_Dt = json_decode($Pan_Det,true);
                        $pan_name   = trim(strtolower($Pan_Arr_Dt['full_name']));
                        $adhar_name = trim(strtolower($data['full_name']));
                        if($pan_name==$adhar_name){
                            UserDetail::where('user_id',$userid)->update(['adhar_number'=>$data['aadhaar_number'],'adhar_verified_at'=>$date('Y-m-d H:i:s'),'adhar_response'=>$response]);
                            $return = array("success" =>1, "message" =>"Adhar verified successfully","data"=>$data);
                        }else{
                            $return = array("success" =>0, "message" =>"Adhar name not matching with pan please verify proper pancard first","data"=>$data);
                        }
                    }else{
                        $return = array("success" =>0, "message" =>"Please verify pan card","data"=>$data);
                    }
                }else{
                    $msg = ($resp['message']=='')?'Invali details provided':$resp['message'];
                    $return = array("success" =>0, "message"=>$msg,"data"=>$data);
                }
            }else{
                $return = array("success" =>$success, "message" =>"Invalid otp","data"=>$data);
            }
        }
        return response()->json($return, $status);
    }
    public function verify_pan(Request $request,$pannumber){
        $userid = login_User_ID();
        $YOUR_TOKEN=PAN_ADHAR_TOKEN();
        $data = array();
        if($pannumber!=''){
            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://kyc-api.aadhaarkyc.io/api/v1/pan/pan',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS =>'{
                "id_number": "'.$pannumber.'"
            }',
              CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization:Bearer '.$YOUR_TOKEN
              ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            if($response!=''){
                $resp = json_decode($response,true);
                if(trim($resp['status_code'])==200){
                    $data = $resp['data'];
                    $pan_number = $data['pan_number'];
                    $full_name  = $data['full_name'];
                    $client_id  = $data['client_id'];
                    $userid     = login_User_ID();
                    $Us_Detail  = User::find($userid);
                    UserDetail::where('user_id',$userid)->update(['pan_number'=>$pan_number,'pan_verified_at'=>$date('Y-m-d H:i:s'),'pan_response'=>$response]);
                    $return = array("success" =>1, "message" =>'Pan verified successfully',"data"=>$data);
                    $status = $this->succ;
                }else{
                    $return = array("success" =>0, "message" =>$resp['message'],"data"=>$data);
                    $status = $this->err;
                }
            }else{
                $return = array("success" =>0, "message"=>"Try again","data"=>$data);
                $status = $this->err;
            }
        }else{
            $return = array("success" =>0, "message" =>"Please enter pannumber","data"=>$data);
            $status = $this->err;
        }
        $Pan = UserDetail::where('user_id',$userid)->first('pan_attempts');
        $pan_attempts = $Pan['pan_attempts']+1;
        UserDetail::where('user_id',$userid)->update(['pan_attempts'=>$pan_attempts]);
        return response()->json($return, $status);
    }
    public function forgot_password(Request $request){
        $data=array();
        $status = $this->err;
        $message='';
        $success=0;
        $validator = Validator::make($request->all(),['mobile' => 'required']);
        if($validator->fails()) {
            $message = 'Mobile number is required';
        }else{
            $Check_Mobile = User::where('mobile_number','=',$request->mobile)->first();
            if(is_null($Check_Mobile)){
                $message = 'Invalid mobile number';
            }else{
                $otp = Generate_Otp();
                $User_Detail = UserDetail::where('user_id','=',$Check_Mobile->id)->first();
                if(is_null($User_Detail)){
                    $User_Detail = new UserDetail();
                    $User_Detail->user_id       = $Check_Mobile->id;
                    $User_Detail->first_name    = $Check_Mobile->name;
                }else{
                    $User_Detail->email_otp  = $otp;
                    $User_Detail->mobile_otp = $otp;
                }
                $User_Detail->save();
                $success = 1;
                $status = $this->succ;
                $message = 'Your new password sent to registered mobilenumber successfully';
            }
        }
        $resp = array('success'=>$success,'message'=>$message,'data'=>$data);
        return response()->json($resp, $status);
    }
    public function upload_profile_pic(Request $request){
        $userid = login_User_ID();
        $data=array();
        $status = $this->err;
        $message='Upload profile pic';
        $success=0;
        $profile = @$request->file('file');
        if(!file_exists('uploads')) {mkdir('uploads', 0777, true);}
		$destinationPath = public_path('uploads');
		if($profile!= '' && $profile!=null && $profile!='undefined'){
			$file = request()->file('file');
			$image = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
			$file->move($destinationPath, $image);
            $user = User::find($userid);
            $user->profile_pic = 'uploads/'.$image;
            $user->save();
            $status = $this->succ;
            $message='Profile pic uploaded successfully';
            $success=1;
            $data['profile_pic']=$user->profile_pic;
		}
        $resp = array('success'=>$success,'message'=>$message,'data'=>$data);
        return response()->json($resp, $status);
    }
    public function update_contact_details(Request $request){
        $userid = login_User_ID();
        $data=array();
        $status = $this->err;
        $message='';
        $success=0;
        $validator = Validator::make($request->all(),[
            'address'       => 'required',
            'pincode'       => 'required',
            'country_id'    => 'required',
            'state_id'      => 'required',
            'city_id'       => 'required'
        ]);
        if($validator->fails()) {
            $message = 'Please enter all (*) fields';
        }else{
            $User_Detail = UserDetail::where('user_id','=',$userid)->first();
            $User_Detail->address       = $request->address;
            $User_Detail->pincode       = $request->pincode;
            $User_Detail->country_id    = $request->country_id;
            $User_Detail->state_id      = $request->state_id;
            $User_Detail->city_id       = $request->city_id;
            $User_Detail->save();
            $message = 'Contact details added successfully';
        }
        $resp = array('success'=>$success,'message'=>$message,'data'=>$data);
        return response()->json($resp, $status);
    }
    public function kyc_update(Request $request){
        $userid = login_User_ID();
        $data=array();
        $status = $this->err;
        $message='';
        $success=0;
        $validator = Validator::make($request->all(),[
            'address'       => 'required',
            'pincode'       => 'required',
            'country_id'    => 'required',
            'state_id'      => 'required',
            'city_id'       => 'required',
            'name'          => 'required',
            'email'          => 'required',
            'dob'            => 'required',
            'adhar_file'     => 'required',
            'pan_file'       => 'required',
            'pan_number'     => 'required',
            'adhar_number'   => 'required'
        ]);
        if($validator->fails()) {
            $message = 'Please enter all (*) fields';
            $message = $validator->messages();
        }else{
            $User_Detail = UserDetail::where('user_id','=',$userid)->first();
            $User_Detail->address       = $request->address;
            $User_Detail->pincode       = $request->pincode;
            $User_Detail->country_id    = $request->country_id;
            $User_Detail->state_id      = $request->state_id;
            $User_Detail->city_id       = $request->city_id;
            $User_Detail->first_name    = $request->name;
            $User_Detail->dob           = YY_MM_DD($request->dob);
            $User_Detail->adhar_number  = $request->city_id;
            $User_Detail->pan_number    = $request->city_id;
            $adhar_file = @$request->file('adhar_file');
            if(!file_exists('uploads')) {mkdir('uploads', 0777, true);}
            $destinationPath = public_path('uploads');
            if($adhar_file!= '' && $adhar_file!=null && $adhar_file!='undefined'){
                $file = request()->file('adhar_file');
                $image = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $file->move($destinationPath, $image);
                $User_Detail->adhar_file = 'uploads/'.$image;
            }
            $pan_file = @$request->file('pan_file');
            if(!file_exists('uploads')) {mkdir('uploads', 0777, true);}
            $destinationPath = public_path('uploads');
            if($pan_file!= '' && $pan_file!=null && $pan_file!='undefined'){
                $file = request()->file('pan_file');
                $image = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $file->move($destinationPath, $image);
                $User_Detail->pan_file = 'uploads/'.$image;
            }
            $User_Detail->save();
            $user = User::find($userid);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();
            $message = 'kyc details updated successfully';
        }
        $resp = array('success'=>$success,'message'=>$message,'data'=>$data);
        return response()->json($resp, $status);
    }
    protected function createNewToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ];
    }
}
