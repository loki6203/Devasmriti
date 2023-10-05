<?php

/**
 * Created by Reliese Controller.
 */

namespace App\Http\Controllers;

use App\Models\SevaCoupon;
use Illuminate\Http\Request;

class SevaCouponController extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $SevaCoupons = SevaCoupon::latest()->paginate(10);
        return [
            "status" => 1,
            "data" => $SevaCoupons
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

        $SevaCoupon = SevaCoupon::create($request->all());
        return [
            "status" => 1,
            "data" => $SevaCoupon
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SevaCoupon  $SevaCoupon
     * @return \Illuminate\Http\Response
     */
    public function show(SevaCoupon $SevaCoupon)
    {
        return [
            "status" => 1,
            "data" =>$SevaCoupon
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SevaCoupon  $SevaCoupon
     * @return \Illuminate\Http\Response
     */
    public function edit(SevaCoupon $SevaCoupon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SevaCoupon  $SevaCoupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SevaCoupon $SevaCoupon)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $SevaCoupon->update($request->all());

        return [
            "status" => 1,
            "data" => $SevaCoupon,
            "msg" => "SevaCoupon updated successfully"
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SevaCoupon  $SevaCoupon
     * @return \Illuminate\Http\Response
     */
    public function destroy(SevaCoupon $SevaCoupon)
    {
        $SevaCoupon->delete();
        return [
            "status" => 1,
            "data" => $SevaCoupon,
            "msg" => "SevaCoupon deleted successfully"
        ];
    }
}
