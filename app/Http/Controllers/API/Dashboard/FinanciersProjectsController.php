<?php

namespace App\Http\Controllers\API\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Financier;
use App\Models\FinancierProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinanciersProjectsController extends Controller
{
    public function showFinanciers(Request $request)
    {
        $financierAvailable = Financier::whereNotExists(function ($query) use ($request) {
            $query->select(DB::raw(1))->from('financier_projects')
                ->where('project_id', '=', $request->project_id)
                ->whereColumn('financier_id', 'financiers.id');
        })->get();

        return $financierAvailable;
    }

    public function store(Request $request)
    {

        $request->validate([
            'project_id' => 'required|integer|exists:projects,id',
            'financier_id' => 'required|integer|exists:financiers,id',
        ]);

        $financierProject = FinancierProject::firstOrCreate([
            'project_id' => $request->input('project_id'),
            'financier_id' => $request->input('financier_id'),
        ]);

        return response()->json([
            'message' => 'Financier added successfully to the project'
        ]);
    }
}
