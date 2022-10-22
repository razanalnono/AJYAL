<?php

namespace App\Http\Controllers\API\Dashboard;

use App\Models\Trainee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TraineeController extends Controller
{
    //
    public function index()
    {
        //
        $trainees = Trainee::with('groups')->paginate();
        return $trainees;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(Trainee::rules());
        $request->merge([
            'password' => Hash::make($request->password)
        ]);
        $data = $request->except('avatar');
        $data['avatar'] = $this->uploadImage($request);
        $trainee =Trainee::create($data);
        foreach ($request->groups as $groups) {
            DB::table('group_trainee')->insert([
                'trainee_id' => $trainee->id,
                'group_id' => $groups
            ]);
        }
        return response()->json([
            'message' => 'trainee Created'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Trainee $trainee)
    {
        return $trainee->load('groups');
        
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
        $request->validate(Trainee::rules($id));
        $request->merge([
            'password' => Hash::make($request->password)
        ]);
        $trainee = Trainee::findOrFail($id);
        $old_image = $trainee->avatar;
        $data = $request->except('avatar');
        $new_image = $this->uploadImage($request);
        if ($new_image) {
            $data['avatar'] = $new_image;
        }
        $trainee->update($data);
        DB::table('group_trainee')->where('trainee_id', $trainee->id)->delete();
        foreach ($request->groups as $groupe) {
            DB::table('group_trainee')->insert([
                'trainee_id' => $trainee->id,
                'group_id' => $groupe
            ]);
        }
        if ($old_image && $new_image) {
            Storage::disk('public')->delete($old_image);
        }
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
    public function destroy($id)
    {
        //
        $trainee = Trainee::findOrFail($id);
        $trainee->delete();
        if ($trainee->avatar) {
                Storage::disk('public')->delete($trainee->avatar);
        }
        return [
            'message' => 'Deleted Successfully.',
        ];
    }


    protected function uploadImage(Request $request)
    {
        if (!$request->hasFile('avatar')) {
            return;
        }

        $file = $request->file('avatar'); // UploadedFile Object

        $path = $file->store('uploads', [
            'disk' => 'public'
        ]);
        return $path;
    }
}