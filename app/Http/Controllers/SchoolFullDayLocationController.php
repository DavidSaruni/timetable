<?php

namespace App\Http\Controllers;

use App\Models\SchoolFullDayLocation;
use Illuminate\Http\Request;

class SchoolFullDayLocationController extends Controller
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
        // validate the request
        $request->validate([
            'school_id' => 'required|integer|exists:schools,school_id',
            'full_day_location_id' => 'required|integer|exists:full_day_locations,full_day_location_id',
        ]);

        $schoolFullDayLocation = new SchoolFullDayLocation();
        $schoolFullDayLocation->school_id = $request->school_id;
        $schoolFullDayLocation->full_day_location_id = $request->full_day_location_id;
        $schoolFullDayLocation->save();

        toastr()->success('School full day location created successfully');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(SchoolFullDayLocation $schoolFullDayLocation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SchoolFullDayLocation $schoolFullDayLocation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SchoolFullDayLocation $schoolFullDayLocation)
    {
        //
        $request->validate([
            'school_id' => 'required|integer|exists:schools,school_id',
            'full_day_location_id' => 'required|integer|exists:full_day_locations,full_day_location_id',
        ]);

        $schoolFullDayLocation = SchoolFullDayLocation::find($$request->full_day_location_id);
        if (!$schoolFullDayLocation) {
            toastr()->error('School full day location not found.');
            return redirect()->back();
        }

        $schoolFullDayLocation->full_day_location_id = $request->full_day_location_id;
        $schoolFullDayLocation->save();

        toastr()->success('School full day location updated successfully');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $schoolFullDayLocation = SchoolFullDayLocation::where('school_id', $request->school_id)
            ->where('full_day_location_id', $request->full_day_location_id)
            ->firstOrFail();

        if ($schoolFullDayLocation->delete()) {
            toastr()->success('School full day location deleted successfully');
        } else {
            toastr()->error('An error occurred while deleting the school\'s full day location');
        }

        return redirect()->back();
    }

    /**
     * Return school full day location details as JSON on ajax request
     */

    public function schoolFullDayLocationRow(Request $request)
    {
        $id = $request->id;
        $schoolFullDayLocation = SchoolFullDayLocation::find($id);

        return response()->json([
            'schoolFullDayLocation' => $schoolFullDayLocation,
        ]);
    }
}
