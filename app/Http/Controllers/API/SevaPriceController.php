<?php

/**
 * Created by Reliese Controller.
 */

namespace App\Http\Controllers;

use App\Models\SevaPrice;
use Illuminate\Http\Request;

class SevaPriceController extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $SevaPrices = SevaPrice::latest()->paginate(10);
        return [
            "status" => 1,
            "data" => $SevaPrices
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

        $SevaPrice = SevaPrice::create($request->all());
        return [
            "status" => 1,
            "data" => $SevaPrice
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SevaPrice  $SevaPrice
     * @return \Illuminate\Http\Response
     */
    public function show(SevaPrice $SevaPrice)
    {
        return [
            "status" => 1,
            "data" =>$SevaPrice
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SevaPrice  $SevaPrice
     * @return \Illuminate\Http\Response
     */
    public function edit(SevaPrice $SevaPrice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SevaPrice  $SevaPrice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SevaPrice $SevaPrice)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $SevaPrice->update($request->all());

        return [
            "status" => 1,
            "data" => $SevaPrice,
            "msg" => "SevaPrice updated successfully"
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SevaPrice  $SevaPrice
     * @return \Illuminate\Http\Response
     */
    public function destroy(SevaPrice $SevaPrice)
    {
        $SevaPrice->delete();
        return [
            "status" => 1,
            "data" => $SevaPrice,
            "msg" => "SevaPrice deleted successfully"
        ];
    }
}
