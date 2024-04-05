<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'schools';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'school_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'school_id',
        'name',
        'slug',
        'dean_id',
    ];

    /**
     *  The casted attributes
     * 
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the dean that owns the school.
     */
    public function dean()
    {
        return $this->belongsTo(User::class, 'dean_id', 'user_id');
    }

    /**
     * Get the departments for the school.
     */
    public function departments()
    {
        return $this->hasMany(Department::class, 'school_id', 'school_id');
    }

    /**
     * Get the school buildings for the school.
     */
    public function schoolBuildings()
    {
        return $this->hasMany(SchoolBuilding::class, 'school_id', 'school_id');
    }

    /**
     * Get the buildings for the school.
     */
    public function buildings()
    {
        return $this->belongsToMany(Building::class, 'school_buildings', 'school_id', 'building_id');
    }

    /**
     * Get the full day locations for the school.
     */
    public function schoolFullDayLocations()
    {
        return $this->hasMany(SchoolFullDayLocation::class, 'school_id', 'school_id');
    }

    /**
     * Get the full day locations for the school.
     */
    public function fullDayLocations()
    {
        return $this->belongsToMany(FullDayLocation::class, 'school_full_day_locations', 'school_id', 'full_day_location_id');
    }

    /**
     * Get the school lecturers for the school.
     */
    public function schoolLecturers()
    {
        return $this->hasMany(SchoolLecturer::class, 'school_id', 'school_id');
    }

    /**
     * Get the lecturers for the school.
     */
    public function lecturers()
    {
        return $this->belongsToMany(User::class, 'school_lecturers', 'school_id', 'lecturer_id');
    }

    /**
     * Get the programs for the school.
     */
    public function programs()
    {
        return $this->hasMany(Program::class, 'school_id', 'school_id');
    }

    /**
     * Get the cohorts for the school.
     */
    public function cohorts()
    {
        return $this->hasManyThrough(Cohort::class, Program::class, 'school_id', 'program_id', 'school_id', 'program_id');
    }

    /**
     * Get the periods for the school.
     */
    public function schoolPeriods()
    {
        return $this->hasMany(SchoolPeriods::class, 'school_id', 'school_id');
    }

    /**
     * Get the start time for the first period of the day.
     */
    public function getStartTimeAttribute()
    {
        return $this->schoolPeriods()->orderBy('start_time', 'asc')->first()->start_time;
    }

    /**
     * Get the end time for the last period of the day.
     */
    public function getEndTimeAttribute()
    {
        return $this->schoolPeriods()->orderBy('end_time', 'desc')->first()->end_time;
    }

    /**
     * Get the number of hours in a day.
     */
    public function getHoursInDayAttribute()
    {
        $start_time = $this->getStartTimeAttribute();
        $start_time = strtotime($start_time);
        $end_time = $this->getEndTimeAttribute();
        $end_time = strtotime($end_time);
        $hours = ($end_time - $start_time) / 3600;
        return $hours;
    }

    /**
     * Get the number of periods in a day.
     */
    public function getPeriodsInDayAttribute()
    {
        $school_periods = $this->schoolPeriods;
        $periods = $school_periods->groupBy('day_of_week');
        // get the day with the most periods
        $periods = $periods->max()->count();
        return $periods;
    }
}
