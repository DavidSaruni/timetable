<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
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
        //
        $unit = new Unit();
        $unit->name = $request->name;
        $unit->code = $request->code;
        $unit->department_id = $request->department_id;
        if($request->lab_alternative == "true")
        {
            $unit->has_lab = true;
            $unit->lab_alternative = true;
            $unit->lab_hours = $request->lab_hours;
            $unit->labtype_id = $request->labtype_id;
        }
        else if($request->lab_alternative == "false")
        {
            $unit->has_lab = true;
            $unit->lab_alternative = false;
            $unit->lab_hours = $request->lab_hours;
            $unit->labtype_id = $request->labtype_id;
        }
        else
        {
            $unit->has_lab = false;
        }
        if($request->is_full_day == "true")
        {
            $unit->is_full_day = true;
            $school = Department::find($request->department_id)->school;
            $unit->lecturer_hours = $school->getHoursInDayAttribute();
        }
        else
        {
            $unit->is_full_day = false;
            $unit->lecturer_hours = $request->lecturer_hours;
        }
        if($request->is_common == "true")
        {
            $unit->is_common = true;
        }
        else
        {
            $unit->is_common = false;
        }
        $unit->save();

        toastr()->success('Unit created successfully');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Unit $unit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unit $unit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unit $unit)
    {
        //
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'department_id' => 'required|integer|exists:departments,department_id',
            'lab_alternative' => 'string|nullable',
            'lab_hours' => 'required|integer|min:0',
            'labtype_id' => 'required|integer|exists:labtypes,labtype_id',
            'is_full_day' => 'boolean',
            'lecturer_hours' => 'required|integer|min:0',
        ]);

        $unit = Unit::find($request->unit_id);
        if(!$unit) {
            toastr()->error('Unit not found');
            return redirect()->back();
        }

        $unit->name = $request->name;
        $unit->code = $request->code;
        $unit->department_id = $request->department_id;
        if($request->lab_alternative == "true")
        {
            $unit->has_lab = true;
            $unit->lab_alternative = true;
            $unit->lab_hours = $request->lab_hours;
            $unit->labtype_id = $request->labtype_id;
        }
        else if($request->lab_alternative == "false")
        {
            $unit->has_lab = true;
            $unit->lab_alternative = false;
            $unit->lab_hours = $request->lab_hours;
            $unit->labtype_id = $request->labtype_id;
        }
        else
        {
            $unit->has_lab = false;
        }

        if($request->is_full_day == "true")
        {
            $unit->is_full_day = true;
            $school = Department::find($request->department_id)->school;
            $unit->lecturer_hours = $school->getHoursInDayAttribute();
        }
        else
        {
            $unit->is_full_day = false;
            $unit->lecturer_hours = $request->lecturer_hours;
        }
        $unit->save();

        toastr()->success('Unit updated successfully');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        $unit->delete();
        toastr()->success('Unit deleted successfully');
        return redirect()->back();
    }

    /**
     * Return unit details as JSON on ajax request
     */


    public function unitRow(Request $request)
    {
        $id = $request->id;
        $unit = Unit::find($id);
        return response()->json($unit);
    }

}
