<?php

namespace App\Http\Controllers\API\Dashboard;


use App\Http\Controllers\Controller;
use App\Imports\TraineesImport;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class GroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $groups = Group::with('project:id,name', 'trainees', 'course', 'achievements')
        ->orderBy('end_date', 'DESC')
        ->filter($request->query())->get();
        
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
        $request->validate(Group::rules());
        $group = Group::create($request->all());

        return response()->json([
            'message' => 'Group created successfully',
            'project' => $group
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        return $group->load('project:id,name', 'trainees', 'course', 'achievements');
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
        $request->validate(Group::rules());
        $group->update($request->all());

        return response()->json([
            'message' => 'Group updated successfully',
            'project' => $group
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
        Group::destroy($id);

        return response()->json([
            'message' => 'Group deleted successfully',
        ]);
    }

    public function destroyTrainees(Request $request)
    {
        DB::table('group_trainee')
            ->where('trainee_id', $request->trainee_id)
            ->where('group_id', $request->group_id)
            ->delete();
    }

    public function import(Request $request)
    {
        Excel::import(new TraineesImport($request), $request->file('trainee'));

        return response()->json([
            'message' => 'ok'
        ]);
    }
}
