<?php

/**
 * Created by Reliese Controller.
 */

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Testimonials = Testimonial::latest()->paginate(10);
        return [
            "status" => 1,
            "data" => $Testimonials
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

        $Testimonial = Testimonial::create($request->all());
        return [
            "status" => 1,
            "data" => $Testimonial
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Testimonial  $Testimonial
     * @return \Illuminate\Http\Response
     */
    public function show(Testimonial $Testimonial)
    {
        return [
            "status" => 1,
            "data" =>$Testimonial
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Testimonial  $Testimonial
     * @return \Illuminate\Http\Response
     */
    public function edit(Testimonial $Testimonial)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Testimonial  $Testimonial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Testimonial $Testimonial)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $Testimonial->update($request->all());

        return [
            "status" => 1,
            "data" => $Testimonial,
            "msg" => "Testimonial updated successfully"
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Testimonial  $Testimonial
     * @return \Illuminate\Http\Response
     */
    public function destroy(Testimonial $Testimonial)
    {
        $Testimonial->delete();
        return [
            "status" => 1,
            "data" => $Testimonial,
            "msg" => "Testimonial deleted successfully"
        ];
    }
}
