<?php

/**
 * Created by Reliese Controller.
 */

namespace App\Http\Controllers;

use App\Models\Relation;
use Illuminate\Http\Request;

class RelationController extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Relations = Relation::latest()->paginate(10);
        return [
            "status" => 1,
            "data" => $Relations
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

        $Relation = Relation::create($request->all());
        return [
            "status" => 1,
            "data" => $Relation
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Relation  $Relation
     * @return \Illuminate\Http\Response
     */
    public function show(Relation $Relation)
    {
        return [
            "status" => 1,
            "data" =>$Relation
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Relation  $Relation
     * @return \Illuminate\Http\Response
     */
    public function edit(Relation $Relation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Relation  $Relation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Relation $Relation)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $Relation->update($request->all());

        return [
            "status" => 1,
            "data" => $Relation,
            "msg" => "Relation updated successfully"
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Relation  $Relation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Relation $Relation)
    {
        $Relation->delete();
        return [
            "status" => 1,
            "data" => $Relation,
            "msg" => "Relation deleted successfully"
        ];
    }
}
