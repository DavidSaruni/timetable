<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitPreferredPeriod extends Model
{
    use HasFactory;

    protected $table = 'unit_preferred_periods';

    protected $primaryKey = 'unit_preferred_period_id';

    protected $fillable = [
        'unit_preference_id',
        'school_period_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function unit_preference()
    {
        return $this->belongsTo(UnitPreference::class, 'unit_preference_id', 'unit_preference_id');
    }

    public function unit()
    {
        return $this->hasOneThrough(Unit::class, UnitPreference::class, 'unit_preference_id', 'unit_id', 'unit_preference_id', 'unit_id');
    }

    public function school_period()
    {
        return $this->belongsTo(SchoolPeriods::class, 'school_period_id', 'school_period_id');
    }
}
