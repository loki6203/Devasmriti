<?php

/**
 * Created by Reliese Controller.
 */

namespace App\Http\Controllers;

use App\Models\Temple;
use Illuminate\Http\Request;

class TempleController extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Temples = Temple::latest()->paginate(10);
        return [
            "status" => 1,
            "data" => $Temples
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

        $Temple = Temple::create($request->all());
        return [
            "status" => 1,
            "data" => $Temple
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Temple  $Temple
     * @return \Illuminate\Http\Response
     */
    public function show(Temple $Temple)
    {
        return [
            "status" => 1,
            "data" =>$Temple
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Temple  $Temple
     * @return \Illuminate\Http\Response
     */
    public function edit(Temple $Temple)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Temple  $Temple
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Temple $Temple)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $Temple->update($request->all());

        return [
            "status" => 1,
            "data" => $Temple,
            "msg" => "Temple updated successfully"
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Temple  $Temple
     * @return \Illuminate\Http\Response
     */
    public function destroy(Temple $Temple)
    {
        $Temple->delete();
        return [
            "status" => 1,
            "data" => $Temple,
            "msg" => "Temple deleted successfully"
        ];
    }
}
