<?php

namespace App\Http\Controllers;

use App\Models\SchoolLecturer;
use App\Models\User;
use Illuminate\Http\Request;

class SchoolLecturerController extends Controller
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
            'lecturer_ids' => 'required|array',
        ]);

        foreach ($request->lecturer_ids as $lecturer_id) {
            $schoolLecturer = new SchoolLecturer();
            $schoolLecturer->school_id = $request->school_id;
            $schoolLecturer->lecturer_id = $lecturer_id;
            $schoolLecturer->save();

            if ($schoolLecturer->lecturer->role == User::ROLE_USER) {
                $schoolLecturer->lecturer->role = User::ROLE_LECTURER;
                $schoolLecturer->lecturer->save();
            }
        }

        toastr()->success('School lecturer created successfully');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(SchoolLecturer $schoolLecturer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SchoolLecturer $schoolLecturer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SchoolLecturer $schoolLecturer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $schoolLecturer = SchoolLecturer::findOrFail($request->school_lecturer_id);
        if ($schoolLecturer->lecturer->schools->count() == 1) {
            if ($schoolLecturer->lecturer->role == User::ROLE_LECTURER) {
                $schoolLecturer->lecturer->role = User::ROLE_USER;
                $schoolLecturer->lecturer->save();
            }
        }
        $schoolLecturer->delete();

        toastr()->success('School lecturer deleted successfully');

        return redirect()->back();
    }
}
