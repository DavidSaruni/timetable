<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Labtype;
use App\Models\SchoolLecturer;
use App\Models\UnitAssingment;
use Illuminate\Http\Request;

class DepartmentController extends Controller
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
            'name' => 'required|string|max:255',
            'school_id' => 'required|integer|exists:schools,school_id',
            'hod_id' => 'required|integer|exists:users,user_id',
        ]);

        $department = new Department();
        $department->name = $request->name;
        $department->school_id = $request->school_id;
        $department->hod_id = $request->hod_id;
        $department->save();

        $user = $department->hod;
        $user->role = 'HEAD OF DEPARTMENT';
        $user->save();

        $schoolLecturer = SchoolLecturer::where('school_id', $department->school_id)->where('lecturer_id', $department->hod_id)->first();
        $schoolLecturer->department_id = $department->department_id;
        $schoolLecturer->save();

        toastr()->success('Department created successfully');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        $units = $department->units;
        $labtypes = Labtype::all();
        $unit_assingments = collect();
        foreach($units as $unit) {
            $unit_assingment = UnitAssingment::where('unit_id', $unit->unit_id)->get();
            if($unit_assingment->count() > 0)
            {
                $unit_assingments->push($unit_assingment);
            }
        }
        $unit_assingments = $unit_assingments->flatten();
        return view('departments.show', compact('department', 'units', 'labtypes', 'unit_assingments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        //
    }
}
