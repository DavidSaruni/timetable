<?php

namespace App\Http\Controllers;

use App\Jobs\GenerateInstance;
use App\Models\School;
use App\Models\TimetableInstance;
use App\Models\UnitAssingment;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TimetableInstanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schools = School::all();
        $unitAssingments = UnitAssingment::all();
        $timetableInstances = TimetableInstance::latest()->get();
        return view('timetables.index')->with('instances', $timetableInstances)->with('schools', $schools)->with('unitAssingments', $unitAssingments);
    }

    public function myindex()
    {
        $schools = School::all();
        $unitAssingments = UnitAssingment::all();
        $timetableInstances = TimetableInstance::latest()->get();
        return view('timetables.myindex')->with('instances', $timetableInstances)->with('schools', $schools)->with('unitAssingments', $unitAssingments);
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
        $request->validate([
            'name' => 'required|string',
        ]);

        $timetableInstances = TimetableInstance::all();
        $i = 1;
        $instanceDbName = 'TT_Instance_' . $i;
        $instanceDbName = strtolower($instanceDbName);
        while (in_array($instanceDbName, $timetableInstances->pluck('table_prefix')->toArray())) {
            $i++;
            $instanceDbName = 'TT_Instance_' . $i;
            $instanceDbName = strtolower($instanceDbName);
        }
        $timetableInstance = new TimetableInstance();
        $timetableInstance->name = $request->name;
        $timetableInstance->table_prefix = $instanceDbName;
        $timetableInstance->save();
        dispatch(new GenerateInstance($timetableInstance));
        $migrate = $this->instanceMigration($instanceDbName);
        if($migrate == true){
            toastr()->success('Timetable instance created successfully');
        }else{
            $this->deleteMigratedInstance($instanceDbName);
            $timetableInstance->delete();
            toastr()->error('Timetable instance creation failed');
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show($timetableInstance)
    {
        $timetableInstance = TimetableInstance::where('timetable_instance_id', $timetableInstance)->first();
        return view('timetables.show')->with('instance', $timetableInstance);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TimetableInstance $timetableInstance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TimetableInstance $timetableInstance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $timetable_instance = TimetableInstance::find($request->timetable_instance_id);
        if(!$timetable_instance){
            toastr()->error('Timetable instance not found');
            return redirect()->back();
        }
        $instanceDbName = $timetable_instance->table_prefix;
        $this->deleteMigratedInstance($instanceDbName);
        $timetable_instance->delete();
        toastr()->success('Timetable instance deleted successfully');
        return redirect()->back();
    }

    public function instanceMigration($instanceDbName)
    {
        // Create table $instanceDbName_lecturers
        $lecturers = Schema::create($instanceDbName . '_lecturers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('title');
            $table->string('lecturer_name');
            $table->string('email');
            $table->timestamps();
        });
        // insert data into the above table from the lecturers_view
        $lecturers = DB::table('lecturers_view')->get();
        foreach ($lecturers as $lecturer) {
            DB::table($instanceDbName . '_lecturers')->insert([
                'user_id' => $lecturer->user_id,
                'title' => $lecturer->title,
                'lecturer_name' => $lecturer->lecturer_name,
                'email' => $lecturer->email,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create table $instanceDbName_programs
        $programs = Schema::create($instanceDbName . '_programs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('program_id');
            $table->string('program_name');
            $table->string('program_code');
            $table->integer('school_id');
            $table->timestamps();
        });
        // insert data into the above table from the programs_view
        $programs = DB::table('programs_view')->get();
        foreach ($programs as $program) {
            DB::table($instanceDbName . '_programs')->insert([
                'program_id' => $program->program_id,
                'program_name' => $program->program_name,
                'program_code' => $program->program_code,
                'school_id' => $program->school_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create table $instanceDbName_schools
        $schools = Schema::create($instanceDbName . '_schools', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('school_id');
            $table->string('school_name');
            $table->string('school_slug');
            $table->timestamps();
        });
        // insert data into the above table from the schools_view
        $schools = DB::table('schools_view')->get();
        foreach ($schools as $school) {
            DB::table($instanceDbName . '_schools')->insert([
                'school_id' => $school->school_id,
                'school_name' => $school->school_name,
                'school_slug' => $school->school_slug,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create table $instanceDbName_labs
        $labs = Schema::create($instanceDbName . '_labs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lab_id');
            $table->string('lab_name');
            $table->integer('lab_capacity');
            $table->integer('lab_type');
            $table->string('name');
            $table->integer('school_id');
            $table->timestamps();
        });
        // insert data into the above table from the labs_view
        $labs = DB::table('labs_view')->get();
        foreach ($labs as $lab) {
            DB::table($instanceDbName . '_labs')->insert([
                'lab_id' => $lab->lab_id,
                'lab_name' => $lab->lab_name,
                'lab_capacity' => $lab->lab_capacity,
                'lab_type' => $lab->lab_type,
                'name' => $lab->name,
                'school_id' => $lab->school_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create table $instanceDbName_groups
        $groups = Schema::create($instanceDbName . '_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('group_id');
            $table->string('group_name');
            $table->integer('student_count');
            $table->integer('cohort_id');
            $table->string('cohort_name');
            $table->integer('program_id');
            $table->integer('school_id');
            $table->string('acronym');
            $table->timestamps();
        });
        // insert data into the above table from the groups_view
        $groups = DB::table('groups_view')->get();
        foreach ($groups as $group) {
            DB::table($instanceDbName . '_groups')->insert([
                'group_id' => $group->group_id,
                'group_name' => $group->group_name,
                'student_count' => $group->student_count,
                'cohort_id' => $group->cohort_id,
                'cohort_name' => $group->cohort_name,
                'program_id' => $group->program_id,
                'school_id' => $group->school_id,
                'acronym' => $group->acronym,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create table $instanceDbName_lecturer_preferred_times
        $lecturerPreferences = Schema::create($instanceDbName . '_lecturer_preferred_times', function (Blueprint $table) {
            $table->increments('lecturer_preferred_time_id');
            $table->integer('lecturer_id');
            $table->string('day_of_week');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->timestamps();
        });
        // insert data into the above table from the lecturer_preferred_times table
        $lecturerPreferences = DB::table('lecturer_preferred_times')->get();
        foreach ($lecturerPreferences as $lecturerPreference) 
        {
            $daysOfWeek = [
                1 => 'Monday',
                2 => 'Tuesday',
                3 => 'Wednesday',
                4 => 'Thursday',
                5 => 'Friday',
            ];
            $day = $daysOfWeek[$lecturerPreference->day];
            DB::table($instanceDbName . '_lecturer_preferred_times')->insert([
                'lecturer_id' => $lecturerPreference->lecturer_id,
                'day_of_week' => $day,
                'start_time' => $lecturerPreference->start_time,
                'end_time' => $lecturerPreference->end_time,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create table $instanceDbName_unit_preferred_times
        $unitPreferences = Schema::create($instanceDbName . '_unit_preferred_times', function (Blueprint $table) {
            $table->increments('unit_preferred_time_id');
            $table->integer('unit_id');
            $table->string('day_of_week');
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();
        });
        // insert data into the above table from the unit_preferred_times_view
        $unitPreferences = DB::table('unit_preferred_times_view')->get();
        foreach ($unitPreferences as $unitPreference) {
            DB::table($instanceDbName . '_unit_preferred_times')->insert([
                'unit_id' => $unitPreference->unit_id,
                'day_of_week' => $unitPreference->day_of_week,
                'start_time' => $unitPreference->start_time,
                'end_time' => $unitPreference->end_time,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create table $instanceDbName_unit_preffered_rooms
        $unitPrefferedRooms = Schema::create($instanceDbName . '_unit_preffered_rooms', function (Blueprint $table) {
            $table->increments('unit_preffered_room_id');
            $table->integer('unit_id');
            $table->integer('lecture_room_id');
            $table->timestamps();
        });
        // insert data into the above table from the unit_preferred_rooms_view
        $unitPrefferedRooms = DB::table('unit_preferred_rooms_view')->get();
        foreach ($unitPrefferedRooms as $unitPrefferedRoom) {
            DB::table($instanceDbName . '_unit_preffered_rooms')->insert([
                'unit_id' => $unitPrefferedRoom->unit_id,
                'lecture_room_id' => $unitPrefferedRoom->lecture_room_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create table $instanceDbName_unit_preffered_labs
        $unitPrefferedLabs = Schema::create($instanceDbName . '_unit_preffered_labs', function (Blueprint $table) {
            $table->increments('unit_preffered_lab_id');
            $table->integer('unit_id');
            $table->integer('lab_id');
            $table->timestamps();
        });
        // insert data into the above table from the unit_preferred_labs_view
        $unitPrefferedLabs = DB::table('unit_preferred_labs_view')->get();
        foreach ($unitPrefferedLabs as $unitPrefferedLab) {
            DB::table($instanceDbName . '_unit_preffered_labs')->insert([
                'unit_id' => $unitPrefferedLab->unit_id,
                'lab_id' => $unitPrefferedLab->lab_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create table $instanceDbName_lecturerooms
        $lectureRooms = Schema::create($instanceDbName . '_lecturerooms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lecture_room_id');
            $table->string('lecture_room_name');
            $table->integer('lecture_room_capacity');
            $table->string('name');
            $table->integer('school_id');
            $table->timestamps();
        });
        // insert data into the above table from the lecturerooms_view
        $lectureRooms = DB::table('lecturerooms_view')->get();
        foreach ($lectureRooms as $lectureRoom) {
            DB::table($instanceDbName . '_lecturerooms')->insert([
                'lecture_room_id' => $lectureRoom->lecture_room_id,
                'lecture_room_name' => $lectureRoom->lecture_room_name,
                'lecture_room_capacity' => $lectureRoom->lecture_room_capacity,
                'name' => $lectureRoom->name,
                'school_id' => $lectureRoom->school_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create table $instanceDbName_locations
        $locations = Schema::create($instanceDbName . '_locations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('full_day_location_id');
            $table->string('name');
            $table->string('day');
            $table->integer('cohort_id')->nullable();
            $table->integer('school_id');
            $table->timestamps();
        });
        // insert data into the above table from the locations_view
        $locations = DB::table('locations_view')->get();
        foreach ($locations as $location) {
            $cohorts = $location->cohorts;
            // insert rows equal to the number of cohorts
            for ($i = 0; $i < $cohorts; $i++) {
                // separate the days into an array, and for each day, insert a row into the table
                $days = json_decode($location->days);
                $days = json_decode($days);
                foreach ($days as $day) {
                    DB::table($instanceDbName . '_locations')->insert([
                        'full_day_location_id' => $location->full_day_location_id,
                        'name' => $location->name,
                        'day' => $day,
                        'school_id' => $location->school_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        // Create table $instanceDbName_sessions
        $sessions = Schema::create($instanceDbName . '_sessions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('unit_assingment_id');
            $table->integer('unit_id');
            $table->string('unit_name');
            $table->string('unit_code');
            $table->integer('department_id');
            $table->boolean('is_lab');
            $table->integer('labtype_id')->nullable();
            $table->boolean('lab_alternative')->nullable();
            $table->integer('lecturer_hours');
            $table->integer('lab_hours')->nullable();
            $table->boolean('is_full_day');
            $table->integer('lecturer_id')->nullable();
            $table->integer('cohort_id');
            $table->string('cohort_name');
            $table->string('cohort_code');
            $table->integer('program_id');
            $table->integer('group_id');
            $table->string('group_name');
            $table->integer('student_count');
            $table->boolean('is_assigned')->default(0);
            $table->timestamps();
        });
        // insert data into the above table from the sessions_view
        $sessions = DB::table('sessions_view')->get();
        foreach ($sessions as $session) {
            if ($session->has_lab == 1) {
                DB::table($instanceDbName . '_sessions')->insert([
                    'unit_assingment_id' => $session->unit_assingment_id,
                    'unit_id' => $session->unit_id,
                    'unit_name' => $session->unit_name,
                    'unit_code' => $session->unit_code,
                    'department_id' => $session->department_id,
                    'is_lab' => 0,
                    'labtype_id' => $session->labtype_id,
                    'lab_alternative' => $session->lab_alternative,
                    'lecturer_hours' => $session->lecturer_hours,
                    'lab_hours' => $session->lab_hours,
                    'is_full_day' => $session->is_full_day,
                    'lecturer_id' => $session->lecturer_id,
                    'cohort_id' => $session->cohort_id,
                    'cohort_name' => $session->cohort_name,
                    'cohort_code' => $session->cohort_code,
                    'program_id' => $session->program_id,
                    'group_id' => $session->group_id,
                    'group_name' => $session->group_name,
                    'student_count' => $session->student_count,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                DB::table($instanceDbName . '_sessions')->insert([
                    'unit_assingment_id' => $session->unit_assingment_id,
                    'unit_id' => $session->unit_id,
                    'unit_name' => $session->unit_name,
                    'unit_code' => $session->unit_code,
                    'department_id' => $session->department_id,
                    'is_lab' => 1,
                    'labtype_id' => $session->labtype_id,
                    'lab_alternative' => $session->lab_alternative,
                    'lecturer_hours' => 0,
                    'lab_hours' => $session->lab_hours,
                    'is_full_day' => 0,
                    'lecturer_id' => $session->lecturer_id,
                    'cohort_id' => $session->cohort_id,
                    'cohort_name' => $session->cohort_name,
                    'cohort_code' => $session->cohort_code,
                    'program_id' => $session->program_id,
                    'group_id' => $session->group_id,
                    'group_name' => $session->group_name,
                    'student_count' => $session->student_count,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } 
            else {
                DB::table($instanceDbName . '_sessions')->insert([
                    'unit_assingment_id' => $session->unit_assingment_id,
                    'unit_id' => $session->unit_id,
                    'unit_name' => $session->unit_name,
                    'unit_code' => $session->unit_code,
                    'department_id' => $session->department_id,
                    'is_lab' => 0,
                    'labtype_id' => $session->labtype_id,
                    'lab_alternative' => $session->lab_alternative,
                    'lecturer_hours' => $session->lecturer_hours,
                    'lab_hours' => $session->lab_hours,
                    'is_full_day' => $session->is_full_day,
                    'lecturer_id' => $session->lecturer_id,
                    'cohort_id' => $session->cohort_id,
                    'cohort_name' => $session->cohort_name,
                    'cohort_code' => $session->cohort_code,
                    'program_id' => $session->program_id,
                    'group_id' => $session->group_id,
                    'group_name' => $session->group_name,
                    'student_count' => $session->student_count,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        return true;
    }

    public function deleteMigratedInstance($instanceDbName)
    {
        Schema::dropIfExists($instanceDbName . '_lecturers');
        Schema::dropIfExists($instanceDbName . '_programs');
        Schema::dropIfExists($instanceDbName . '_schools');
        Schema::dropIfExists($instanceDbName . '_labs');
        Schema::dropIfExists($instanceDbName . '_lecturerooms');
        Schema::dropIfExists($instanceDbName . '_locations');
        Schema::dropIfExists($instanceDbName . '_sessions');
        Schema::dropIfExists($instanceDbName . '_groups');
        Schema::dropIfExists($instanceDbName . '_group_schema');
        Schema::dropIfExists($instanceDbName . '_lecturer_preferred_times');
        Schema::dropIfExists($instanceDbName . '_unit_preferred_times');
        Schema::dropIfExists($instanceDbName . '_unit_preffered_rooms');
        Schema::dropIfExists($instanceDbName . '_unit_preffered_labs');

        return true;
    }

    public function timetableRow(Request $request)
    {
        $id = $request->id;
        $timetableInstance = TimetableInstance::where('timetable_instance_id', $id)->first();
        return response()->json($timetableInstance);
    }
}
