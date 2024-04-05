<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\UnitPreference;
use App\Models\UnitPreferredLab;
use App\Models\UnitPreferredPeriod;
use App\Models\UnitPreferredRoom;
use Illuminate\Http\Request;

class UnitPreferenceController extends Controller
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
    public function create(Request $request)
    {
        // validate the data
        $request->validate([
            'unit_id' => 'required|integer|exists:units,unit_id',
        ]);


        $unit = Unit::findOrFail($request->unit_id);
        if ($unit)
        {
            $school = $unit->school;
            $school_periods = $school->schoolPeriods->groupBy('day_of_week');
            $buildings = $school->buildings;
            return view('unit_preferences.create', compact('unit', 'school_periods', 'buildings'));
        }
        else
        {
            toastr()->error('Unit not found.');
            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'unit_id' => 'required|integer|exists:units,unit_id',
        ]);
        if ($request->lecture_room_ids == null && $request->school_period_ids == null && $request->lab_ids == null)
        {
            toastr()->error('Please select at least one preference.');
            return redirect()->back();
        }
        $unit_preference = new UnitPreference();
        $unit_preference->unit_id = $request->unit_id;
        $unit_preference->save();
        if ($request->lecture_room_ids)
        {
            foreach ($request->lecture_room_ids as $room_id)
            {
                $unitPreferredRoom = new UnitPreferredRoom();
                $unitPreferredRoom->unit_preference_id = $unit_preference->unit_preference_id;
                $unitPreferredRoom->lecture_room_id = $room_id;
                $unitPreferredRoom->save();
            }
        }
        if ($request->school_period_ids)
        {
            foreach ($request->school_period_ids as $period_id)
            {
                $unitPreferredTime = new UnitPreferredPeriod(); 
                $unitPreferredTime->unit_preference_id = $unit_preference->unit_preference_id;
                $unitPreferredTime->school_period_id = $period_id;
                $unitPreferredTime->save();
            }
        }
        if ($request->lab_ids)
        {
            foreach ($request->lab_ids as $lab_id)
            {
                $unitPreferredLab = new UnitPreferredLab();
                $unitPreferredLab->unit_preference_id = $unit_preference->unit_preference_id;
                $unitPreferredLab->lab_id = $lab_id;
                $unitPreferredLab->save();
            }
        }
        toastr()->success('Unit preference created successfully.');
        return redirect()->route('preferences');
    }

    /**
     * Display the specified resource.
     */
    public function show(UnitPreference $unitPreference)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UnitPreference $unitPreference)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UnitPreference $unitPreference)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $unitPreference = UnitPreference::findOrFail($request->unit_preference_id);
        $unitPreference->delete();
        toastr()->success('Unit preference deleted successfully.');
        return redirect()->back();
    }
}
