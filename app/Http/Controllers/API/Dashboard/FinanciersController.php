<?php

namespace App\Http\Controllers\API\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Financier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FinanciersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $platform = Financier::with('projects')->get();
        
        return $platform;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(Financier::rules());

        $data = $request->except('logo');
        $data['logo'] = $this->uploadlogo($request);
        $Financier = Financier::create( $data );

        return response()->json([
            'message' => 'Financier added successfully'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Financier $financier)
    {
        return $financier->get();
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
        $request->validate(Financier::rules());
        
        $financier = Financier::findOrFail($id);
        $old_logo = $financier->logo;
        $data = $request->except('logo');
        $new_logo = $this->uploadlogo($request);
        if ($new_logo) {
            $data['logo'] = $new_logo;
        }
        $financier->update($data);
        if ($old_logo && $new_logo) {
            Storage::disk('public')->delete($old_logo);
        }

        return response()->json([
            'message' => 'Financier updated successfully'
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
        $financier = Financier::findOrFail($id);
        $financier->delete();
        if ($financier->logo) {
                Storage::disk('public')->delete($financier->logo);
        }
    }

    protected function uploadlogo(Request $request) {
        if (!$request->hasFile('logo')) {
            return;
        }
        $file = $request->file('logo');
        $path = $file->store('uploads', [
            'disk' => 'public'
        ]);
        return $path;
    }
}
