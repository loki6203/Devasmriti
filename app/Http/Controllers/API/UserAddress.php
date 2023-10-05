<?php

/**
 * Created by Reliese Controller.
 */

namespace App\Http\Controllers;

use App\Models\UserAddress;
use Illuminate\Http\Request;

class UserAddressController extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $UserAddresss = UserAddress::latest()->paginate(10);
        return [
            "status" => 1,
            "data" => $UserAddresss
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $UserAddress = UserAddress::create($request->all());
        return [
            "status" => 1,
            "data" => $UserAddress
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserAddress  $UserAddress
     * @return \Illuminate\Http\Response
     */
    public function show(UserAddress $UserAddress)
    {
        return [
            "status" => 1,
            "data" =>$UserAddress
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserAddress  $UserAddress
     * @return \Illuminate\Http\Response
     */
    public function edit(UserAddress $UserAddress)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserAddress  $UserAddress
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserAddress $UserAddress)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $UserAddress->update($request->all());

        return [
            "status" => 1,
            "data" => $UserAddress,
            "msg" => "UserAddress updated successfully"
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserAddress  $UserAddress
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserAddress $UserAddress)
    {
        $UserAddress->delete();
        return [
            "status" => 1,
            "data" => $UserAddress,
            "msg" => "UserAddress deleted successfully"
        ];
    }
}
