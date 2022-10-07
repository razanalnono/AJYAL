<?php

namespace App\Http\Controllers\API\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    //
    public function index(){
        return Admin::select('firstName','lastName','gender','avatar','email');
    }

    public function store(Request $request){
$data=$request->except('avatar');
$data['avatar']=$this->uploadImage($request);
        
        Admin::create($request->post());
        return Response::json([
            'message'=>'Admin Created'
        ]);
        
    }

    public function show($id){
    }
    
    public function update(Request $request,Admin $admin){
        $old_image=$admin->avatar;
        $data = $request->except('avatar');
        $new_image=$this->uploadImage($request);
        if($new_image){
            $data['avatar']=$new_image;
        }
        
        $admin->update($data);
        
        if($old_image && $new_image){
            Storage::disk('public')->delete($old_image);
        }
        
        return response()->json([
            'message' => 'Updated Successfully'
        ]);
    }


    public function destroy(Admin $admin){

        $admin->delete();
        return response()->json([
            'message' => 'Deleted Successfully'
        ]);
    }



    protected function uploadImage(Request $request)
    {
        if (!$request->hasFile('image')) {
            return;
        }

        $file = $request->file('image'); // UploadedFile Object

        $path = $file->store('uploads', [
            'disk' => 'public'
        ]);
        return $path;
    }
}