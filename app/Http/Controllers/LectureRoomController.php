<?php

namespace App\Http\Controllers;

use App\Models\LectureRoom;
use Illuminate\Http\Request;

class LectureRoomController extends Controller
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
            'building_id' => 'required|integer|exists:buildings,building_id',
            'lecture_room_name' => 'required|string|max:255',
            'lecture_room_capacity' => 'required|integer',
        ]);

        $lectureRoom = new LectureRoom();
        $lectureRoom->building_id = $request->building_id;
        $lectureRoom->lecture_room_name = $request->lecture_room_name;
        $lectureRoom->lecture_room_capacity = $request->lecture_room_capacity;
        $lectureRoom->save();

        toastr()->success('Lecture room created successfully');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(LectureRoom $lectureRoom)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LectureRoom $lectureRoom)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LectureRoom $lectureRoom)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LectureRoom $lectureRoom)
    {
        //
    }
}
