<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\File;
use Session;
use Validator;

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
    public function admin_management(){
		return view('admin/admin_management');
	}
    public function add_admin(){
		return view('admin/add_admin');
	}
    public function edit_admin(){
		return view('admin/edit_admin');
	}
}
