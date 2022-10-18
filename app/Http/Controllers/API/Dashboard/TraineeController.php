<?php

namespace App\Http\Controllers\API\Dashboard;

use App\Models\Trainee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\ActivationCode;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Nette\Utils\Random;

class TraineeController extends Controller
{
    //
    public function index()
    {
        //
        return Trainee::select('firstName', 'lastName', 'gender', 'avatar', 'email')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Trainee $trainee)
    {
        //
        $request->validate([
            'email' => 'required',
            'firstName' => 'required',
            'lastName' => 'required',
            'gender' => ''
        ]);

        $email = $request->email;
        $trainee = Trainee::where('email', $email)->first();

        $password = Random::generate('5');

        // $hashed = Hash::make($password);
        // $trainee->password = $hashed;


        $data = $request->except('avatar');
        $data['password'] = Hash::make($password);

        $data['avatar'] = $this->uploadImage($request);

        $trainee = Trainee::create($data);
        Mail::to($trainee->email)->send(new ActivationCode($password));

        return response()->json([
            'message' => 'Trainee Created'
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
    public function update(Request $request, Trainee $trainee)
    {
        //
        $old_image = $trainee->avatar;
        $data = $request->except('avatar');
        $new_image = $this->uploadImage($request);
        if ($new_image) {
            $data['avatar'] = $new_image;
        }

        $trainee->update($data);

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
    public function destroy(Trainee $trainee)
    {
        //
        $trainee->delete();
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