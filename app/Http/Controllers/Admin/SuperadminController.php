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
}
