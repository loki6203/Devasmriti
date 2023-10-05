<?php

/**
 * Created by Reliese Controller.
 */

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Events = Event::latest()->paginate(10);
        return [
            "status" => 1,
            "data" => $Events
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

        $Event = Event::create($request->all());
        return [
            "status" => 1,
            "data" => $Event
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $Event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $Event)
    {
        return [
            "status" => 1,
            "data" =>$Event
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $Event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $Event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $Event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $Event)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $Event->update($request->all());

        return [
            "status" => 1,
            "data" => $Event,
            "msg" => "Event updated successfully"
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $Event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $Event)
    {
        $Event->delete();
        return [
            "status" => 1,
            "data" => $Event,
            "msg" => "Event deleted successfully"
        ];
    }
}
