<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitPreferredLab extends Model
{
    use HasFactory;

    protected $table = 'unit_preferred_labs';

    protected $primaryKey = 'unit_preferred_lab_id';

    protected $fillable = [
        'unit_preference_id',
        'lab_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function unit_preference()
    {
        return $this->belongsTo(UnitPreference::class, 'unit_preference_id', 'unit_preference_id');
    }

    public function lab()
    {
        return $this->belongsTo(Lab::class, 'lab_id', 'lab_id');
    }

    public function unit()
    {
        return $this->hasOneThrough(Unit::class, UnitPreference::class, 'unit_preference_id', 'unit_id', 'unit_preference_id', 'unit_id');
    }
}
