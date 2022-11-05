<?php

namespace App\Http\Controllers\API\Dashboard;


use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Project;
use App\Models\Trainee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class GroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Group::with('project:id,name', 'trainees')->paginate();
        return $groups;
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
            'name' => ['required', 'string', 'max:255'],
            'project_id' => ['required', 'exists:projects,id'],
        ]);

        $group = Group::create();
        return Response::json($group, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        return $group->load('project:id,name');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'project_id' => ['sometimes', 'required', 'exists:projects,id'],
        ]);

        $group->update($request->all());
        return Response::json($group);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Group::destroy($id);
        return response()->json([
            'message' => 'Deleted Successfuly.'
        ], 200);
    }

    public function destroyTrainees(Request $request){
        DB::table('group_trainee')
        ->where('trainee_id', $request->trainee_id)
        ->where('group_id', $request->group_id)
        ->delete();
    }
}