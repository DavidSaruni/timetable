<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    use HasFactory;

    protected $table = "buildings";

    protected $primaryKey = "building_id";

    protected $fillable = [
        'name',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function labs()
    {
        return $this->hasMany(Lab::class, 'building_id', 'building_id');
    }

    public function lectureRooms()
    {
        return $this->hasMany(LectureRoom::class, 'building_id', 'building_id');
    }

    public function schoolBuildings()
    {
        return $this->hasMany(SchoolBuilding::class, 'building_id', 'building_id');
    }

    public function schools()
    {
        return $this->belongsToMany(School::class, 'school_buildings', 'building_id', 'school_id');
    }
}
