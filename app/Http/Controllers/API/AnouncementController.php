<?php

/**
 * Created by Reliese Controller.
 */

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller; 
use App\Models\Anouncement;
use Illuminate\Http\Request;

class AnouncementController extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Anouncements = Anouncement::latest()->paginate(10);
        return [
            "status" => 1,
            "data" => $Anouncements
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

        $Anouncement = Anouncement::create($request->all());
        return [
            "status" => 1,
            "data" => $Anouncement
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Anouncement  $Anouncement
     * @return \Illuminate\Http\Response
     */
    public function show(Anouncement $Anouncement)
    {
        return [
            "status" => 1,
            "data" =>$Anouncement
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Anouncement  $Anouncement
     * @return \Illuminate\Http\Response
     */
    public function edit(Anouncement $Anouncement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Anouncement  $Anouncement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Anouncement $Anouncement)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $Anouncement->update($request->all());

        return [
            "status" => 1,
            "data" => $Anouncement,
            "msg" => "Anouncement updated successfully"
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Anouncement  $Anouncement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Anouncement $Anouncement)
    {
        $Anouncement->delete();
        return [
            "status" => 1,
            "data" => $Anouncement,
            "msg" => "Anouncement deleted successfully"
        ];
    }
}
