<?php

/**
 * Created by Reliese Controller.
 */

namespace App\Http\Controllers;

use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $States = State::latest()->paginate(10);
        return [
            "status" => 1,
            "data" => $States
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

        $State = State::create($request->all());
        return [
            "status" => 1,
            "data" => $State
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\State  $State
     * @return \Illuminate\Http\Response
     */
    public function show(State $State)
    {
        return [
            "status" => 1,
            "data" =>$State
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\State  $State
     * @return \Illuminate\Http\Response
     */
    public function edit(State $State)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\State  $State
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, State $State)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $State->update($request->all());

        return [
            "status" => 1,
            "data" => $State,
            "msg" => "State updated successfully"
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\State  $State
     * @return \Illuminate\Http\Response
     */
    public function destroy(State $State)
    {
        $State->delete();
        return [
            "status" => 1,
            "data" => $State,
            "msg" => "State deleted successfully"
        ];
    }
}
