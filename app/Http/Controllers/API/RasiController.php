<?php

/**
 * Created by Reliese Controller.
 */

namespace App\Http\Controllers;

use App\Models\Rasi;
use Illuminate\Http\Request;

class RasiController extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Rasis = Rasi::latest()->paginate(10);
        return [
            "status" => 1,
            "data" => $Rasis
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

        $Rasi = Rasi::create($request->all());
        return [
            "status" => 1,
            "data" => $Rasi
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rasi  $Rasi
     * @return \Illuminate\Http\Response
     */
    public function show(Rasi $Rasi)
    {
        return [
            "status" => 1,
            "data" =>$Rasi
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rasi  $Rasi
     * @return \Illuminate\Http\Response
     */
    public function edit(Rasi $Rasi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rasi  $Rasi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rasi $Rasi)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $Rasi->update($request->all());

        return [
            "status" => 1,
            "data" => $Rasi,
            "msg" => "Rasi updated successfully"
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rasi  $Rasi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rasi $Rasi)
    {
        $Rasi->delete();
        return [
            "status" => 1,
            "data" => $Rasi,
            "msg" => "Rasi deleted successfully"
        ];
    }
}
