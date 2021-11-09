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
		$User->name=$email;
		$User->name=$mobile_number;
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
    public function edit_admin($id){
		$User = User::where('id','=',$id)->first();
		// echo "<pre>";print_r($User);exit;
		return view('admin/edit_admin',['user' => $User]);
	}
	public function update_admin(Request $request){
		$id = $request->id;
		$name = $request->name;
		$email = $request->email;
		$mobile_number = $request->mobile_number;
		$User = User::find($id);
		$User->name=$name;
		$User->name=$email;
		$User->name=$mobile_number;
		$User->save();
		return redirect('/admin_management');
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
		$wallet = AccountDeposit::all();
		$user =User::where('id','!=','')->with('account_deposits')->get();
		// echo "<pre>";print_r($user);exit;
		return view('admin/wallet_management',array('wallet' => $wallet,'user'=>$user));
	}
    public function referral_management(){
		return view('admin/referral_management');
	}
	public function support(){
		return view('admin/support');
	}
	public function transactions(){
		$transactions = AccountHistory::all();
		return view('admin/transactions',['transactions' => $transactions]);
	}
	public function referral(){
		$referral = AccountHistory::where('action_type','=','referel')->get();
		return view('admin/referral',['referral' => $referral]);
	}
	public function country(){
		$country = Country::all();
		return view('admin/country',['country' => $country]);
	}
	public function state(){
		$state = State::all();
		return view('admin/state',['state' => $state]);
	}
	public function city(){
		$city = City::all();
		return view('admin/city',['city' => $city]);
	}
}