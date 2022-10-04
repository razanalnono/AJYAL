<?php

namespace App\Http\Controllers\API;

use App\Models\page;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return page::select('bio','vision','goals','logo')->get();
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
            'logo'=>'image',
        ]);
        $logoName=Str::random().'.'.$request->logo->getClientOriginalExtension();
        Storage::disk('public')->putFileAs('logo/image',$request->logo,$logoName);
        page::create($request->post()+['logo'=>$logoName]);
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
    public function update(Request $request, page $page)
    {
        //
        $request->validate([
            'bio' => 'required',
            'vision' => 'required',
            'goals' => 'required',
            'logo' => 'nullable',
        ]);

$page->fill($request->post())->update();
if($request->hasFile('logo')){
if($page->logo)
{
    $isExist = Storage::disk('public')->exists('logo/image'.$page->logo);
    if($isExist){
                Storage::disk('public')->delete('logo/image' . $page->logo);
    }
}        
        $logoName = Str::random() . '.' . $request->logo->getClientOriginalExtension();
        Storage::disk('public')->putFileAs('logo/image', $request->logo, $logoName);
    $page->logo=$logoName;
    $page->save();
}
        return response()->json([
            'message' => 'Added Successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(page $page)
    {

        if ($page->logo) {
            $isExist = Storage::disk('public')->exists('logo/image' . $page->logo);
            if ($isExist) {
                Storage::disk('public')->delete('logo/image'.$page->logo);
            }
        } 
        $page->delete();
        return response()->json([
            'message'=>'Deleted Successfully'
        ]);
    }
    
}