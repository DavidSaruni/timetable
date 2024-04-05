<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\FullDayLocation;
use App\Models\School;
use App\Models\SchoolLecturer;
use App\Models\SchoolPeriods;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all schools ordered by name
        $schools = School::orderBy('name', 'asc')->get();
        // Get users who can be assigned as dean. They are the users whose role is neither ADMIN nor DEAN
        $deans = User::where('role', '!=', User::ROLE_ADMIN)->where('role', '!=', User::ROLE_DEAN)->orderBy('name', 'asc')->get();
        return view('schools.index', compact('schools', 'deans'));
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
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'dean_id' => 'required|integer|exists:users,user_id',
            'period_length' => 'required|integer|min:1|max:3',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);
        // Generate slug from name as an abbreviation of the school name.  e.g. School of Computer Science and Engineering will have a slug of SCSE
        $slug = '';
        $words = explode(' ', $request->name);
        foreach ($words as $word) {
            // Get the first letter of each word ignoring words like 'of', 'and', 'the', etc.
            if (!in_array($word, ['of', 'and', 'the', 'in', 'at', 'on', 'for', 'to', 'a', 'an'])) {
                $slug = $slug . strtoupper(substr($word, 0, 1));
            }
        }
        // Check if the slug already exists in the database
        $counter = 1;
        while (School::where('slug', $slug)->first()) {
            $slug = $slug . $counter;
            $counter++;
        }
        // Create a new school
        $school = new School();
        $school->name = $request->name;
        $school->slug = $slug;
        $school->dean_id = $request->dean_id;
        $school->save();

        // update the role of the dean to DEAN
        $dean = User::find($request->dean_id);
        $dean->role = User::ROLE_DEAN;
        $dean->save();

        // add dean as a lecturer in the school
        $schoolLecturer = new SchoolLecturer();
        $schoolLecturer->school_id = $school->school_id;
        $schoolLecturer->lecturer_id = $dean->user_id;
        $schoolLecturer->save();

        // Create the default school periods for the school ensure that the last period ends at the end_time and that their is no period on Wednesday between 11:00 and 13:00
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        $period_length = $request->period_length; // in hours
        $start_time = Carbon::createFromFormat('H:i', $request->start_time);
        $end_time = Carbon::createFromFormat('H:i', $request->end_time);
        $lunch_break = null;
        if(($start_time->diffInHours($end_time) % $period_length) !== 0) {
            $lunch_break = ($start_time->diffInHours($end_time) % $period_length);
        }
        foreach ($days as $day) {
            $current_start_time = $start_time->copy();
            $current_end_time = $current_start_time->copy()->addHours($period_length);

            while ($current_end_time->lessThanOrEqualTo($end_time)) {
                if ($day === 'Wednesday' && ($current_start_time->between('10:59', '13:00') || $current_end_time->between('11:01', '13:00'))) {
                    $current_start_time = Carbon::createFromFormat('H:i', '13:00');
                    $current_end_time = $current_start_time->copy()->addHours($period_length);
                }
                if($lunch_break > 0)
                {
                    if($current_start_time->between('12:59', '13:02'))
                    {
                        $current_start_time = $current_start_time->addHours($lunch_break);
                        $current_end_time = $current_start_time->copy()->addHours($period_length);
                    }
                }
                $school_period = new SchoolPeriods();
                $school_period->day_of_week = $day;
                $school_period->start_time = $current_start_time;
                $school_period->end_time = $current_end_time;
                $school_period->school_id = $school->school_id;
                $school_period->save();

                $current_start_time = $current_end_time;
                $current_end_time = $current_start_time->copy()->addHours($period_length);
            }
        }

        toastr()->success('School created successfully.');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(School $school)
    {
        // Get the school lecturers
        $schoolLecturers = $school->lecturers;
        // Get users who can be assigned as hod. They are school lecturers whose role is LECTURER
        $hods = $schoolLecturers->where('role', User::ROLE_LECTURER);
        // Get all buildings that are not already assigned to the school
        $buildings = Building::whereDoesntHave('schools', function ($query) use ($school) {
            $query->where('schools.school_id', $school->school_id);
        })->orderBy('name', 'asc')->get();
        // Get all full day locations that are not already assigned to the school
        $fullDayLocations = FullDayLocation::whereDoesntHave('schools', function ($query) use ($school) {
            $query->where('schools.school_id', $school->school_id);
        })->orderBy('name', 'asc')->get();
        // Get all lecturers that are not already assigned to the school
        $lecturers = User::whereDoesntHave('schools', function($query) use ($school) {
            $query->where('schools.school_id', $school->school_id);
        })->orderBy('name', 'asc')->where('role', '!=', User::ROLE_ADMIN)->get();
        return view('schools.show', compact('school', 'hods', 'buildings', 'fullDayLocations', 'lecturers'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(School $school)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
        // dd($request->all());
        $request->validate([
            'school_id' => 'required|integer|exists:schools,school_id',
            'name' => 'required|string|max:255',
        ]);

        $school = School::find($request->school_id);
        if(!$school)
        {
            toastr()->error('School not found.');
            return redirect()->back();
        }

        $school->name = $request->name;
        $school->save();

        toastr()->success('School updated successfully.');

        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $school = School::find($request->school_id);
        // update the role of the dean to lecturer
        $dean = $school->dean;
        $dean->role = User::ROLE_LECTURER;
        $dean->save();
        // update the role of the hod to lecturer
        $departments = $school->departments;
        foreach ($departments as $department) {
            $hod = $department->hod;
            $hod->role = User::ROLE_LECTURER;
            $hod->save();
        }
        // delete the school
        $school->delete();

        toastr()->success('School deleted successfully.');

        return redirect()->back();
    }

    /**
     * Return school details as JSON on ajax request
     */
    public function schoolRow(Request $request)
    {
        $id = $request->id;
        $school = School::find($id);
        return response()->json($school);
    }
}
