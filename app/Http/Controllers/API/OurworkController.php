<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ourwork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class OurworkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $work = ourwork::all();
        return $work;
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
            'report' => ['required'],
            'images' => ['required', 'image', 'max:1048576', 'dimensions:min_width=100,min_height=100'],
        ]);

        $data = $request->except('images');
        $data['images'] = $this->uploadImage($request);
        $ourwork = ourwork::create( $data );
        return Response::json($data['images'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    protected function uploadImage(Request $request) {
        if (!$request->hasFile('image')) {
            return;
        }
        // $file = $request->file('image');
        // $path = $file->store('uploads', [
        //     'disk' => 'public'
        // ]);
        // return $path;

        $path = [];
        foreach($request->file('images') as $image)
        {
            $file = $request->file('image');
            $path[] = $file->store('uploads', [
                'disk' => 'public'
            ]);
            return $path;
        }
        return $path;
    }
}
