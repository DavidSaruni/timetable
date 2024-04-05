<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitAssingment extends Model
{
    use HasFactory;

    protected $table = 'unit_assingments';

    protected $primaryKey = 'unit_assingment_id';

    protected $fillable = [
        'unit_id',
        'lecturer_id',
        'cohort_id',
        'is_common',
        'common_value',
        'group_size'
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'unit_id');
    }

    public function lecturer()
    {
        return $this->belongsTo(User::class, 'lecturer_id', 'user_id');
    }

    public function cohort()
    {
        return $this->belongsTo(Cohort::class, 'cohort_id', 'cohort_id');
    }

    // function to get all the unit assignments for units that have is_common set to true
    public static function getCommonUnitAssignments()
    {
        $commonUnits = CommonUnit::all();
        $unitAssignments = collect();
        foreach ($commonUnits as $commonUnit) {
            if ($commonUnit->unitAssignments->count() > 0) {
                foreach ($commonUnit->unitAssignments as $unitAssignment) {
                    $unitAssignments->push($unitAssignment);
                }
            }
        }
        return $unitAssignments;
    }
}
