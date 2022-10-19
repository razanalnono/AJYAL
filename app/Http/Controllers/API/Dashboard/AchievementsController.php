<?php

namespace App\Http\Controllers\API\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Achievements;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class AchievementsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $achievements = Achievements::with('trainee:id,firstName,lastName', 'group:id,name')
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
        $request->validate([
            'platform' => ['in:مستقل,upwork,freelancer,خمسات,other'],
            'other' => ["required_if:platform,==,other", 'nullable', 'string', 'max:255'],
            'income' => ['required', 'numeric', 'min:0'],
            'group_id' => ['required', 'exists:groups,id'],
            'trainee_id' => ['required', 'exists:trainees,id'],
        ]);

        $achievement = Achievements::create($request->all());
        return Response::json($achievement, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Achievements $achievement)
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
    public function update(Request $request, Achievements $achievement)
    {
        $request->validate([
            'platform' => ['in:مستقل,upwork,freelancer,خمسات,other'],
            'other' => ["required_if:platform,==,other",'nullable', 'string', 'max:255'],
            'income' => ['sometimes', 'required', 'numeric', 'min:0'],
            'group_id' => ['sometimes', 'required', 'exists:groups,id'],
            'trainee_id' => ['sometimes', 'required', 'exists:trainees,id'],
        ]);

        $achievement->update($request->all());
        return Response::json($achievement);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Achievements::destroy($id);

        return response()->json([
            'message' => 'Deleted Successfuly.'
        ], 200);
    }
}
