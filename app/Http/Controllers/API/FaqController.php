<?php

/**
 * Created by Reliese Controller.
 */

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Faqs = Faq::latest()->paginate(10);
        return [
            "status" => 1,
            "data" => $Faqs
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

        $Faq = Faq::create($request->all());
        return [
            "status" => 1,
            "data" => $Faq
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Faq  $Faq
     * @return \Illuminate\Http\Response
     */
    public function show(Faq $Faq)
    {
        return [
            "status" => 1,
            "data" =>$Faq
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Faq  $Faq
     * @return \Illuminate\Http\Response
     */
    public function edit(Faq $Faq)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Faq  $Faq
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Faq $Faq)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $Faq->update($request->all());

        return [
            "status" => 1,
            "data" => $Faq,
            "msg" => "Faq updated successfully"
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Faq  $Faq
     * @return \Illuminate\Http\Response
     */
    public function destroy(Faq $Faq)
    {
        $Faq->delete();
        return [
            "status" => 1,
            "data" => $Faq,
            "msg" => "Faq deleted successfully"
        ];
    }
}
