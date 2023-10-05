<?php

/**
 * Created by Reliese Controller.
 */

namespace App\Http\Controllers;

use App\Models\UserCart;
use Illuminate\Http\Request;

class UserCartController extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $UserCarts = UserCart::latest()->paginate(10);
        return [
            "status" => 1,
            "data" => $UserCarts
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

        $UserCart = UserCart::create($request->all());
        return [
            "status" => 1,
            "data" => $UserCart
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserCart  $UserCart
     * @return \Illuminate\Http\Response
     */
    public function show(UserCart $UserCart)
    {
        return [
            "status" => 1,
            "data" =>$UserCart
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserCart  $UserCart
     * @return \Illuminate\Http\Response
     */
    public function edit(UserCart $UserCart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserCart  $UserCart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserCart $UserCart)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $UserCart->update($request->all());

        return [
            "status" => 1,
            "data" => $UserCart,
            "msg" => "UserCart updated successfully"
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserCart  $UserCart
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserCart $UserCart)
    {
        $UserCart->delete();
        return [
            "status" => 1,
            "data" => $UserCart,
            "msg" => "UserCart deleted successfully"
        ];
    }
}
