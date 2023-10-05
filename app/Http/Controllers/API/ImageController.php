<?php

/**
 * Created by Reliese Controller.
 */

namespace App\Http\Controllers;
use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Images = Image::latest()->paginate(10);
        return [
            "status" => 1,
            "data" => $Images
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

        $Image = Image::create($request->all());
        return [
            "status" => 1,
            "data" => $Image
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Image  $Image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $Image)
    {
        return [
            "status" => 1,
            "data" =>$Image
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Image  $Image
     * @return \Illuminate\Http\Response
     */
    public function edit(Image $Image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Image  $Image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $Image)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $Image->update($request->all());

        return [
            "status" => 1,
            "data" => $Image,
            "msg" => "Image updated successfully"
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Image  $Image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $Image)
    {
        $Image->delete();
        return [
            "status" => 1,
            "data" => $Image,
            "msg" => "Image deleted successfully"
        ];
    }
}
