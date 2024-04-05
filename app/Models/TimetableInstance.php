<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TimetableInstance extends Model
{
    use HasFactory;

    protected $table = 'timetable_instances';

    protected $primaryKey = 'timetable_instance_id';

    protected $fillable = [
        'timetable_instance_id',
        'name',
        'status',
        'table_prefix',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function schools()
    {
        $table = $this->table_prefix.'_schools';
        $schools = DB::table($table)->get();
        return $schools;
    }

    public function myTimetable($user_id)
    {
        $table = $this->table_prefix.'_lecturers';
        $timetable = DB::table($table)->where('user_id', $user_id)->first();
        return $timetable;
    }

    public function groups()
    {
        $table = $this->table_prefix.'_groups';
        $groups = DB::table($table)->get();
        return $groups;
    }

    public function unassignedUnits()
    {
        $table = $this->table_prefix.'_units';
        $units = DB::table($table)->where('group_id', null)->get();
        return $units;
    }

    public function freeSessions($group_id)
    {
        $table = $this->table_prefix.'_group_schema';
        $sessions = DB::table($table)->where('session_id', null)->where('group_id', $group_id)->get();
        return $sessions;
    }
    
    public function assignedUnits($group_id)
    {
        $table = $this->table_prefix.'_units';
        $units = DB::table($table)->where('group_id', $group_id)->get();
        return $units;
    }

    public function assignedSessions($group_id)
    {
        $table = $this->table_prefix.'_group_schema';
        $sessions = DB::table($table)->where('status', 1)->where('group_id', $group_id)->get();
        return $sessions;
    }

    public function unAssignedSessions($group_id)
    {
        $table = $this->table_prefix.'_sessions';
        $sessions = DB::table($table)->where('is_assigned', 0)->where('group_id', $group_id)->get();
        return $sessions;
    }

    public function requiredSessions($group_id)
    {
        $table = $this->table_prefix.'_sessions';
        $sessions = DB::table($table)->where('group_id', $group_id)->get();
        return $sessions;
    }

    public function sessionsWithUnitPrefTimes()
    {
        $unitPrefTimes = DB::select("
            SELECT ".$this->table_prefix."_sessions . * FROM ".$this->table_prefix."_unit_preferred_times
            INNER JOIN ".$this->table_prefix."_sessions
            ON ".$this->table_prefix."_sessions.unit_id = ".$this->table_prefix."_unit_preferred_times.unit_id
            GROUP BY ".
                $this->table_prefix."_sessions.id, ".
                $this->table_prefix."_sessions.unit_assingment_id, ".
                $this->table_prefix."_sessions.unit_id, ".
                $this->table_prefix."_sessions.unit_name, ".
                $this->table_prefix."_sessions.unit_code, ".
                $this->table_prefix."_sessions.department_id, ".
                $this->table_prefix."_sessions.is_lab, ".
                $this->table_prefix."_sessions.labtype_id, ".
                $this->table_prefix."_sessions.lab_alternative, ".
                $this->table_prefix."_sessions.lecturer_hours, ".
                $this->table_prefix."_sessions.lab_hours, ".
                $this->table_prefix."_sessions.is_full_day, ".
                $this->table_prefix."_sessions.lecturer_id, ".
                $this->table_prefix."_sessions.cohort_id, ".
                $this->table_prefix."_sessions.cohort_name, ".
                $this->table_prefix."_sessions.cohort_code, ".
                $this->table_prefix."_sessions.program_id, ".
                $this->table_prefix."_sessions.group_id, ".
                $this->table_prefix."_sessions.group_name, ".
                $this->table_prefix."_sessions.student_count, ".
                $this->table_prefix."_sessions.is_assigned, ".
                $this->table_prefix."_sessions.created_at, ".
                $this->table_prefix."_sessions.updated_at
            "
        );
        return $unitPrefTimes;
    }

    public function sessionsWithUnitPrefRooms()
    {
        $unitPrefRooms = DB::select("
            SELECT ".$this->table_prefix."_sessions . * FROM ".$this->table_prefix."_unit_preffered_rooms
            INNER JOIN ".$this->table_prefix."_sessions
            ON ".$this->table_prefix."_sessions.unit_id = ".$this->table_prefix."_unit_preffered_rooms.unit_id
            GROUP BY ".
                $this->table_prefix."_sessions.id, ".
                $this->table_prefix."_sessions.unit_assingment_id, ".
                $this->table_prefix."_sessions.unit_id, ".
                $this->table_prefix."_sessions.unit_name, ".
                $this->table_prefix."_sessions.unit_code, ".
                $this->table_prefix."_sessions.department_id, ".
                $this->table_prefix."_sessions.is_lab, ".
                $this->table_prefix."_sessions.labtype_id, ".
                $this->table_prefix."_sessions.lab_alternative, ".
                $this->table_prefix."_sessions.lecturer_hours, ".
                $this->table_prefix."_sessions.lab_hours, ".
                $this->table_prefix."_sessions.is_full_day, ".
                $this->table_prefix."_sessions.lecturer_id, ".
                $this->table_prefix."_sessions.cohort_id, ".
                $this->table_prefix."_sessions.cohort_name, ".
                $this->table_prefix."_sessions.cohort_code, ".
                $this->table_prefix."_sessions.program_id, ".
                $this->table_prefix."_sessions.group_id, ".
                $this->table_prefix."_sessions.group_name, ".
                $this->table_prefix."_sessions.student_count, ".
                $this->table_prefix."_sessions.is_assigned, ".
                $this->table_prefix."_sessions.created_at, ".
                $this->table_prefix."_sessions.updated_at
            "
        );
        return $unitPrefRooms;
    }

    public function sessionsWithUnitPrefLabs()
    {
        $unitPrefLabs = DB::select("
            SELECT ".$this->table_prefix."_sessions . * FROM ".$this->table_prefix."_unit_preffered_labs
            INNER JOIN ".$this->table_prefix."_sessions
            ON ".$this->table_prefix."_sessions.unit_id = ".$this->table_prefix."_unit_preffered_labs.unit_id
            GROUP BY ".
                $this->table_prefix."_sessions.id, ".
                $this->table_prefix."_sessions.unit_assingment_id, ".
                $this->table_prefix."_sessions.unit_id, ".
                $this->table_prefix."_sessions.unit_name, ".
                $this->table_prefix."_sessions.unit_code, ".
                $this->table_prefix."_sessions.department_id, ".
                $this->table_prefix."_sessions.is_lab, ".
                $this->table_prefix."_sessions.labtype_id, ".
                $this->table_prefix."_sessions.lab_alternative, ".
                $this->table_prefix."_sessions.lecturer_hours, ".
                $this->table_prefix."_sessions.lab_hours, ".
                $this->table_prefix."_sessions.is_full_day, ".
                $this->table_prefix."_sessions.lecturer_id, ".
                $this->table_prefix."_sessions.cohort_id, ".
                $this->table_prefix."_sessions.cohort_name, ".
                $this->table_prefix."_sessions.cohort_code, ".
                $this->table_prefix."_sessions.program_id, ".
                $this->table_prefix."_sessions.group_id, ".
                $this->table_prefix."_sessions.group_name, ".
                $this->table_prefix."_sessions.student_count, ".
                $this->table_prefix."_sessions.is_assigned, ".
                $this->table_prefix."_sessions.created_at, ".
                $this->table_prefix."_sessions.updated_at
            "
        );
        return $unitPrefLabs;
    }

    public function sessionsWithLecPrefTimes()
    {
        $lecPrefTimes = DB::select("
            SELECT ".$this->table_prefix."_sessions . * FROM ".$this->table_prefix."_lecturer_preferred_times
            INNER JOIN ".$this->table_prefix."_sessions
            ON ".$this->table_prefix."_sessions.lecturer_id = ".$this->table_prefix."_lecturer_preferred_times.lecturer_id
            GROUP BY ".
                $this->table_prefix."_sessions.id, ".
                $this->table_prefix."_sessions.unit_assingment_id, ".
                $this->table_prefix."_sessions.unit_id, ".
                $this->table_prefix."_sessions.unit_name, ".
                $this->table_prefix."_sessions.unit_code, ".
                $this->table_prefix."_sessions.department_id, ".
                $this->table_prefix."_sessions.is_lab, ".
                $this->table_prefix."_sessions.labtype_id, ".
                $this->table_prefix."_sessions.lab_alternative, ".
                $this->table_prefix."_sessions.lecturer_hours, ".
                $this->table_prefix."_sessions.lab_hours, ".
                $this->table_prefix."_sessions.is_full_day, ".
                $this->table_prefix."_sessions.lecturer_id, ".
                $this->table_prefix."_sessions.cohort_id, ".
                $this->table_prefix."_sessions.cohort_name, ".
                $this->table_prefix."_sessions.cohort_code, ".
                $this->table_prefix."_sessions.program_id, ".
                $this->table_prefix."_sessions.group_id, ".
                $this->table_prefix."_sessions.group_name, ".
                $this->table_prefix."_sessions.student_count, ".
                $this->table_prefix."_sessions.is_assigned, ".
                $this->table_prefix."_sessions.created_at, ".
                $this->table_prefix."_sessions.updated_at
        ");
        return $lecPrefTimes;
    }

    public function fullDaySessions()
    {
        $fullDaySessions = DB::table($this->table_prefix.'_sessions')->where('is_full_day', 1)->where('is_assigned', 0)->get();
        return $fullDaySessions;
    }

    public function sessionsWithPrefs()
    {
        $unitPrefTimes = $this->sessionsWithUnitPrefTimes();
        $unitPrefRooms = $this->sessionsWithUnitPrefRooms();
        $unitPrefLabs = $this->sessionsWithUnitPrefLabs();
        $lecPrefTimes = $this->sessionsWithLecPrefTimes();
        $sessionsWithPrefs = array_merge($unitPrefTimes, $unitPrefRooms, $unitPrefLabs, $lecPrefTimes);
        $sessionsWithPrefs = array_unique($sessionsWithPrefs, SORT_REGULAR);
        shuffle($sessionsWithPrefs);
        return $sessionsWithPrefs;
    }

    public function sessionsWithoutPrefs()
    {
        $sessionsWithPrefs = $this->sessionsWithPrefs();
        $sessions = DB::table($this->table_prefix.'_sessions')->get();
        $sessionsWithoutPrefs = array();
        foreach ($sessions as $session)
        {
            if (!in_array($session, $sessionsWithPrefs))
            {
                array_push($sessionsWithoutPrefs, $session);
            }
        }
        shuffle($sessionsWithoutPrefs);
        return $sessionsWithoutPrefs;
    }

    public function sessionsGreaterThan3Hours()
    {
        $sessions = DB::table($this->table_prefix.'_sessions')->where('lab_hours', '>', 3)->where('is_assigned', 0)->get();
        return $sessions;
    }
}
