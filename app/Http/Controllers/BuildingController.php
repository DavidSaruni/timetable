<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\FullDayLocation;
use App\Models\Labtype;
use App\Models\School;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $buildings = Building::orderBy('name', 'asc')->get();
        $fullDayLocations = FullDayLocation::orderBy('name', 'asc')->get();

        return view('buildings.index')->with([
            'buildings' => $buildings,
            'fullDayLocations' => $fullDayLocations,
        ]);
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
            'name' => 'required|string|max:255',
        ]);
        
        $building = new Building();
        $building->name = $request->name;
        $building->save();

        toastr()->success('Building created successfully');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Building $building)
    {
        $labtypes = Labtype::orderBy('type', 'asc')->get();
        $labs = $building->labs()->orderBy('lab_name', 'asc')->get();
        $lectureRooms = $building->lectureRooms()->orderBy('lecture_room_name', 'asc')->get();
        // Get all schools that are not already assigned to the building
        $schools = School::whereDoesntHave('buildings', function ($query) use ($building) {
            $query->where('buildings.building_id', $building->building_id);
        })->orderBy('name', 'asc')->get();
        return view('buildings.show')->with([
            'building' => $building,
            'labtypes' => $labtypes,
            'labs' => $labs,
            'lectureRooms' => $lectureRooms,
            'schools' => $schools,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Building $building)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Building $building)
    {
        //
        $request->validate([
            'building_id' => 'required|integer|exists:buildings,building_id',
            'name' => 'required|string|max:255',
        ]);

        $building = Building::find($request->building_id);
        if(!$building)
        {
            toastr()->error('Building not found.');
            return redirect()->back();
        }

        $building->name = $request->name;
        $building->save();

        toastr()->success('Building updated successfully');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $building = Building::find($request->building_id);

        $building->delete();

        toastr()->success('Building deleted successfully');

        return redirect()->back();
    }

    /**
     * Return building details as JSON on ajax request
     */
    public function buildingRow(Request $request)
    {
        $id = $request->id;
        $building = Building::find($id);
        return response()->json($building);
    }
}
