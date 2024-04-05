<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $table = "departments";

    protected $primaryKey = "department_id";

    protected $fillable = [
        'name',
        'school_id',
        'hod_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id', 'school_id');
    }

    public function hod()
    {
        return $this->belongsTo(User::class, 'hod_id', 'user_id');
    }

    public function lecturers()
    {
        return $this->hasMany(SchoolLecturer::class, 'department_id', 'department_id');
    }

    public function units()
    {
        return $this->hasMany(Unit::class, 'department_id', 'department_id');
    }

    public function activeLecturers()
    {
        $units = $this->units()->get();
        $lecturers = collect();
        $unitLecturers = $units->map(function ($unit) {
            return $unit->unitAssignments()->get();
        });
        // group by lecturer_id
        $unitLecturers = $unitLecturers->flatten(1)->groupBy('lecturer_id');
        foreach ($unitLecturers as $lecturer) {
            $lecturers->push($lecturer->first()->lecturer()->get());
        }
        return $lecturers;
    }

    public function cohorts()
    {
        $units = $this->units()->get();
        $cohorts = collect();
        foreach ($units as $unit) {
            $cohorts = $cohorts->merge($unit->cohorts()->get());
        }
        return $cohorts;
    }

    public function programs()
    {
        $cohorts = $this->cohorts();
        $programs = collect();
        foreach ($cohorts as $cohort) {
            $programs->push($cohort->program()->get());
        }
        $programs = $programs->flatten(1)->unique('program_id');
        return $programs;
    }
}
