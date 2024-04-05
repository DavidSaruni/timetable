<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Building;
use App\Models\FullDayLocation;
use App\Models\User;
use App\Models\School;
use App\Models\Program;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::all()->count();
        $schools = School::all()->count();
        $buildings = Building::all()->count();
        $fullDayLocations = FullDayLocation::all()->count();
        $programs = Program::all()->count();
        $latest_schools = School::latest()->get();
        $latest_buildings = Building::latest()->take(5)->get();
        $latest_locations = FullDayLocation::latest()->take(5)->get();
        $latest_programs = Program::latest()->get();
        if (auth()->user()->role == 'USER') {
            return view('dashboards.user.dashboard');
        } elseif (auth()->user()->role == 'ADMIN') {
            return view('dashboards.admin.dashboard')->with([
                'users' => $users,
                'schools' => $schools,
                'buildings' => $buildings,
                'fullDayLocations' => $fullDayLocations,
                'programs' => $programs,
                'latest_schools' => $latest_schools,
                'latest_buildings' => $latest_buildings,
                'latest_locations' => $latest_locations,
                'latest_programs' => $latest_programs,
            ]);
        } elseif (auth()->user()->role == 'LECTURER') {
            return view('dashboards.lecturer.dashboard');
        } elseif (auth()->user()->role == 'HEAD OF DEPARTMENT') {
            return view('dashboards.hod.dashboard');
        } elseif (auth()->user()->role == 'DEAN') {
            $school = auth()->user()->deanOf;
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
            return view('dashboards.dean.dashboard')->with([
                'school' => $school,
                'hods' => $hods,
                'buildings' => $buildings,
                'fullDayLocations' => $fullDayLocations,
                'lecturers' => $lecturers,
            ]);
        }
    }
}
