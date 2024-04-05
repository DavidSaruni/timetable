<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $table = "units";

    protected $primaryKey = "unit_id";

    protected $fillable = [
        'name',
        'code',
        'department_id',
        'has_lab',
        'labtype_id',
        'lab_alternative',
        'lecturer_hours',
        'lab_hours',
        'is_full_day',
        'is_common',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }

    public function school()
    {
        return $this->hasOneThrough(School::class, Department::class, 'department_id', 'school_id', 'department_id', 'school_id');
    }

    public function labtype()
    {
        return $this->belongsTo(Labtype::class, 'labtype_id', 'labtype_id');
    }

    public function unitAssignments()
    {
        return $this->hasMany(UnitAssingment::class, 'unit_id', 'unit_id');
    }

    public function cohorts()
    {
        return $this->hasManyThrough(Cohort::class, UnitAssingment::class, 'unit_id', 'cohort_id', 'unit_id', 'cohort_id')->distinct();
    }

    public function lecturers()
    {
        return $this->hasManyThrough(Lecturer::class, UnitAssingment::class, 'unit_id', 'user_id', 'unit_id', 'lecturer_id')->distinct();
    }

    public function unit_preference()
    {
        return $this->hasOne(UnitPreference::class, 'unit_id', 'unit_id');
    }

    public function unit_preferred_rooms()
    {
        return $this->hasManyThrough(UnitPreferredRoom::class, UnitPreference::class, 'unit_id', 'unit_preference_id', 'unit_id', 'unit_preference_id');
    }

    public function unit_preferred_labs()
    {
        return $this->hasManyThrough(UnitPreferredLab::class, UnitPreference::class, 'unit_id', 'unit_preference_id', 'unit_id', 'unit_preference_id');
    }

    public function unit_preferred_times()
    {
        return $this->hasManyThrough(UnitPreferredPeriod::class, UnitPreference::class, 'unit_id', 'unit_preference_id', 'unit_id', 'unit_preference_id');
    }

    public function prefTimesAttribute()
    {
        $unit = $this;
        $unit_preferred_times = $unit->unit_preferred_times;
        $school = $unit->school;
        $school_periods = $school->schoolPeriods;
        $prefTimes = collect();
        foreach ($unit_preferred_times as $unit_preferred_time)
        {
            $school_period = $school_periods->where('school_period_id', $unit_preferred_time->school_period_id)->first();
            $prefTimes->push($school_period);
        }
        $prefTimes = $prefTimes->groupBy('day_of_week');
        return $prefTimes;
    }

    public function prefLocationsAttribute()
    {
        $unit = $this;
        $unit_preferred_rooms = $unit->unit_preferred_rooms;
        $unit_preferred_labs = $unit->unit_preferred_labs;
        $prefLocations = collect();
        $prefLocations->push($unit_preferred_rooms);
        $prefLocations->push($unit_preferred_labs);
        $prefLocations = $prefLocations->flatten();
        $locations = collect();
        foreach ($prefLocations as $prefLocation)
        {
            if ($prefLocation->lecture_room_id)
            {
                $created_at = $prefLocation->lectureRoom->created_at;
                $room = $prefLocation->lectureRoom->lecture_room_name;
                $building = $prefLocation->lectureRoom->building->name;
                $locations->push([
                    'created_at' => $created_at,
                    'room' => $room,
                    'building' => $building,
                ]);
            }
            elseif ($prefLocation->lab_id)
            {
                $created_at = $prefLocation->lab->created_at;
                $room = $prefLocation->lab->lab_name;
                $building = $prefLocation->lab->building->name;
                $locations->push([
                    'created_at' => $created_at,
                    'room' => $room,
                    'building' => $building,
                ]);
            }
        }
        $locations = $locations->groupBy('building')->sortBy('created_at');
        return $locations;
    }
}
