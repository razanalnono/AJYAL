<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Images;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return News::with('images')->select('title', 'description', 'in_slider')->where('in_slider', 1)->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, News $news)
    {
        //
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $data =  $request->except('images');
        $news = News::create($data);

        foreach ($request->images as $image) {
            $data = [];
            $data['images'] = $this->uploadImage($image);

            $data['reference_id'] = $news->id;
            $data['reference_type'] = $news->getMorphClass();

            Images::create($data);
        }


        return response()->json([
            'message' => 'News Added Successfully'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(News $news)
    {
        //
        return $news->load('title');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, News $news)
    {
        //
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'in_slider' => 'in:0,1'
        ]);


        $data =  $request->except('images');
        $news->update($data);

        $old_image = $news->images;
        $data = $request->except('images');
        // $new_image = $this->uploadImage($request);

        foreach ($news->images as $img) {
            $img->delete();
        }

        foreach ($request->images as $image) {
            $data = [];
            $data['images'] = $this->uploadImage($image);

            $data['reference_id'] = $news->id;
            $data['reference_type'] = $news->getMorphClass();

            Images::create($data);
        }

        // if ($new_image) {
        //     $data = [];
        //     $data['images'] = $new_image;

        //     $data['reference_id'] = $news->id;
        //     $data['reference_type'] = $news->getMorphClass();

        //     if ($old_image && $new_image) {
        //         Storage::disk('public')->delete($old_image);
        //     }

        //     Images::create($data);
        // }


        return response()->json([
            'message' => 'Updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(News $news)
    {
        //
        $news->delete();
        return response()->json([
            'message' => 'News Deleted Successfully'
        ]);
    }

    protected function uploadImage($file)
    {

        $path = $file->store('uploads', [
            'disk' => 'public'
        ]);
        return $path;
    }


    // protected function uploadImage(Request $request)
    // {
    //     if (!$request->hasFile('images')) {
    //         return;
    //     }

    //     $file = $request->file('images'); // UploadedFile Object

    //     $path = $file->store('uploads', [
    //         'disk' => 'public'
    //     ]);
    //     return $path;
    // }
}