<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

if(!function_exists('user_email')){
    function user_email(){
        $user = Auth::user();
        return $user->email;
    }
}