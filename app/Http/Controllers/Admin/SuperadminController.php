<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\File;
use Session;
use Validator;
use App\Models\AccountDeposit;
use App\Models\AccountHistory;
use App\Models\Biller;
use App\Models\BillPay;
use App\Models\City;
use App\Models\CommonGatewayCard;
use App\Models\Country;
use App\Models\FailedJob;
use App\Models\InternalTransfer;
use App\Models\Notification;
use App\Models\PaymentGateway;
use App\Models\RechargeHistory;
use App\Models\RentPay;
use App\Models\Setting;
use App\Models\State;
use App\Models\User;
use App\Models\UserDetail;

class SuperadminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function __construct()
    {

    }
	public function index(){
		return view('admin/index');
	}
	public function dashboard(){
		return view('admin/dashboard');
	}
    public function user_management(){
		$User = User::where('user_type','=','user')->get();
		return view('admin/user_management',['user' => $User]);
	}
    public function add_user(){
		return view('admin/add_user');
	}
	public function save_user(Request $request){
		$user = new User;
		$chk_email = User::where('email', '=', $request->email)->first();
		$chk_mobile_number = User::where('mobile_number', '=', $request->mobile_number)->first();
		if ($chk_email === null && $chk_mobile_number === null) {
			$user->name = $request->name;
			$user->email = $request->email;
			$user->mobile_number = $request->mobile_number;
			$user->user_type = 'user';
			$user->save();
		}else{
			echo "this admin already existed";exit;
		}
		return redirect('user_management');
	}
	public function edit_user($id){
		$User = User::where('id','=',$id)->first();
		return view('admin/edit_user',['user' => $User]);
	}
	public function update_user(Request $request){
		$id = $request->id;
		$name = $request->name;
		$email = $request->email;
		$mobile_number = $request->mobile_number;
		$User = User::find($id);
		$User->name=$name;
		$User->email=$email;
		$User->mobile_number=$mobile_number;
		$User->save();
		return redirect('/user_management');
	}
	public function admin_management(){
		$Admin = User::where('user_type','=','admin')->get();
		return view('admin/admin_management',['admin' => $Admin]);
	}
	public function add_admin(){
		return view('admin/add_admin');
	}
	public function save_admin(Request $request){
		$user = new User;
		$chk_email = User::where('email', '=', $request->email)->first();
		$chk_mobile_number = User::where('mobile_number', '=', $request->mobile_number)->first();
		if ($chk_email === null && $chk_mobile_number === null) {
			$user->name = $request->name;
			$user->email = $request->email;
			$user->mobile_number = $request->mobile_number;
			$user->user_type = 'admin';
			$user->save();
		}else{
			echo "this admin already existed";exit;
		}
		return redirect('admin_management');
	}
	public function change_admin_status($id='',$status='',$Type=''){
		User::where('id',$id)->update(['is_active'=>$status]);
		if($Type=='User'){
			return redirect('user_management');
		}else{
			return redirect('admin_management');
		}
	}
    public function edit_admin($id){
		$User = User::where('id','=',$id)->first();
		return view('admin/edit_admin',['user' => $User]);
	}
	public function update_admin(Request $request){
		$id = $request->id;
		$name = $request->name;
		$email = $request->email;
		$mobile_number = $request->mobile_number;
		$User = User::find($id);
		$User->name=$name;
		$User->email=$email;
		$User->mobile_number=$mobile_number;
		$User->save();
		return redirect('/admin_management')->with('message', 'The success message!');
	}
    public function password_recovery(){
		return view('admin/password_recovery');
	}
    public function user_transactions(){
		return view('admin/user_transactions');
	}
    public function payment_gateway_management(){
		return view('admin/payment_gateway_management');
	}
    public function wallet_management(){
		$wallet = AccountDeposit::with('user')->get();
		return view('admin/wallet_management',array('wallet' => $wallet));
	}
	public function support(){
		return view('admin/support');
	}
	public function transactions(){
		$transactions = AccountHistory::with('user')->get();
		return view('admin/transactions',['transactions' => $transactions]);
	}
	public function referral(){
		$referral = AccountHistory::with('user')->where('action_type','=','referel')->get();
		return view('admin/referral',['referral' => $referral]);
	}
	public function country(){
		$country = Country::all();
		return view('admin/country',['country' => $country]);
	}
	public function add_country(){
		return view('admin/add_country');
	}
	public function save_country(Request $request){
		$country = new Country();
		$chk_name = Country::where('name', '=', $request->name)->first();
		if ($chk_name === null) {
			$country->name = $request->name;
			$country->save();
		}else{
			echo "this country already existed";exit;
		}
		return redirect('country');
	}
	public function edit_country($id){
		$Country = Country::where('id','=',$id)->first();
		return view('admin/edit_country',['country' => $Country]);
	}
	public function update_country(Request $request){
		$id = $request->id;
		$name = $request->name;
		$User = Country::find($id);
		$User->name=$name;
		$User->save();
		return redirect('/country')->with('message', 'The success message!');
	}
	public function change_country_status($id='',$status=''){
		Country::where('id',$id)->update(['is_active'=>$status]);
		return redirect('country');
	}
	public function state(){
		$State = State::with('country')->get();
		return view('admin/state',['state' => $State]);
	}
	public function get_states(Request $request)
	{
		$id = $request->id;
		$State = State::with('country')->where('id','=',$id)->get();
		echo json_encode($State);
	}
	public function add_state(){
		$country = Country::where('is_active','=','active')->get();
		return view('admin/add_state',['country' => $country]);
	}
	public function save_state(Request $request){
		$chk_state = State::where([['country_id', '=', $request->country_id],['name', '=', $request->name]])->first();
		$chk_state1 = State::where('name', '=', $request->name)->first();
		if ($chk_state === null) {
			$state = new State();
			$state->country_id = $request->country_id;
			$state->name = $request->name;
			$state->is_active = 'active';
			$state->save();
		}else{
			echo "this state already existed";exit;
		}
		return redirect('state');
	}
	public function edit_state($id){
		$Country = Country::where('is_active','=','active')->get();
		$State = State::with('country')->where('id','=',$id)->first();
		return view('admin/edit_state',['country' => $Country,'state' => $State]);
	}
	public function update_state(Request $request){
		$chk_state = State::where([['id', '!=', $request->id],['country_id', '=', $request->country_id],['name', '=', $request->name]])->first();
		if ($chk_state === null) {
			$id = $request->id;
			$country_id = $request->country_id;
			$name = $request->name;
			$User = State::find($id);
			$User->country_id=$country_id;
			$User->name=$name;
			$User->save();
		}else{
			echo "this state already existed";exit;
		}
		return redirect('/state')->with('message', 'The success message!');
	}
	public function change_state_status($id='',$status=''){
		State::where('id',$id)->update(['is_active'=>$status]);
		return redirect('state');
	}
	public function city(){
		$City = City::with('country','state')->get();
		return view('admin/city',['city' => $City]);
	}
	public function add_city(){
		$Country = Country::where('is_active','=','active')->get();
		$State = State::where('is_active','=','active')->get();
		return view('admin/add_city',['country' => $Country,'state' => $State]);
	}
	public function save_city(Request $request){
		$chk_city = City::where([['country_id', '=', $request->country_id],['state_id', '=', $request->state_id],['name', '=', $request->name]])->first();
		if ($chk_city === null) {
			$city = new City();
			$city->country_id = $request->country_id;
			$city->state_id = $request->intState_id;
			$city->name = $request->name;
			$city->save();
		}else{
			echo "this city already existed";exit;
		}
		return redirect('city');
	}
	public function edit_city($id){
		$Country = Country::where('is_active','=','active')->get();
		$State = City::with('state')->where('id','=',$id)->first();
		$City = City::where('id','=',$id)->first();
		return view('admin/edit_city',['country' => $Country,'state' => $State,'city' => $City]);
	}
	public function update_city(Request $request){
		$chk_city = City::where([['id', '!=', $request->id],['country_id', '=', $request->country_id],['state_id', '=', $request->state_id],['name', '=', $request->name]])->first();
		if ($chk_city === null) {
			$id = $request->id;
			$country_id = $request->country_id;
			$state_id = $request->intState_id;
			$name = $request->name;
			$City = City::find($id);
			$City->country_id=$country_id;
			$City->state_id=$state_id;
			$City->name=$name;
			$City->save();
		}else{
			echo "this city already existed";exit;
		}
		return redirect('/city')->with('message', 'The success message!');
	}
	public function change_city_status($id='',$status=''){
		City::where('id',$id)->update(['is_active'=>$status]);
		return redirect('city');
	}
	public function change_password(){
		return view('admin/change_password');
	}
	public function update_password(Request $request){
		$data = Session::all();
		$old_pass = $request->old_pass;
		$new_pass = $request->new_pass;
		$c_pass = $request->c_pass;
		if($new_pass==$c_pass){
			$chk_password = User::where([['password', '=', $new_pass]])->first();
			if ($chk_password === null) {
				$id = $request->id;
				$old_pass = $old_pass;
				$new_pass = $new_pass;
				$c_pass = $c_pass;
				$User = User::find($id);
				$User->password=bcrypt($new_pass);
				$User->save();
			}else{
				echo "Opps! You have entered Incorrect Password";exit;
			}
		}else{
				echo "New Password and Confirm Password didn't match";exit;
			}
		return redirect('change_password');
	}
	public function check_login(Request $request){
		 $request->validate([
            "username"           =>    "required|email",
            "password"        =>    "required|min:6"
        ]);
		$userCredentials = $request->only('username', 'password');
		if (Auth::attempt($userCredentials)) {
			$Username = $request->username;
			$Password = bcrypt($request->password);
			$chk_login = User::where([['name', '=', $Username],['password', '=', $Password],['user_type', '!=', 'user']])->get();
			// echo $chk_login;exit;
			if ($chk_login != '') {
				Session::set('variableName', $chk_login->id);
				return redirect('dashboard');
			}else{
				echo "You Have Entered Incorrect Details";exit;
			}
		}else{
			return back()->with('error', 'Whoops! invalid username or password.');
		}
		return redirect('index');
	}
	public function logout(){
		Auth::logout();
		Session::flush();
		return redirect('index');
 	}
}