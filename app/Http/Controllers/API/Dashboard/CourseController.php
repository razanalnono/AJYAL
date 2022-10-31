<?php

namespace App\Http\Controllers\API\Dashboard;

use App\Events\SendEmailEvent;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Trainee;
use App\Models\Trainer;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

       $courses=Course::query()->select('name','link','start_date','end_date','trainer_id')
            ->with(['trainer' => function ($query) {
            $query->select('id','firstName','lastName');
            }])->get();
            return $courses;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name'=>'required',
            'start_date'=>['required'],
            'end_date'=>['required','after:'.$request->start_date],
        ]);
        Course::create($request->post());
      
        // $name = Course::orderByRaw('id DESC')->limit(1)->get('name');
        // $link = Course::orderByRaw('id DESC')->limit(1)->get('link');

        event(new SendEmailEvent($request->name,$request->link));
        
        return response()->json([
            'message'=>'Course Created Successfully'
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
    public function update(Request $request, Course $course)
    {
        //
        $course->update($request->all());
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
    public function destroy(Course $course)
    {
        //
        $course->delete();
        return response()->json([
            'message'=>'Course Deleted Successfully'
        ]);
    }
}