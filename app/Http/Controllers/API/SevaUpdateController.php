<?php

/**
 * Created by Reliese Controller.
 */

namespace App\Http\Controllers;

use App\Models\SevaUpdate;
use Illuminate\Http\Request;

class SevaUpdateController extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $SevaUpdates = SevaUpdate::latest()->paginate(10);
        return [
            "status" => 1,
            "data" => $SevaUpdates
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

        $SevaUpdate = SevaUpdate::create($request->all());
        return [
            "status" => 1,
            "data" => $SevaUpdate
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SevaUpdate  $SevaUpdate
     * @return \Illuminate\Http\Response
     */
    public function show(SevaUpdate $SevaUpdate)
    {
        return [
            "status" => 1,
            "data" =>$SevaUpdate
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SevaUpdate  $SevaUpdate
     * @return \Illuminate\Http\Response
     */
    public function edit(SevaUpdate $SevaUpdate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SevaUpdate  $SevaUpdate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SevaUpdate $SevaUpdate)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $SevaUpdate->update($request->all());

        return [
            "status" => 1,
            "data" => $SevaUpdate,
            "msg" => "SevaUpdate updated successfully"
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SevaUpdate  $SevaUpdate
     * @return \Illuminate\Http\Response
     */
    public function destroy(SevaUpdate $SevaUpdate)
    {
        $SevaUpdate->delete();
        return [
            "status" => 1,
            "data" => $SevaUpdate,
            "msg" => "SevaUpdate deleted successfully"
        ];
    }
}
