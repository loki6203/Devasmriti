<?php

/**
 * Created by Reliese Controller.
 */

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Orders = Order::latest()->paginate(10);
        return [
            "status" => 1,
            "data" => $Orders
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

        $Order = Order::create($request->all());
        return [
            "status" => 1,
            "data" => $Order
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $Order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $Order)
    {
        return [
            "status" => 1,
            "data" =>$Order
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $Order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $Order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $Order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $Order)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $Order->update($request->all());

        return [
            "status" => 1,
            "data" => $Order,
            "msg" => "Order updated successfully"
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $Order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $Order)
    {
        $Order->delete();
        return [
            "status" => 1,
            "data" => $Order,
            "msg" => "Order deleted successfully"
        ];
    }
}
