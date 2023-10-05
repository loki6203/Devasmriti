<?php

/**
 * Created by Reliese Controller.
 */

namespace App\Http\Controllers;

use App\Models\OrderSeva;
use Illuminate\Http\Request;

class OrderSevaController extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $OrderSevas = OrderSeva::latest()->paginate(10);
        return [
            "status" => 1,
            "data" => $OrderSevas
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

        $OrderSeva = OrderSeva::create($request->all());
        return [
            "status" => 1,
            "data" => $OrderSeva
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrderSeva  $OrderSeva
     * @return \Illuminate\Http\Response
     */
    public function show(OrderSeva $OrderSeva)
    {
        return [
            "status" => 1,
            "data" =>$OrderSeva
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OrderSeva  $OrderSeva
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderSeva $OrderSeva)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OrderSeva  $OrderSeva
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrderSeva $OrderSeva)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $OrderSeva->update($request->all());

        return [
            "status" => 1,
            "data" => $OrderSeva,
            "msg" => "OrderSeva updated successfully"
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrderSeva  $OrderSeva
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderSeva $OrderSeva)
    {
        $OrderSeva->delete();
        return [
            "status" => 1,
            "data" => $OrderSeva,
            "msg" => "OrderSeva deleted successfully"
        ];
    }
}
