<?php

/**
 * Created by Reliese Controller.
 */

namespace App\Http\Controllers;

use App\Models\EventUpdate;
use Illuminate\Http\Request;

class EventUpdateController extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $EventUpdates = EventUpdate::latest()->paginate(10);
        return [
            "status" => 1,
            "data" => $EventUpdates
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

        $EventUpdate = EventUpdate::create($request->all());
        return [
            "status" => 1,
            "data" => $EventUpdate
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EventUpdate  $EventUpdate
     * @return \Illuminate\Http\Response
     */
    public function show(EventUpdate $EventUpdate)
    {
        return [
            "status" => 1,
            "data" =>$EventUpdate
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EventUpdate  $EventUpdate
     * @return \Illuminate\Http\Response
     */
    public function edit(EventUpdate $EventUpdate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EventUpdate  $EventUpdate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EventUpdate $EventUpdate)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $EventUpdate->update($request->all());

        return [
            "status" => 1,
            "data" => $EventUpdate,
            "msg" => "EventUpdate updated successfully"
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EventUpdate  $EventUpdate
     * @return \Illuminate\Http\Response
     */
    public function destroy(EventUpdate $EventUpdate)
    {
        $EventUpdate->delete();
        return [
            "status" => 1,
            "data" => $EventUpdate,
            "msg" => "EventUpdate deleted successfully"
        ];
    }
}
