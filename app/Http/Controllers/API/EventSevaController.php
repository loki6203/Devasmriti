<?php

/**
 * Created by Reliese Controller.
 */

namespace App\Http\Controllers;

use App\Models\EventSeva;
use Illuminate\Http\Request;

class EventSevaController extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $EventSevas = EventSeva::latest()->paginate(10);
        return [
            "status" => 1,
            "data" => $EventSevas
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

        $EventSeva = EventSeva::create($request->all());
        return [
            "status" => 1,
            "data" => $EventSeva
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EventSeva  $EventSeva
     * @return \Illuminate\Http\Response
     */
    public function show(EventSeva $EventSeva)
    {
        return [
            "status" => 1,
            "data" =>$EventSeva
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EventSeva  $EventSeva
     * @return \Illuminate\Http\Response
     */
    public function edit(EventSeva $EventSeva)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EventSeva  $EventSeva
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EventSeva $EventSeva)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $EventSeva->update($request->all());

        return [
            "status" => 1,
            "data" => $EventSeva,
            "msg" => "EventSeva updated successfully"
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EventSeva  $EventSeva
     * @return \Illuminate\Http\Response
     */
    public function destroy(EventSeva $EventSeva)
    {
        $EventSeva->delete();
        return [
            "status" => 1,
            "data" => $EventSeva,
            "msg" => "EventSeva deleted successfully"
        ];
    }
}
