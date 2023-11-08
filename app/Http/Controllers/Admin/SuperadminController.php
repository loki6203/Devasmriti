<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\File;
use Session;
use Validator;
use Auth;
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
use App\Models\AuthUser;
use App\Models\User;
use App\Models\UserFamilyDetail;
use App\Models\UserAddress;
use App\Models\Relation;
use App\Models\Image;
use App\Models\Rasi;
use App\Models\Temple;
use App\Models\Order;
use App\Models\OrderSeva;
use App\Models\SevaPrice;

use App\Models\Seva;

use Maatwebsite\Excel\Facades\Excel;
//use App\Imports\ImportUser;
use App\Exports\ExportOrder;


class SuperadminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function __construct()
    {	
		$this->middleware('validSuperadmin', ['except' => ['index','check_login']]);
    }
	
	public function index(){
		if(Session::has('loggedin_user_id')){
			return redirect('/dashboard');
		}else{
			return view('admin/index');
		}
	}
	public function dashboard(){
		return view('admin/dashboard');
	}
    public function user_management(){
		$User = User::where('user_type','=','user')->get();
		return view('admin/user_management',['user' => $User]);
	}
    public function add_user(){
		//$Country = Country::where('is_active', '=', '1')->orderby('name', 'asc')->get();
		$Country = Country::pluck('name','id')->prepend('Please Select','');

		//dd($Country->toArray());
		//$State = State::where('is_active', '=', '1')->orderby('name', 'asc')->get();
		$State = State::pluck('name','id')->prepend('Please Select','');
		return view('admin/add_user', ['state' => $State, 'country'=>$Country]);
	}
	
	public function upload($file_name, $file_path='./uploads', $file_type='NA') {
		$image = $file_name;
		$ext = '.'.$image->getClientOriginalExtension();
		$fileName = str_replace($ext, date('dmYHi') . $ext, $image->getClientOriginalName());
		$path = $file_path;
		$image->move($path,$fileName);
		
		$data = new Image();
		$data->url          = $fileName;
		$data->domain       = url('/');
		$data->image_type   = $file_type;
		$data->name         = $image->getClientOriginalName();
		$data->save();
		return $data->id;
	}
	
	public function save_user(Request $request){
		$request->validate([
            "fname"	=> "required",
            //"lname"	=> "required",
			"email" => "required|email",
			"mobile_number" => "required",
        ]);
		$user = new User;
		$chk_email = User::where('email', '=', $request->email)->first();
		$chk_mobile_number = User::where('mobile_number', '=', $request->mobile_number)->first();
		if ($chk_email === null && $chk_mobile_number === null) {
			$profile_pic_id='';
			if($request->hasFile('file')) {
				$profile_pic_id = $this->upload($request->file('file'), public_path('uploads/users/'), 'User');
			}
			
			$user->fname = $request->fname;
			$user->lname = $request->lname;
			$user->email = $request->email;
			$user->mobile_number = $request->mobile_number;
			if($profile_pic_id) {
				$user->profile_pic_id = $profile_pic_id;
			}
			$user->dob = $request->dob;
			$user->about_me = $request->about_me;
			$user->user_type = 'user';
			$user->save();
			
			/*$useraddress = new UserAddress;
			foreach ($request->address_name as $key=>$address_name)
			{
				$tmp[] = [
					'user_id' => $user->id,
					'address_name' => $request->address_name[$key],
					'fname' => $request->fname,
					'lname' => $request->lname,
					'email' => $request->email,
					'phone_no' => $request->mobile_number,
					'whatsup_no' => $request->whatsup_no[$key],
					'country_id' => $request->country[$key],
					'state_id' => $request->state[$key],
					'city_id' => $request->city[$key],
					'address_1' => $request->address_1[$key],
					'address_2' => $request->address_2[$key],
					'pincode' => $request->pincode[$key]					
				];
			}
			$useraddress->insert($tmp);
			*/
			//dd($tmp);

			//$useraddress->fill($tmp);
			//dd($useraddress);
			//$user->user_addresses()->save($useraddress);
			
		}else{
			echo "User already existed";exit;
		}
		return redirect('user_management');
	}
	public function edit_user($id){
		$Country = Country::pluck('name','id')->prepend('Please Select','');
		$State = State::pluck('name','id')->prepend('Please Select','');
		
		$User = User::where('id','=', $id)->with('image')->first();
		//dd($User); exit;
		
		/*$User = User::find($id)->with('user_addresses');
		$Addr = $User->user_addresses;
		$User = User::join('user_addresses', 'user_addresses.user_id', '=', 'users.id')
		->leftjoin('images', 'images.id', '=', 'users.profile_pic_id')
		->where('users.id','=',$id)->get(['users.*', 'user_addresses.*', 'images.name as profile_pic_name']);
		
		if($User) {
			$City = City::pluck('name','id')->where('id', $User[0]->city_id);
		}*/
		
		//return view('admin/edit_user',['user' => $User, 'country'=>$Country, 'state'=>$state, 'city'=>$City]);
		return view('admin/edit_user',['user' => $User]);
	}
	public function update_user(Request $request){
		$request->validate([
            "fname"	=> "required",
            //"lname"	=> "required",
			"email" => "required|email",
			"mobile_number" => "required",
        ]);
		
		$user = User::find($request->id);
		
		$chk_email = User::where('email', '=', $request->email)->where('id', '!=', $request->id)->first();
		$chk_mobile_number = User::where('mobile_number', '=', $request->mobile_number)->where('id', '!=', $request->id)->first();
		if ($chk_email === null && $chk_mobile_number === null) {
			$profile_pic_id='';
			if($request->hasFile('file')) {
				$profile_pic_id = $this->upload($request->file('file'), public_path('uploads/users/'), 'User');
			}
			
			$user->fname = $request->fname;
			$user->lname = $request->lname;
			$user->email = $request->email;
			$user->mobile_number = $request->mobile_number;
			$user->password = bcrypt('123456');
			if($profile_pic_id) {
				$user->profile_pic_id = $profile_pic_id;
			}
			$user->dob = $request->dob;
			$user->about_me = $request->about_me;
			$user->user_type = 'user';
			$user->save();
			
		} else {
			echo "User already existed";exit;
		}
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
		$country = Country::where('is_active','=','1')->get();
		return view('admin/add_state',['country' => $country]);
	}
	public function save_state(Request $request){
		$chk_state = State::where([['country_id', '=', $request->country_id],['name', '=', $request->name]])->first();
		$chk_state1 = State::where('name', '=', $request->name)->first();
		if ($chk_state === null) {
			$state = new State();
			$state->country_id = $request->country_id;
			$state->name = $request->name;
			$state->is_active = '1';
			$state->save();
		}else{
			echo "this state already existed";exit;
		}
		return redirect('state');
	}
	public function edit_state($id){
		$Country = Country::where('is_active','=','1')->get();
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
		$City = City::with('state', 'country')->get();//country
		//dd($City);
		return view('admin/city',['city' => $City]);
	}
	public function add_city(){
		$Country = Country::where('is_active','=','1')->get();
		$State = State::where('is_active','=','1')->get();
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
		$Country = Country::where('is_active','=','1')->get();
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
		$err = $request->old_pass;
		$old_pass = $request->old_pass;
		$new_pass = $request->new_pass;
		$c_pass = $request->c_pass;
		if($new_pass==$c_pass){
			$userCredentials = array('id'=>Session::get('loggedin_user_id'), 'password'=>$request->old_pass);
			if(Auth::attempt($userCredentials)) {
				$chk_login = Auth::user();
				$id = $chk_login->id;
				$old_pass = $old_pass;
				$new_pass = $new_pass;
				$c_pass = $c_pass;
				$newpassword=bcrypt($c_pass);
				User::where('id',$id)->update(array('password'=>$newpassword));
				Auth::logout();
				Session::flush();
				$err = "";
			}else{
				$err = "Opps! You have entered Incorrect Password";
			}
		}else{
			$err = "New Password and Confirm Password didn't match";
		}
		echo $err;exit;
		// return redirect('change_password')->with('error',$err);
	}
	public function check_login(Request $request){
		$request->validate([
			"username" => "required",
			"password" => "required"
		]);
		
		//$userCredentials = $request->only('username', 'password');
		$userCredentials = array('mobile_number'=>$request->username, 'password' =>$request->password ,'user_type'=>'superadmin');
		if (Auth::attempt($userCredentials)) {
			$Username = $request->username;
			$Password = bcrypt($request->password);
			$chk_login = Auth::user();
			if ($chk_login != '') {
				Session::put('loggedin_user_id', $chk_login->id);
				Session::put('loggedin_user', $chk_login);
				return redirect('dashboard');
			}else{
				return back()->with('error', 'You Have Entered Incorrect Details');
			}
		}else{
			return back()->with('error', 'Whoops! invalid username or password.');
		}
		return redirect('index');
	}
	
	public function check_login_old(Request $request){
		if(Session::has('loggedin_user_id')){
			return redirect('/');
		}else{
			$request->validate([
				"username" => "required",
				"password" => "required|min:4"
			]);
			
			$userCredentials = $request->only('username', 'password');
			//dd($userCredentials);
			$Username = $request->username;
			$Password = bcrypt($request->password);
			//dd($Password);
			$userExists = AuthUser::where('username', '=', $Username)->first();
			//if($userExists) $userExists=$userExists->toArray();
			if ($userExists && count($userExists->toArray())>0) {
				$chk_login = AuthUser::where([['username', '=', $Username]])->first(); //,['password', '=', $Password]
				//dd($chk_login);
				if ($chk_login) {
					Session::put('admin_id', $chk_login->id);
					return redirect('dashboard');
				}else{
					echo "You Have Entered Incorrect Details";exit;
				}
			}else{
				return back()->with('error', 'Whoops! invalid username or password.');
			}
			return redirect('index');
		}
	}
	public function logout(){ //dd(Auth::user());
		Auth::logout();
		Session::flush();
		return redirect('index');
 	}
	
	public function rasi(){
		$rasi = Rasi::all();
		return view('admin/rasi',['rasi' => $rasi]);
	}
	public function add_rasi(){
		return view('admin/add_rasi');
	}
	public function save_rasi(Request $request){
		$rasi = new Rasi();
		$chk_name = Rasi::where('name', '=', $request->name)->first();
		if ($chk_name === null) {
			$rasi->name = $request->name;
			$rasi->save();
		}else{
			echo "this rasi already existed";exit;
		}
		return redirect('rasi');
	}
	public function edit_rasi($id){
		$Rasi = Rasi::where('id','=',$id)->first();
		return view('admin/edit_rasi',['rasi' => $Rasi]);
	}
	public function update_rasi(Request $request){
		$id = $request->id;
		$name = $request->name;
		$Rasi = Rasi::find($id);
		$Rasi->name=$name;
		$Rasi->save();
		return redirect('/rasi')->with('message', 'The success message!');
	}
	public function change_rasi_status($id='',$status=''){
		Rasi::where('id',$id)->update(['is_active'=>$status]);
		return redirect('rasi');
	}
	
	public function temple(){
		$temples = Temple::all();
		return view('admin/temples',['temples' => $temples]);
	}
	public function add_temple(){
		$Country = Country::pluck('name','id')->prepend('Please Select','');
		$State = State::pluck('name','id')->prepend('Please Select','');
		return view('admin/add_temple', ['state' => $State, 'country'=>$Country]);
	}
	public function save_temple(Request $request){
		$temple = new Temple();
		$chk_name = Rasi::where('name', '=', $request->name)->first();
		if ($chk_name === null) {
			$request->validate([
				'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:20480',
			]);
		
			$profile_pic_id='';
			if($request->hasFile('image')) {
				$profile_pic_id = $this->upload($request->file('image'), public_path('uploads/temples/'), 'User');
			}
			//dd($profile_pic_id);
			
			$temple->featured_image_id = $profile_pic_id;
			$temple->name = $request->name;
			$temple->code = $request->code;
			$temple->about = $request->about_me;
			$temple->country_id = $request->country;
			$temple->state_id = $request->state;
			$temple->city_id = $request->city;
			$temple->pincode = $request->pincode;
			$temple->address = $request->address;
			$temple->latitude = $request->latitude;
			$temple->longitude = $request->longitude;
			
			$temple->save();
		}else{
			echo "this temple already existed";exit;
		}
		return redirect('temple');
	}
	public function edit_temple($id){
		$Country = Country::pluck('name','id')->prepend('Please Select','');
		$State = State::pluck('name','id')->prepend('Please Select','');
		//$temple = Temple::where('id','=',$id)->first();
		
		$temple = Temple::leftjoin('images', 'images.id', '=', 'temples.featured_image_id')
		->leftjoin('cities', 'cities.id', '=', 'temples.country_id')
		->where('temples.id','=',$id)->get(['temples.*', 'images.name as profile_pic_name', 'cities.name as city_name']);
		
		//dd($temple);
		return view('admin/edit_temple',['temple'=>$temple, 'country'=>$Country, 'state'=>$State]);
	}
	public function update_temple(Request $request){ 
		$id = $request->id;
		
		$Temple = Temple::find($id);
		
		$profile_pic_id='';
		if($request->hasFile('image')) {
			$request->validate([
				'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:20480',
			]);
			$profile_pic_id = $this->upload($request->file('image'), public_path('uploads/temples/'), 'User');
			$Temple->featured_image_id = $profile_pic_id;
		}
		
		$Temple->name = $request->name;
		$Temple->code = $request->code;
		$Temple->about = $request->about_me;
		$Temple->country_id = $request->country;
		$Temple->state_id = $request->state;
		$Temple->city_id = $request->city;
		$Temple->pincode = $request->pincode;
		$Temple->address = $request->address;
		$Temple->latitude = $request->latitude;
		$Temple->longitude = $request->longitude;
		
		
		$Temple->save();
		
		return redirect('/temple')->with('message', 'The success message!');
	}
	public function change_temple_status($id='',$status=''){
		Temple::where('id',$id)->update(['is_active'=>$status]);
		return redirect('temple');
	}
	
	

	
    public function user_family($user_id, $id=''){
		$UserFamilyDetail = UserFamilyDetail::where('user_id','=',$user_id)->get();
		$Rasi = Rasi::where('is_active','=','1')->get();
		$Relation = Relation::where('is_active','=','1')->get();
		
		$UserSingleFamily=array();
		if($id) {
			//$UserSingleFamily = UserFamilyDetail::where('id','=',$id)->where('user_id','=',$user_id)->first();
			$UserSingleFamily = UserFamilyDetail::with('rasi')->with('relation')->where('user_family_details.id','=',$id)->where('user_family_details.user_id','=',$user_id)->first();
			//dd($UserSingleFamily);
		}
		//dd($UserSingleFamily);
		return view('admin/user_family', ['userfamilydetails' => $UserFamilyDetail, 'rasi' => $Rasi, 'relation' => $Relation, 'user_id'=>$user_id, 'usersinglefamily' => $UserSingleFamily]);
	}
	
	public function save_family(Request $request){ //dd($request);
		$request->validate([
            "full_name"	=> "required", 
			"dob"	=> "required",
			"relation" => "required",
			"rasi" => "required"
			
		]);
		//dd($request->user_id); 
		
		if($request->id!='') {
			$Family = UserFamilyDetail::find($request->id);
			$id = $request->id;
		} else {
			$Family = new UserFamilyDetail();
		}
		$Family->user_id=$request->user_id;
		$Family->family_type=$request->family_type;
		$Family->full_name=$request->full_name;
		$Family->dob=$request->dob;
		$Family->relation_id=$request->relation;
		$Family->rasi_id=$request->rasi;
		$Family->gothram=$request->gothram;
		$Family->nakshatram=$request->nakshatram;
		$Family->description=$request->description;
		$Family->save();		

		return redirect('user_family/'.$request->user_id);
	}
		
	public function change_family_status($id='',$status='', $user_id=''){
		UserFamilyDetail::where('id',$id)->update(['is_active'=>$status]);
		return redirect('user_family/'.$user_id);
	}
	
	public function user_address($user_id, $id=''){
		$UserAddress = UserAddress::where('user_id','=',$user_id)->get();
		$Country = Country::where('is_active','=','1')->get();
		$State = State::where('is_active','=','1')->get();
		//dd($UserAddress);
		$UserSingleAddress=array();
		if($id) {
			//$UserSingleAddress = UserAddress::where('id','=',$id)->where('user_id','=',$user_id)->first();
			$UserSingleAddress = UserAddress::with('Country')->with('State')->with('City')->where('user_addresses.id','=',$id)->where('user_addresses.user_id','=',$user_id)->first();
			//dd($UserSingleAddress);
		}
		//dd($UserSingleAddress);
		return view('admin/user_address', ['useraddress' => $UserAddress, 'country' => $Country, 'state' => $State, 'user_id'=>$user_id, 'usersingleaddress' => $UserSingleAddress]);
	}
	
	public function save_address(Request $request){ //dd($request);
		$request->validate([
            "address_name"	=> "required", 
			"whatsup_no"	=> "required",
			"country" => "required",
			"state" => "required",
			"city" => "required",
			"address_1" => "required",
			"pincode" => "required"
			
		]);
		//dd($request->user_id); 
		
		$user = User::where('id','=',$request->user_id)->first();
		//dd($user);
		if($request->id!='') {
			$Address = UserAddress::find($request->id);
			$id = $request->id;
		} else {
			$Address = new UserAddress();
		}
		//dd($request);
		$Address->fname = $user->fname;
		$Address->lname = $user->lname;
		$Address->email = $user->email;
		$Address->phone_no = $user->mobile_number;
		
		$Address->user_id=$request->user_id;
		$Address->address_name=$request->address_name;
		$Address->whatsup_no=$request->whatsup_no;
		$Address->country_id=$request->country;
		$Address->state_id=$request->state;
		$Address->city_id=$request->city;
		$Address->address_1=$request->address_1;
		$Address->address_2=$request->address_2;
		$Address->pincode=$request->pincode;
		$Address->save();		

		return redirect('user_address/'.$request->user_id);
	}
		
	public function change_address_status($id='',$status='', $user_id=''){
		UserAddress::where('id',$id)->update(['is_active'=>$status]);
		return redirect('user_address/'.$user_id);
	}
	
	public function relation(){
		$relation = Relation::all();
		return view('admin/relation',['relation' => $relation]);
	}
	public function add_relation(){
		return view('admin/add_relation');
	}
	public function save_relation(Request $request){
		$relation = new Relation();
		$chk_name = Relation::where('name', '=', $request->name)->first();
		if ($chk_name === null) {
			$relation->name = $request->name;
			$relation->save();
		}else{
			echo "this relation already existed";exit;
		}
		return redirect('relation');
	}
	public function edit_relation($id){
		$Relation = Relation::where('id','=',$id)->first();
		return view('admin/edit_relation',['relation' => $Relation]);
	}
	public function update_relation(Request $request){
		$id = $request->id;
		$name = $request->name;
		$Relation = Relation::find($id);
		$Relation->name=$name;
		$Relation->save();
		return redirect('/relation')->with('message', 'The success message!');
	}
	public function change_relation_status($id='',$status=''){
		Relation::where('id',$id)->update(['is_active'=>$status]);
		return redirect('relation');
	}
	
	
	public function seva(){
		$sevas = Seva::all();
		//dd($sevas); //work stopped here before order module
		return view('admin/seva',['sevas' => $sevas]);
	}
	public function add_seva(){
		$Country = Country::pluck('name','id')->prepend('Please Select','');
		$State = State::pluck('name','id')->prepend('Please Select','');
		return view('admin/add_temple', ['state' => $State, 'country'=>$Country]);
	}
	public function save_seva(Request $request){
		$temple = new Temple();
		$chk_name = Rasi::where('name', '=', $request->name)->first();
		if ($chk_name === null) {
			$request->validate([
				'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:20480',
			]);
		
			$profile_pic_id='';
			if($request->hasFile('image')) {
				$profile_pic_id = $this->upload($request->file('image'), public_path('uploads/temples/'), 'User');
			}
			//dd($profile_pic_id);
			
			$temple->featured_image_id = $profile_pic_id;
			$temple->name = $request->name;
			$temple->code = $request->code;
			$temple->about = $request->about_me;
			$temple->country_id = $request->country;
			$temple->state_id = $request->state;
			$temple->city_id = $request->city;
			$temple->pincode = $request->pincode;
			$temple->address = $request->address;
			$temple->latitude = $request->latitude;
			$temple->longitude = $request->longitude;
			
			$temple->save();
		}else{
			echo "this temple already existed";exit;
		}
		return redirect('temple');
	}
	public function edit_seva($id){
		$Country = Country::pluck('name','id')->prepend('Please Select','');
		$State = State::pluck('name','id')->prepend('Please Select','');
		//$temple = Temple::where('id','=',$id)->first();
		
		$temple = Temple::leftjoin('images', 'images.id', '=', 'temples.featured_image_id')
		->leftjoin('cities', 'cities.id', '=', 'temples.country_id')
		->where('temples.id','=',$id)->get(['temples.*', 'images.name as profile_pic_name', 'cities.name as city_name']);
		
		//dd($temple);
		return view('admin/edit_temple',['temple'=>$temple, 'country'=>$Country, 'state'=>$State]);
	}
	public function update_seva(Request $request){ 
		$id = $request->id;
		
		$Seva = Seva::find($id);
		
		$profile_pic_id='';
		if($request->hasFile('image')) {
			$request->validate([
				'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:20480',
			]);
			$profile_pic_id = $this->upload($request->file('image'), public_path('uploads/temples/'), 'User');
			$Temple->featured_image_id = $profile_pic_id;
		}
		
		$Temple->name = $request->name;
		$Temple->code = $request->code;
		$Temple->about = $request->about_me;
		$Temple->country_id = $request->country;
		$Temple->state_id = $request->state;
		$Temple->city_id = $request->city;
		$Temple->pincode = $request->pincode;
		$Temple->address = $request->address;
		$Temple->latitude = $request->latitude;
		$Temple->longitude = $request->longitude;
		
		
		$Temple->save();
		
		return redirect('/seva')->with('message', 'The success message!');
	}
	public function change_seva_status($id='',$status=''){
		Temple::where('id',$id)->update(['is_active'=>$status]);
		return redirect('seva');
	}
	
	public function order_old(){
		$order_sevas = OrderSeva::with('Order')->with('seva_price')->with('Order.user')->with('Order.user_address')->with('Order.user_address.Country')->with('Order.user_address.State')->with('Order.user_address.City')->with('Order.user_billing')->with('Order.seva_coupon')->with('userFamilyDetail')->with('userFamilyDetail.relation')->with('userFamilyDetail.rasi')->get();
		
		return view('admin/order_old',['order_sevas'=>$order_sevas]);
	}
	
	public function order(){
		$orders = Order::with('order_sevas')->with('user')->with('user_address')->with('user_billing')->with('seva_coupon')->get();
		$order_sevas = OrderSeva::with('seva_price')->get()->toArray();
		//dd($order_sevas);
		$order_wise_sevas=array();
		foreach($order_sevas as $os) {
			//dd($os);
			if(!isset($order_wise_sevas[$os['order_id']])) $order_wise_sevas[$os['order_id']]=array();
			$order_wise_sevas[$os['order_id']][]=$os;
		} //dd($order_wise_sevas);
		return view('admin/order',['order'=>$orders, 'order_wise_sevas'=>$order_wise_sevas]);
	}
	
	public function export_Order(Request $request){
		// $order_sevas = OrderSeva::with('Order')
		// ->with('seva_price')->with('Order.user')
		// ->with('Order.user_address')
		// ->with('Order.user_address.Country')
		// ->with('Order.user_address.State')
		// ->with('Order.user_address.City')
		// ->with('Order.user_billing')
		// ->with('Order.seva_coupon')
		// ->with('userFamilyDetail')
		// ->with('userFamilyDetail.relation')
		// ->with('userFamilyDetail.rasi')
		// ->get();

		$order_sevas = OrderSeva::with('Order')
		->with('seva_price')
		->with('Order.user')
		->with('Order.user')
		->with('Order.user_address')
		->with('Order.user_address.Country')
		->with('Order.user_address.State')
		->with('Order.user_address.City')
		->with('Order.user_billing')
		->with('Order.user_billing.Country')
		->with('Order.user_billing.State')
		->with('Order.user_billing.City')
		->with('order_seva_family_details.user_family_detail')
		->with('order_seva_family_details.user_family_detail.relation')
		->with('order_seva_family_details.user_family_detail.rasi')
		->get();

        // return Excel::download(new ExportOrder, 'orders.xlsx');

		$name=date('Y-m-d').'_orders.xls';
        header("Content-Type: application/vnd.ms-excel");
		header("Content-disposition: Attachment; filename=$name");
		$HeadData="Booking Id\tUserName\tMobile\tMail\tTrans.No\tName\tRelation\tDOB\tGothram\tRaasi\tNakshatram\tAddress 1\tAddress 2\tState\tCity\tPincode\tAddress Name\tBooking Date\n";
		if($order_sevas){
			$aaa=1;
			foreach($order_sevas as $sevas){
				$BookingId=$sevas['Order']->invoice_id;

				$UserNam=@$sevas['Order']['user']['fname'];
				if(isset($sevas['Order']['user']['lname'])){
					$UserNam=$sevas['Order']['user']['fname'].' '.$sevas['Order']['user']['lname'];
				}
				$Mobile			=	@$sevas['Order']['user']['mobile_number'];
				$Mail			=	@$sevas['Order']['user']['email'];
				$TransNo		=	@$sevas['Order']->transaction_id;
				
				$Name			=	@$sevas['order_seva_family_details'][0]['user_family_detail']['full_name'];
				$Relation		=	@$sevas['order_seva_family_details'][0]['user_family_detail']['relation']['name'];
				$DOB			=	@$sevas['order_seva_family_details'][0]['user_family_detail']['dob'];
				$Gothram		=	@$sevas['order_seva_family_details'][0]['user_family_detail']['gothram'];
				$Raasi			=	@$sevas['order_seva_family_details'][0]['user_family_detail']['rasi']['name'];
				$Nakshatram		=	@$sevas['order_seva_family_details'][0]['user_family_detail']['nakshatram'];
				
				$Address1		=	@$sevas['Order']['user_address']['address_1'];
				$Address2		=	@$sevas['Order']['user_billing']['address_2'];
				$State			=	@$sevas['Order']['user_address']['State']['name'];
				$City			=	@$sevas['Order']['user_address']['City']['name'];
				$Pincode		=	@$sevas['Order']['user_address']['pincode'];
				$AddressName	=	@$sevas['Order']['user_address']['address_name'];
				
				$BookingDate	=	@Delivery_Date_With_Time($sevas['created_at']);
				
				$HeadData.=	"".$BookingId."\t".$UserNam."\t".$Mobile."\t".$Mail."\t".$TransNo."\t".$Name."\t".$Relation."\t".$DOB."\t".$Gothram."\t".$Raasi."\t".$Nakshatram."\t".$Address1."\t".$Address2."\t".$State."\t".$City."\t".$Pincode."\t".$AddressName."\t".$BookingDate."\n";
			}
		}
		echo $HeadData;exit;
    }
}