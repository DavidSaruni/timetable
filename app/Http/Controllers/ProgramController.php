<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'school_id' => 'required|integer|exists:schools,school_id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'academic_years' => 'required|integer|min:1|max:5',
            'semesters' => 'required|integer|min:1|max:3',
            'max_group_size' => 'required|integer|min:1',
        ]);

        $program = new Program();
        $program->school_id = $request->school_id;
        $program->name = $request->name;
        $program->code = $request->code;
        $program->academic_years = $request->academic_years;
        $program->semesters = $request->semesters;
        $program->max_group_size = $request->max_group_size;
        $program->save();

        // Create cohorts for the program
        for ($i = 1; $i <= $request->academic_years; $i++) {
            for ($j = 1; $j <= $request->semesters; $j++) {
                $name = $program->code . ' Year ' . $i . ' Semester ' . $j;
                $code = $program->code . '-Y' . $i . '-S' . $j;
                $program->cohorts()->create([
                    'name' => $name,
                    'code' => $code,
                    'student_count' => 0,
                    'status' => 'NOTINSESSION',
                ]);
            }
        }

        toastr()->success('Program created successfully');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Program $program)
    {
        return view('programs.show', compact('program'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Program $program)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Program $program)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $program = Program::find($request->program_id);
        $program->delete();

        toastr()->success('Program deleted successfully');

        return redirect()->back();
    }
}
