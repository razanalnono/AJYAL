<?php

namespace App\Http\Controllers\API\Dashboard;

use App\Models\Trainer;
use Nette\Utils\Random;
use App\Mail\ActivationCode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class TrainerController extends Controller
{
    //
    public function index()
    {
        //
        return Trainer::select('firstName', 'lastName', 'gender', 'avatar', 'email')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Trainer $trainer)
    {
        //

        $email = $request->email;
        $trainer = Trainer::where('email', $email)->first();

        $password = Random::generate('5');

        // $hashed = Hash::make($password);
        // $trainee->password = $hashed;


        $data = $request->except('avatar');
        $data['password'] = Hash::make($password);

        $data['avatar'] = $this->uploadImage($request);

        $trainer = Trainer::create($data);
        Mail::to($trainer->email)->send(new ActivationCode($password));

        return response()->json([
            'message' => 'Trainer Created'
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
    public function update(Request $request, Trainer $trainer)
    {
        //
        $old_image = $trainer->avatar;
        $data = $request->except('avatar');
        $new_image = $this->uploadImage($request);
        if ($new_image) {
            $data['avatar'] = $new_image;
        }

        $trainer->update($data);

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
    public function destroy(Trainer $trainer)
    {
        //
        $trainer->delete();
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