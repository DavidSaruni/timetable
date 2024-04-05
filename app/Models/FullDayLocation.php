<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FullDayLocation extends Model
{
    use HasFactory;

    protected $table = 'full_day_locations';

    protected $primaryKey = 'full_day_location_id';

    protected $fillable = [
        'name',
        'days',
        'cohorts',
    ];

    protected $casts = [
        'days' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function schoolFullDayLocations()
    {
        return $this->hasMany(SchoolFullDayLocation::class, 'full_day_location_id', 'full_day_location_id');
    }

    public function schools()
    {
        return $this->belongsToMany(School::class, 'school_full_day_locations', 'full_day_location_id', 'school_id');
    }
}
