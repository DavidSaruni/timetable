<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitPreferredRoom extends Model
{
    use HasFactory;

    protected $table = 'unit_preferred_rooms';

    protected $primaryKey = 'unit_preferred_room_id';

    protected $fillable = [
        'unit_preference_id',
        'lecture_room_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function unit_preference()
    {
        return $this->belongsTo(UnitPreference::class, 'unit_preference_id', 'unit_preference_id');
    }

    public function lectureRoom()
    {
        return $this->belongsTo(LectureRoom::class, 'lecture_room_id', 'lecture_room_id');
    }

    public function unit()
    {
        return $this->hasOneThrough(Unit::class, UnitPreference::class, 'unit_preference_id', 'unit_id', 'unit_preference_id', 'unit_id');
    }
}
