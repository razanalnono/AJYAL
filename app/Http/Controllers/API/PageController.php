<?php

namespace App\Http\Controllers\API;

use App\Models\Page;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Faker\Provider\Lorem;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth:sanctum')->except('index');
    // }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Page::select('bio','vision','goals','logo')->get();
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
            'bio'=>'required',
            'vision'=>'required',
            'goals'=>'required',
            'logo'=>'nullable|image',
        ]);
        // $logoName=Str::random().'.'.$request->logo->getClientOriginalExtension();
        // Storage::disk('public')->putFileAs('logo/image',$request->logo,$logoName);
        Page::create($request->post());
        return response()->json([
            'message'=>'Added Successfully'
        ]);
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
    public function update(Request $request, Page $page)
    {
        //
        $request->validate([
            'bio' => 'sometimes|required',
            'vision' => 'sometimes|required',
            'goals' => 'sometimes|required',
            'logo' => 'sometimes|nullable',
        ]);


// $page->fill($request->post())->update();
// if($request->hasFile('logo')){
// if($page->logo)
// {
//     $isExist = Storage::disk('public')->exists('logo/image'.$page->logo);
//     if($isExist){
//                 Storage::disk('public')->delete('logo/image' . $page->logo);
//     }
// }        
//         $logoName = Str::random() . '.' . $request->logo->getClientOriginalExtension();
//         Storage::disk('public')->putFileAs('logo/image', $request->logo, $logoName);
//     $page->logo=$logoName;
//     $page->save();
// }
// $page->save();

$page->update($request->all());


        return response()->json([
            'message' => 'Updated Successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {

        // if ($page->logo) {
        //     $isExist = Storage::disk('public')->exists('logo/image' . $page->logo);
        //     if ($isExist) {
        //         Storage::disk('public')->delete('logo/image'.$page->logo);
        //     }
        // } 
        $page->delete();
        return response()->json([
            'message'=>'Deleted Successfully'
        ]);
    }
    
}