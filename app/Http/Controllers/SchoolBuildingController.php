<?php

namespace App\Http\Controllers;

use App\Models\SchoolBuilding;
use Illuminate\Http\Request;

class SchoolBuildingController extends Controller
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
            'building_id' => 'required|integer|exists:buildings,building_id',
        ]);

        $schoolBuilding = new SchoolBuilding();
        $schoolBuilding->school_id = $request->school_id;
        $schoolBuilding->building_id = $request->building_id;
        $schoolBuilding->save();

        toastr()->success('School building created successfully');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(SchoolBuilding $schoolBuilding)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SchoolBuilding $schoolBuilding)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SchoolBuilding $schoolBuilding)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $schoolBuilding = SchoolBuilding::where('school_id', $request->school_id)->where('building_id', $request->building_id)->first();
        $schoolBuilding->delete();

        toastr()->success('School building deleted successfully');

        return redirect()->back();
    }
}
