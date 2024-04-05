<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LectureRoom extends Model
{
    use HasFactory;

    protected $table = 'lecture_rooms';

    protected $primaryKey = 'lecture_room_id';

    protected $fillable = [
        'lecture_room_id',
        'lecture_room_name',
        'building_id',
        'lecture_room_capacity',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function building()
    {
        return $this->belongsTo(Building::class, 'building_id', 'building_id');
    }
}
