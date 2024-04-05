<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitPreference extends Model
{
    use HasFactory;

    protected $table = 'unit_preferences';

    protected $primaryKey = 'unit_preference_id';

    protected $fillable = [
        'unit_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'unit_id');
    }

    public function unit_preferred_rooms()
    {
        return $this->hasMany(UnitPreferredRoom::class, 'unit_preference_id', 'unit_preference_id');
    }

    public function unit_preferred_times()
    {
        return $this->hasMany(UnitPreferredTime::class, 'unit_preference_id', 'unit_preference_id');
    }

    public function unit_preferred_labs()
    {
        return $this->hasMany(UnitPreferredLab::class, 'unit_preference_id', 'unit_preference_id');
    }
}
