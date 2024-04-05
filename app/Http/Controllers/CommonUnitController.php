<?php

namespace App\Http\Controllers;

use App\Models\Cohort;
use App\Models\CommonUnit;
use App\Models\Department;
use App\Models\Labtype;
use App\Models\Lecturer;
use App\Models\School;
use App\Models\UnitAssingment;
use Illuminate\Http\Request;

class CommonUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all common units ordered by name
        $commonUnits = CommonUnit::orderBy('name', 'asc')->get();
        // Get all $commonUnits->unitAssignments
        $unit_assingments = UnitAssingment::getCommonUnitAssignments();
        // Get all schools ordered by name
        $schools = School::orderBy('name', 'asc')->get();
        // Get all departments ordered by name
        $departments = Department::orderBy('name', 'asc')->get();
        // Get all lab types ordered by type
        $labtypes = Labtype::orderBy('type', 'asc')->get();
        // Get all lecturers ordered by name
        $lecturers = Lecturer::orderBy('name', 'asc')->get();
        // Get all cohorts ordered by name
        $cohorts = Cohort::orderBy('name', 'asc')->get();
        return view('commonunits.index', compact('commonUnits', 'schools', 'departments', 'labtypes', 'unit_assingments', 'lecturers', 'cohorts'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CommonUnit $commonUnit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CommonUnit $commonUnit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CommonUnit $commonUnit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CommonUnit $commonUnit)
    {
        //
    }
}
