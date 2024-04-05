<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LecturerPreferredTime;
use App\Models\Unit;
use Illuminate\Http\Request;
use stdClass;

class LecturerPreferredTimeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all lecturers with preferred times
        $lecturer_preferred_times = User::with('lecturer_preferred_times')->whereHas('lecturer_preferred_times')->get();
        // Get all lecturers who don't have preferred times
        $lecturers = User::with('lecturer_preferred_times')->whereDoesntHave('lecturer_preferred_times')->where('role', '!=', User::ROLE_ADMIN)->where('role', '!=', User::ROLE_USER)->get();
        // Get all units with preferences
        $unit_preferences = Unit::with('unit_preference')->whereHas('unit_preference')->get();
        // Get all units without preferences
        $units = Unit::with('unit_preference')->whereDoesntHave('unit_preference')->orderBy('code')->get();
        return view('lecturer_preferred_times.index', compact('lecturer_preferred_times', 'lecturers', 'unit_preferences', 'units'));
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
        // validate the data
        $request->validate([
            'lecturer_id' => 'required|integer|exists:users,user_id',
            'monday' => 'array',
            'tuesday' => 'array',
            'wednesday' => 'array',
            'thursday' => 'array',
            'friday' => 'array',
        ]);

        // create new lecturer preferred times for each day
        // check if the day has data
        if($request->monday){
            // create new lecturer preferred times for monday
            foreach ($request->monday as $monday) {
                $lecturer_preferred_time = new LecturerPreferredTime();
                $lecturer_preferred_time->lecturer_id = $request->lecturer_id;
                $lecturer_preferred_time->day = LecturerPreferredTime::DAY_MONDAY;
                if($monday == 1){
                    $lecturer_preferred_time->start_time = '07:00:00';
                    $lecturer_preferred_time->end_time = '10:00:00';
                }
                elseif($monday == 2){
                    $lecturer_preferred_time->start_time = '10:00:00';
                    $lecturer_preferred_time->end_time = '13:00:00';
                }
                elseif($monday == 3){
                    $lecturer_preferred_time->start_time = '13:00:00';
                    $lecturer_preferred_time->end_time = '16:00:00';
                }
                elseif($monday == 4){
                    $lecturer_preferred_time->start_time = '16:00:00';
                    $lecturer_preferred_time->end_time = '19:00:00';
                }
                $lecturer_preferred_time->save();
            }
        }
        if($request->tuesday){
            // create new lecturer preferred times for tuesday
            foreach ($request->tuesday as $tuesday) {
                $lecturer_preferred_time = new LecturerPreferredTime();
                $lecturer_preferred_time->lecturer_id = $request->lecturer_id;
                $lecturer_preferred_time->day = LecturerPreferredTime::DAY_TUESDAY;
                if($tuesday == 1){
                    $lecturer_preferred_time->start_time = '07:00:00';
                    $lecturer_preferred_time->end_time = '10:00:00';
                }
                elseif($tuesday == 2){
                    $lecturer_preferred_time->start_time = '10:00:00';
                    $lecturer_preferred_time->end_time = '13:00:00';
                }
                elseif($tuesday == 3){
                    $lecturer_preferred_time->start_time = '13:00:00';
                    $lecturer_preferred_time->end_time = '16:00:00';
                }
                elseif($tuesday == 4){
                    $lecturer_preferred_time->start_time = '16:00:00';
                    $lecturer_preferred_time->end_time = '19:00:00';
                }
                $lecturer_preferred_time->save();
            }
        }
        if($request->wednesday){
            // create new lecturer preferred times for wednesday
            foreach ($request->wednesday as $wednesday) {
                $lecturer_preferred_time = new LecturerPreferredTime();
                $lecturer_preferred_time->lecturer_id = $request->lecturer_id;
                $lecturer_preferred_time->day = LecturerPreferredTime::DAY_WEDNESDAY;
                if($wednesday == 1){
                    $lecturer_preferred_time->start_time = '07:00:00';
                    $lecturer_preferred_time->end_time = '10:00:00';
                }
                elseif($wednesday == 2){
                    $lecturer_preferred_time->start_time = '10:00:00';
                    $lecturer_preferred_time->end_time = '13:00:00';
                }
                elseif($wednesday == 3){
                    $lecturer_preferred_time->start_time = '13:00:00';
                    $lecturer_preferred_time->end_time = '16:00:00';
                }
                elseif($wednesday == 4){
                    $lecturer_preferred_time->start_time = '16:00:00';
                    $lecturer_preferred_time->end_time = '19:00:00';
                }
                $lecturer_preferred_time->save();
            }
        }
        if($request->thursday){
            // create new lecturer preferred times for thursday
            foreach ($request->thursday as $thursday) {
                $lecturer_preferred_time = new LecturerPreferredTime();
                $lecturer_preferred_time->lecturer_id = $request->lecturer_id;
                $lecturer_preferred_time->day = LecturerPreferredTime::DAY_THURSDAY;
                if($thursday == 1){
                    $lecturer_preferred_time->start_time = '07:00:00';
                    $lecturer_preferred_time->end_time = '10:00:00';
                }
                elseif($thursday == 2){
                    $lecturer_preferred_time->start_time = '10:00:00';
                    $lecturer_preferred_time->end_time = '13:00:00';
                }
                elseif($thursday == 3){
                    $lecturer_preferred_time->start_time = '13:00:00';
                    $lecturer_preferred_time->end_time = '16:00:00';
                }
                elseif($thursday == 4){
                    $lecturer_preferred_time->start_time = '16:00:00';
                    $lecturer_preferred_time->end_time = '19:00:00';
                }
                $lecturer_preferred_time->save();
            }
        }
        if($request->friday){
            // create new lecturer preferred times for friday
            foreach ($request->friday as $friday) {
                $lecturer_preferred_time = new LecturerPreferredTime();
                $lecturer_preferred_time->lecturer_id = $request->lecturer_id;
                $lecturer_preferred_time->day = LecturerPreferredTime::DAY_FRIDAY;
                if($friday == 1){
                    $lecturer_preferred_time->start_time = '07:00:00';
                    $lecturer_preferred_time->end_time = '10:00:00';
                }
                elseif($friday == 2){
                    $lecturer_preferred_time->start_time = '10:00:00';
                    $lecturer_preferred_time->end_time = '13:00:00';
                }
                elseif($friday == 3){
                    $lecturer_preferred_time->start_time = '13:00:00';
                    $lecturer_preferred_time->end_time = '16:00:00';
                }
                elseif($friday == 4){
                    $lecturer_preferred_time->start_time = '16:00:00';
                    $lecturer_preferred_time->end_time = '19:00:00';
                }
                $lecturer_preferred_time->save();
            }
        }

        // redirect to lecturer preferred times index page

        toastr()->success('Lecturer preferred times created successfully');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(LecturerPreferredTime $lecturerPreferredTime)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LecturerPreferredTime $lecturerPreferredTime)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LecturerPreferredTime $lecturerPreferredTime)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $user = User::findOrFail($request->lecturer_id);
        $lecturer_preferred_times = $user->lecturer_preferred_times;
        foreach ($lecturer_preferred_times as $lecturer_preferred_time) {
            $lecturer_preferred_time->delete();
        }
        toastr()->success('Lecturer Preferences deleted successfully');
        return redirect()->back();
    }
}
