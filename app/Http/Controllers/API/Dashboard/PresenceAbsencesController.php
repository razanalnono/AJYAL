<?php

namespace App\Http\Controllers\API\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\PresenceAbsence;
use Illuminate\Http\Request;

class PresenceAbsencesController extends Controller
{
    public function index(Request $request)
    {
        $presenceAbsences = PresenceAbsence::with('course:id,name', 'trainee:id,firstName,lastName')
            ->filter($request->query())->get();
        return $presenceAbsences;
    }

    public function store(Request $request)
    {
        $request->validate(PresenceAbsence::rules());
        $request->merge([
            'date' => $request->date ? $request->date : now()
        ]);
        
        $prePresenceAbsence = PresenceAbsence::where('trainee_id',  $request->trainee_id)
        ->where('course_id',  $request->course_id)
        ->whereDate('date', $request->date)->first();

        if ($prePresenceAbsence) {
            return response()->json([
                'message' => 'هذا الحقل موجود'
            ]);
        }
        $presenceAbsence = PresenceAbsence::create($request->all());
        return response()->json([
            'message' => 'Ok'
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate(PresenceAbsence::rules());
        $presenceAbsence = PresenceAbsence::findOrFail($id);
        $request->merge([
            'date' => $request->date ? $request->date : now()
        ]);
        
        $prePresenceAbsence = PresenceAbsence::where('trainee_id',  $request->trainee_id)
        ->where('course_id',  $request->course_id)
        ->whereDate('date', $request->date)->first();

        if (! $prePresenceAbsence) {
            $presenceAbsence->update($request->all());
        } else {
            $presenceAbsence->update($request->only('status'));
        }
        return response()->json([
            'message' => 'updated'
        ]);
        
    }
}
