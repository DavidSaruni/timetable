<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolFullDayLocation extends Model
{
    use HasFactory;

    protected $table = 'school_full_day_locations';

    protected $primaryKey = 'school_full_day_location_id';

    protected $fillable = [
        'school_id',
        'full_day_location_id',
    ];

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id', 'school_id');
    }

    public function fullDayLocation()
    {
        return $this->belongsTo(FullDayLocation::class, 'full_day_location_id', 'full_day_location_id');
    }
}
