<?php

/**
 * Created by Reliese Controller.
 */

namespace App\Http\Controllers;

use App\Models\UserFamilyDetail;
use Illuminate\Http\Request;

class UserFamilyDetailController extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $UserFamilyDetails = UserFamilyDetail::latest()->paginate(10);
        return [
            "status" => 1,
            "data" => $UserFamilyDetails
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

        $UserFamilyDetail = UserFamilyDetail::create($request->all());
        return [
            "status" => 1,
            "data" => $UserFamilyDetail
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserFamilyDetail  $UserFamilyDetail
     * @return \Illuminate\Http\Response
     */
    public function show(UserFamilyDetail $UserFamilyDetail)
    {
        return [
            "status" => 1,
            "data" =>$UserFamilyDetail
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserFamilyDetail  $UserFamilyDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(UserFamilyDetail $UserFamilyDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserFamilyDetail  $UserFamilyDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserFamilyDetail $UserFamilyDetail)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $UserFamilyDetail->update($request->all());

        return [
            "status" => 1,
            "data" => $UserFamilyDetail,
            "msg" => "UserFamilyDetail updated successfully"
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserFamilyDetail  $UserFamilyDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserFamilyDetail $UserFamilyDetail)
    {
        $UserFamilyDetail->delete();
        return [
            "status" => 1,
            "data" => $UserFamilyDetail,
            "msg" => "UserFamilyDetail deleted successfully"
        ];
    }
}
