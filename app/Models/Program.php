<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $table = "programs";

    protected $primaryKey = "program_id";

    protected $fillable = [
        'name',
        'code',
        'academic_years',
        'semesters',
        'max_group_size',
        'school_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id', 'school_id');
    }

    public function cohorts()
    {
        return $this->hasMany(Cohort::class, 'program_id', 'program_id');
    }

    public function groups()
    {
        $cohorts = $this->cohorts()->get();
        $groups = collect();
        foreach ($cohorts as $cohort) {
            $groups = $groups->merge($cohort->groups()->get());
        }
        return $groups;
    }

    public function students()
    {
        $cohorts = $this->cohorts()->get();
        $students = 0;
        foreach ($cohorts as $cohort) {
            $students += $cohort->student_count;
        }
        return $students;
    }

    public function units()
    {
        $cohorts = $this->cohorts()->get();
        $units = collect();
        foreach ($cohorts as $cohort) {
            $units = $units->merge($cohort->unitAssignments()->get());
        }
        $units = $units->unique('unit_id');
        return $units;
    }

    public function lecturers()
    {
        $cohorts = $this->cohorts()->get();
        $lecturers = collect();
        foreach ($cohorts as $cohort) {
            $lecturers = $lecturers->merge($cohort->unitAssignments()->get());
        }
        $lecturers = $lecturers->unique('lecturer_id');
        return $lecturers;
    }
}
