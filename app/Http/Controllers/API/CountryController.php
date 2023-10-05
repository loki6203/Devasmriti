<?php

/**
 * Created by Reliese Controller.
 */

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Countrys = Country::latest()->paginate(10);
        return [
            "status" => 1,
            "data" => $Countrys
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

        $Country = Country::create($request->all());
        return [
            "status" => 1,
            "data" => $Country
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Country  $Country
     * @return \Illuminate\Http\Response
     */
    public function show(Country $Country)
    {
        return [
            "status" => 1,
            "data" =>$Country
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Country  $Country
     * @return \Illuminate\Http\Response
     */
    public function edit(Country $Country)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Country  $Country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $Country)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $Country->update($request->all());

        return [
            "status" => 1,
            "data" => $Country,
            "msg" => "Country updated successfully"
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Country  $Country
     * @return \Illuminate\Http\Response
     */
    public function destroy(Country $Country)
    {
        $Country->delete();
        return [
            "status" => 1,
            "data" => $Country,
            "msg" => "Country deleted successfully"
        ];
    }
}
