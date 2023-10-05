<?php

/**
 * Created by Reliese Controller.
 */

namespace App\Http\Controllers;

use App\Models\SevaFaq;
use Illuminate\Http\Request;

class SevaFaqController extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $SevaFaqs = SevaFaq::latest()->paginate(10);
        return [
            "status" => 1,
            "data" => $SevaFaqs
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

        $SevaFaq = SevaFaq::create($request->all());
        return [
            "status" => 1,
            "data" => $SevaFaq
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SevaFaq  $SevaFaq
     * @return \Illuminate\Http\Response
     */
    public function show(SevaFaq $SevaFaq)
    {
        return [
            "status" => 1,
            "data" =>$SevaFaq
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SevaFaq  $SevaFaq
     * @return \Illuminate\Http\Response
     */
    public function edit(SevaFaq $SevaFaq)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SevaFaq  $SevaFaq
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SevaFaq $SevaFaq)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $SevaFaq->update($request->all());

        return [
            "status" => 1,
            "data" => $SevaFaq,
            "msg" => "SevaFaq updated successfully"
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SevaFaq  $SevaFaq
     * @return \Illuminate\Http\Response
     */
    public function destroy(SevaFaq $SevaFaq)
    {
        $SevaFaq->delete();
        return [
            "status" => 1,
            "data" => $SevaFaq,
            "msg" => "SevaFaq deleted successfully"
        ];
    }
}
