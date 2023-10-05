<?php

/**
 * Created by Reliese Controller.
 */

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Settings = Setting::latest()->paginate(10);
        return [
            "status" => 1,
            "data" => $Settings
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

        $Setting = Setting::create($request->all());
        return [
            "status" => 1,
            "data" => $Setting
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Setting  $Setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $Setting)
    {
        return [
            "status" => 1,
            "data" =>$Setting
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Setting  $Setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $Setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Setting  $Setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $Setting)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $Setting->update($request->all());

        return [
            "status" => 1,
            "data" => $Setting,
            "msg" => "Setting updated successfully"
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Setting  $Setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $Setting)
    {
        $Setting->delete();
        return [
            "status" => 1,
            "data" => $Setting,
            "msg" => "Setting deleted successfully"
        ];
    }
}
