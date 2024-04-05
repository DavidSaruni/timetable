<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\UnitAssingment;
use Illuminate\Http\Request;

class UnitAssingmentController extends Controller
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
        // validate the request manually
        $request->validate([
            'unit_id' => 'required|integer|exists:units,unit_id',
            'lecturer_id' => 'required|integer|exists:users,user_id',
            'cohort_id' => 'required|integer|exists:cohorts,cohort_id',
        ]);

        $unit = Unit::where('unit_id', $request->unit_id)->first();
        // check if the lecturer is already assigned to the same combination of unit and cohort
        $unitAssingment = UnitAssingment::where('unit_id', $request->unit_id)->where('lecturer_id', $request->lecturer_id)->where('cohort_id', $request->cohort_id)->first();
        if ($unitAssingment) {
            toastr()->error('The lecturer is already assigned to the unit for the cohort');
            return redirect()->back();
        }

        // check if the cohort is already assigned to the same unit
        $unitAssingment2 = UnitAssingment::where('unit_id', $request->unit_id)->where('cohort_id', $request->cohort_id)->first();
        if ($unitAssingment2) {
            toastr()->error('The unit is already assigned to the cohort');
            return redirect()->back();
        }
        else {
            $unitAssingment = new UnitAssingment();
            $unitAssingment->unit_id = $request->unit_id;
            $unitAssingment->lecturer_id = $request->lecturer_id;
            $unitAssingment->cohort_id = $request->cohort_id;
            $unitAssingment->is_common = false;
            $unitAssingment->common_value = null;
            $unitAssingment->group_size = null;
            $unitAssingment->save();

            toastr()->success('Unit assigned successfully');

            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage for common units.
     */
    public function storeCommon(Request $request)
    {
        // validate the request manually
        $request->validate([
            'unit_id' => 'required|integer|exists:units,unit_id',
            'lecturer_id' => 'required|integer|exists:users,user_id',
            'cohort_id' => 'required|array',
            'group_size' => 'required|integer',
        ]);

        // create a common_value for the common units that does not exist yet in the unit_assignments table
        $commonValue = UnitAssingment::where('is_common', true)->max('common_value');
        if (!$commonValue) {
            $commonValue = 1;
        }
        else {
            $commonValue++;
        }

        $unit = Unit::where('unit_id', $request->unit_id)->first();
        // for each cohort check if the lecturer is already assigned to the same combination of unit and cohort
        foreach ($request->cohort_id as $cohortId) {
            $unitAssingment = UnitAssingment::where('unit_id', $request->unit_id)->where('lecturer_id', $request->lecturer_id)->where('cohort_id', $cohortId)->first();
            if ($unitAssingment) {
                // if the lecturer is already assigned to the same combination of unit and cohort, delete the previous assignment and create a new one
                $unitAssingment->delete();
            }

            // check if the cohort is already assigned to the same unit
            $unitAssingment2 = UnitAssingment::where('unit_id', $request->unit_id)->where('cohort_id', $cohortId)->first();
            if ($unitAssingment2) {
                // if the cohort is already assigned to the same unit, delete the previous assignment and create a new one
                $unitAssingment2->delete();
            }
            else {
                $unitAssingment = new UnitAssingment();
                $unitAssingment->unit_id = $request->unit_id;
                $unitAssingment->lecturer_id = $request->lecturer_id;
                $unitAssingment->cohort_id = $cohortId;
                $unitAssingment->is_common = true;
                $unitAssingment->common_value = $commonValue;
                $unitAssingment->group_size = $request->group_size;
                $unitAssingment->save();
            }
        }

        toastr()->success('Common unit assigned successfully');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(UnitAssingment $unitAssingment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UnitAssingment $unitAssingment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UnitAssingment $unitAssingment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $unitAssingment = UnitAssingment::where('unit_assingment_id', $request->unit_assignment_id)->first();
        if (!$unitAssingment) {
            toastr()->error('Unit assignment not found');
            return redirect()->back();
        }
        $unitAssingment->delete();
        toastr()->success('Unit unassigned successfully');
        return redirect()->back();
    }
}
