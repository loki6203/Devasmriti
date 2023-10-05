<?php

/**
 * Created by Reliese Controller.
 */

namespace App\Http\Controllers;

use App\Models\EventFaq;
use Illuminate\Http\Request;

class EventFaqController extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $EventFaqs = EventFaq::latest()->paginate(10);
        return [
            "status" => 1,
            "data" => $EventFaqs
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

        $EventFaq = EventFaq::create($request->all());
        return [
            "status" => 1,
            "data" => $EventFaq
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EventFaq  $EventFaq
     * @return \Illuminate\Http\Response
     */
    public function show(EventFaq $EventFaq)
    {
        return [
            "status" => 1,
            "data" =>$EventFaq
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EventFaq  $EventFaq
     * @return \Illuminate\Http\Response
     */
    public function edit(EventFaq $EventFaq)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EventFaq  $EventFaq
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EventFaq $EventFaq)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $EventFaq->update($request->all());

        return [
            "status" => 1,
            "data" => $EventFaq,
            "msg" => "EventFaq updated successfully"
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EventFaq  $EventFaq
     * @return \Illuminate\Http\Response
     */
    public function destroy(EventFaq $EventFaq)
    {
        $EventFaq->delete();
        return [
            "status" => 1,
            "data" => $EventFaq,
            "msg" => "EventFaq deleted successfully"
        ];
    }
}
