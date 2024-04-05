<?php

namespace App\Http\Controllers;

use App\Models\FullDayLocation;
use App\Models\Labtype;
use App\Models\School;
use Illuminate\Http\Request;

class FullDayLocationController extends Controller
{
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
            'name' => 'required|string|max:255',
            'days' => 'required|array',
            'cohorts' => 'required|int',
        ]);

        $days = $request->days;
        $days_json = json_encode($days);

        // create new FullDayLocation instance
        $fullDayLocation = new FullDayLocation();
        $fullDayLocation->name = $request->name;
        $fullDayLocation->days = $days_json;
        $fullDayLocation->cohorts = $request->cohorts;
        $fullDayLocation->save();

        toastr()->success('FullDayLocation created successfully');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $fullDayLocation = FullDayLocation::find($id);
        if (!$fullDayLocation) {
            toastr()->error('Location not found');
            return redirect()->back();
        }
        // Get all schools that are not already assigned to the fullDayLocation
        $schools = School::whereDoesntHave('fullDayLocations', function ($query) use ($fullDayLocation) {
            $query->where('full_day_locations.full_day_location_id', $fullDayLocation->fullDayLocation_id);
        })->orderBy('name', 'asc')->get();
        return view('buildings.locations')->with([
            'fullDayLocation' => $fullDayLocation,
            'schools' => $schools,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FullDayLocation $fullDayLocation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FullDayLocation $fullDayLocation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $fullDayLocation = FullDayLocation::find($request->fullDayLocation_id);

        if (!$fullDayLocation) {
            toastr()->error('Location not found');
            return redirect()->back();
        }

        $fullDayLocation->delete();

        toastr()->success('Location deleted successfully');

        return redirect()->back();
    }

    /**
     * Return fullDayLocation details as JSON on ajax request
     */
    public function fulldaylocationRow(Request $request)
    {
        $id = $request->id;
        $fullDayLocation = FullDayLocation::find($id);
        return response()->json($fullDayLocation);
    }
}