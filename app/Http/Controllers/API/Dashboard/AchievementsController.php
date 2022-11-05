<?php

namespace App\Http\Controllers\API\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AchievementsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $achievements = Achievement::with('trainee:id,firstName,lastName', 'group:id,name')
            ->paginate();

        return $achievements;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(Achievement::rules());

        $data = $request->except('attachment');
        $data['attachment'] = $this->uploadAttachment($request);
        $achievement = Achievement::create($data);

        return response()->json([
            'message' => 'Achievement added successfully'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Achievement $achievement)
    {
        return $achievement->load('trainee:id,firstName,lastName', 'group:id,name');
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
        $request->validate(Achievement::rules());

        $achievement = Achievement::findOrFail($id);
        $old_attachment = $achievement->attachment;
        $data = $request->except('attachment');
        $new_attachment = $this->uploadAttachment($request);
        if ($new_attachment) {
            $data['attachment'] = $new_attachment;
        }
        $achievement->update($data);
        if ($old_attachment && $new_attachment) {
            Storage::disk('public')->delete($old_attachment);
        }

        return response()->json([
            'message' => 'Achievement updated successfully'
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
        $achievement = Achievement::findOrFail($id);
        $achievement->delete();
        if ($achievement->attachment) {
            Storage::disk('public')->delete($achievement->attachment);
        }

        return response()->json([
            'message' => 'Achievement deleted successfully'
        ]);
    }

    protected function uploadAttachment(Request $request)
    {
        if (!$request->hasFile('attachment')) {
            return;
        }
        $file = $request->file('attachment');
        $path = $file->store('uploads', [
            'disk' => 'public'
        ]);
        return $path;
    }
}
