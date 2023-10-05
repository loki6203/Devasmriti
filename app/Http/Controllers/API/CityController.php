<?php

/**
 * Created by Reliese Controller.
 */

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller; 
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Citys = City::latest()->paginate(10);
        return [
            "status" => 1,
            "data" => $Citys
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

        $City = City::create($request->all());
        return [
            "status" => 1,
            "data" => $City
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\City  $City
     * @return \Illuminate\Http\Response
     */
    public function show(City $City)
    {
        return [
            "status" => 1,
            "data" =>$City
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\City  $City
     * @return \Illuminate\Http\Response
     */
    public function edit(City $City)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\City  $City
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, City $City)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $City->update($request->all());

        return [
            "status" => 1,
            "data" => $City,
            "msg" => "City updated successfully"
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\City  $City
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $City)
    {
        $City->delete();
        return [
            "status" => 1,
            "data" => $City,
            "msg" => "City deleted successfully"
        ];
    }
}
