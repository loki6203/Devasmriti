<?php

/**
 * Created by Reliese Controller.
 */

namespace App\Http\Controllers;

use App\Models\Seva;
use Illuminate\Http\Request;

class SevaController extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Sevas = Seva::latest()->paginate(10);
        return [
            "status" => 1,
            "data" => $Sevas
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

        $Seva = Seva::create($request->all());
        return [
            "status" => 1,
            "data" => $Seva
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Seva  $Seva
     * @return \Illuminate\Http\Response
     */
    public function show(Seva $Seva)
    {
        return [
            "status" => 1,
            "data" =>$Seva
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Seva  $Seva
     * @return \Illuminate\Http\Response
     */
    public function edit(Seva $Seva)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Seva  $Seva
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Seva $Seva)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $Seva->update($request->all());

        return [
            "status" => 1,
            "data" => $Seva,
            "msg" => "Seva updated successfully"
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Seva  $Seva
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seva $Seva)
    {
        $Seva->delete();
        return [
            "status" => 1,
            "data" => $Seva,
            "msg" => "Seva deleted successfully"
        ];
    }
}
