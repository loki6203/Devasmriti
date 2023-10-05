<?php

/**
 * Created by Reliese Controller.
 */

namespace App\Http\Controllers;

use App\Models\SevaType;
use Illuminate\Http\Request;

class SevaTypeController extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $SevaTypes = SevaType::latest()->paginate(10);
        return [
            "status" => 1,
            "data" => $SevaTypes
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

        $SevaType = SevaType::create($request->all());
        return [
            "status" => 1,
            "data" => $SevaType
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SevaType  $SevaType
     * @return \Illuminate\Http\Response
     */
    public function show(SevaType $SevaType)
    {
        return [
            "status" => 1,
            "data" =>$SevaType
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SevaType  $SevaType
     * @return \Illuminate\Http\Response
     */
    public function edit(SevaType $SevaType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SevaType  $SevaType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SevaType $SevaType)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $SevaType->update($request->all());

        return [
            "status" => 1,
            "data" => $SevaType,
            "msg" => "SevaType updated successfully"
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SevaType  $SevaType
     * @return \Illuminate\Http\Response
     */
    public function destroy(SevaType $SevaType)
    {
        $SevaType->delete();
        return [
            "status" => 1,
            "data" => $SevaType,
            "msg" => "SevaType deleted successfully"
        ];
    }
}
