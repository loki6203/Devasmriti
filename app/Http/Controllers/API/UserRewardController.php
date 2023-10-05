<?php

/**
 * Created by Reliese Controller.
 */

namespace App\Http\Controllers;

use App\Models\UserReward;
use Illuminate\Http\Request;

class UserRewardController extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $UserRewards = UserReward::latest()->paginate(10);
        return [
            "status" => 1,
            "data" => $UserRewards
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

        $UserReward = UserReward::create($request->all());
        return [
            "status" => 1,
            "data" => $UserReward
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserReward  $UserReward
     * @return \Illuminate\Http\Response
     */
    public function show(UserReward $UserReward)
    {
        return [
            "status" => 1,
            "data" =>$UserReward
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserReward  $UserReward
     * @return \Illuminate\Http\Response
     */
    public function edit(UserReward $UserReward)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserReward  $UserReward
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserReward $UserReward)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $UserReward->update($request->all());

        return [
            "status" => 1,
            "data" => $UserReward,
            "msg" => "UserReward updated successfully"
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserReward  $UserReward
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserReward $UserReward)
    {
        $UserReward->delete();
        return [
            "status" => 1,
            "data" => $UserReward,
            "msg" => "UserReward deleted successfully"
        ];
    }
}
