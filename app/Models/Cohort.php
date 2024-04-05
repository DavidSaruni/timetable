<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cohort extends Model
{
    use HasFactory;

    public const STATUS_INSESSION = 'INSESSION';
    public const STATUS_NOTINSESSION = 'NOTINSESSION';

    protected $table = "cohorts";

    protected $primaryKey = "cohort_id";

    protected $fillable = [
        'name',
        'code',
        'program_id',
        'student_count',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id', 'program_id');
    }

    public function groups()
    {
        return $this->hasMany(Group::class, 'cohort_id', 'cohort_id');
    }

    public function unitAssignments()
    {
        return $this->hasMany(UnitAssingment::class, 'cohort_id', 'cohort_id');
    }

    public function units()
    {
        $units = collect();
        foreach ($this->unitAssignments()->get() as $unitAssignment) {
            $units->push($unitAssignment->unit()->first());
        }
        $units = $units->unique('unit_id');
        return $units;
    }

    public function lecturers()
    {
        $lecturers = collect();
        foreach ($this->unitAssignments()->get() as $unitAssignment) {
            $lecturers->push($unitAssignment->lecturer()->first());
        }
        $lecturers = $lecturers->unique('user_id');
        return $lecturers;
    }
}
