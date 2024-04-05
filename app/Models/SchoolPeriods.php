<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolPeriods extends Model
{
    use HasFactory;

    protected $table = 'school_periods';

    protected $primaryKey = 'school_period_id';

    protected $fillable = [
        'day_of_week',
        'start_time',
        'end_time',
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

    public function unit_preferred_periods()
    {
        return $this->hasMany(UnitPreferredPeriod::class, 'school_period_id', 'school_period_id');
    }
}
