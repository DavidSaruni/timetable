<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public const ROLE_USER = 'USER';
    public const ROLE_ADMIN = 'ADMIN';
    public const ROLE_LECTURER = 'LECTURER';
    public const ROLE_HEAD_OF_DEPARTMENT = 'HEAD OF DEPARTMENT';
    public const ROLE_DEAN = 'DEAN';

    protected $table = 'users';

    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Always encrypt the password when it is updated.
     *
     * @param $value
    * @return string
    */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * Get the school that the user is dean of.
     */
    public function deanOf()
    {
        return $this->hasOne(School::class, 'dean_id', 'user_id');
    }

    /**
     * Get the school that the user is head of department of.
     */
    public function headOfDepartmentOf()
    {
        return $this->hasOne(Department::class, 'hod_id', 'user_id');
    }

    public function isDean()
    {
        return $this->role === self::ROLE_DEAN;
    }

    public function isHeadOfDepartment()
    {
        return $this->role === self::ROLE_HEAD_OF_DEPARTMENT;
    }

    public function isLecturer()
    {
        return $this->role === self::ROLE_LECTURER;
    }

    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isUser()
    {
        return $this->role === self::ROLE_USER;
    }

    /**
     * Get the users with the role of lecturer.
     */
    public static function getLecturers()
    {
        return User::where('role', self::ROLE_LECTURER)->get();
    }

    /**
     * Get the users with the role of head of department.
     */
    public static function getHeadsOfDepartment()
    {
        return User::where('role', self::ROLE_HEAD_OF_DEPARTMENT)->get();
    }

    /**
     * Get the users with the role of dean.
     */
    public static function getDeans()
    {
        return User::where('role', self::ROLE_DEAN)->get();
    }

    /**
     * Get the users with the role of admin.
     */
    public static function getAdmins()
    {
        return User::where('role', self::ROLE_ADMIN)->get();
    }

    /**
     * Get the users with the role of user.
     */
    public static function getUsers()
    {
        return User::where('role', self::ROLE_USER)->get();
    }

    public function schools()
    {
        return $this->belongsToMany(School::class, 'school_lecturers', 'lecturer_id', 'school_id');
    }

    public function units()
    {
        return $this->belongsToMany(Unit::class, 'unit_lecturers', 'lecturer_id', 'unit_id');
    }

    public function unitsAssigned()
    {
        return $this->belongsToMany(Unit::class, 'unit_assingments', 'lecturer_id', 'unit_id');
    }

    public function lecturer_preferred_times()
    {
        return $this->hasMany(LecturerPreferredTime::class, 'lecturer_id', 'user_id');
    }

    public function lecturers_with_preferred_times()
    {
        return $this->hasMany(LecturerPreferredTime::class, 'lecturer_id', 'user_id');
    }

    public function preferences()
    {
        $user = $this;
        $preferences = collect();
        $days = $user->lecturers_with_preferred_times->groupBy('day');
        foreach($days as $day => $times)
        {
            $dayNames = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
            $day = $dayNames[$day - 1] ?? $day;
            $count  = $times->count();
            $i = 0;
            $start_time = $times[$i]->start_time;
            $end_time = $times[$i]->end_time;
            $time = $day . '; ' . date('H:i', strtotime($start_time));
            if($count == 1)
            {
                $time .= ' - ' . date('H:i', strtotime($end_time));
            }
            else
            {
                $next_start_time_a = $times[$i + 1]->start_time;
                $next_end_time_a = $times[$i + 1]->end_time;
                if($count == 2)
                {
                    if($next_start_time_a == $end_time)
                    {
                        if($next_end_time_a > $end_time)
                        {
                            $end_time = $next_end_time_a;
                        }
                        $time .= ' - ' . date('H:i', strtotime($end_time));
                    }
                    elseif($next_start_time_a > $end_time)
                    {
                        $time .= ' - ' . date('H:i', strtotime($end_time)) . ', ' . date('H:i', strtotime($next_start_time_a)) . ' - ' . date('H:i', strtotime($next_end_time_a));
                    }
                }
                else
                {
                    $next_start_time_b = $times[$i + 2]->start_time;
                    $next_end_time_b = $times[$i + 2]->end_time;
                    if($count == 3)
                    {
                        if($next_start_time_a == $end_time)
                        {
                            if($next_end_time_a > $end_time)
                            {
                                $end_time = $next_end_time_a;
                                if($next_start_time_b == $end_time)
                                {
                                    if($next_end_time_b > $end_time)
                                    {
                                        $end_time = $next_end_time_b;
                                    }
                                    $time .= ' - ' . date('H:i', strtotime($end_time));
                                }
                                elseif($next_start_time_b > $end_time)
                                {
                                    $time .= ' - ' . date('H:i', strtotime($end_time)) . ', ' . date('H:i', strtotime($next_start_time_b)) . ' - ' . date('H:i', strtotime($next_end_time_b));
                                }
                            }
                        }
                        elseif($next_start_time_a > $end_time)
                        {
                            $time .= ' - ' . date('H:i', strtotime($end_time)) . ', ' . date('H:i', strtotime($next_start_time_a));
                            $end_time = $next_end_time_a;
                            if($next_start_time_b == $end_time)
                            {
                                if($next_end_time_b > $end_time)
                                {
                                    $end_time = $next_end_time_b;
                                }
                                $time .= ' - ' . date('H:i', strtotime($end_time));
                            }
                            elseif($next_start_time_b > $end_time)
                            {
                                $time .= ' - ' . date('H:i', strtotime($end_time)) . ', ' . date('H:i', strtotime($next_start_time_b)) . ' - ' . date('H:i', strtotime($next_end_time_b));
                            }
                        }
                    }
                    else
                    {
                        $next_start_time_c = $times[$i + 3]->start_time;
                        $next_end_time_c = $times[$i + 3]->end_time;
                        if($next_start_time_a == $end_time)
                        {
                            $end_time = $next_end_time_a;
                            if($next_start_time_b == $end_time)
                            {
                                $end_time = $next_end_time_b;
                                if($next_start_time_c == $end_time)
                                {
                                    $end_time = $next_end_time_c;
                                    $time .= ' - ' . date('H:i', strtotime($end_time));
                                }
                                elseif($next_start_time_c > $end_time)
                                {
                                    $time .= ' - ' . date('H:i', strtotime($end_time)) . ', ' . date('H:i', strtotime($next_start_time_c)) . ' - ' . date('H:i', strtotime($next_end_time_c));
                                }
                            }
                            elseif($next_start_time_b > $end_time)
                            {
                                $time .= ' - ' . $end_time . ', ' . $next_start_time_b;
                                $end_time = $next_end_time_b;
                                if($next_start_time_c == $end_time)
                                {
                                    $end_time = $next_end_time_c;
                                    $time .= ' - ' . date('H:i', strtotime($end_time));
                                }
                                elseif($next_start_time_c > $end_time)
                                {
                                    $time .= ' - ' . date('H:i', strtotime($end_time)) . ', ' . date('H:i', strtotime($next_start_time_c)) . ' - ' . date('H:i', strtotime($next_end_time_c));
                                }
                            }
                        }
                        elseif($next_start_time_a > $end_time)
                        {
                            $time .= ' - ' . date('H:i', strtotime($end_time)) . ', ' . date('H:i', strtotime($next_start_time_a));
                            $end_time = $next_end_time_a;
                            if($next_start_time_b == $end_time)
                            {
                                $end_time = $next_end_time_b;
                                if($next_start_time_c == $end_time)
                                {
                                    $end_time = $next_end_time_c;
                                    $time .= ' - ' . date('H:i', strtotime($end_time));
                                }
                                elseif($next_start_time_c > $end_time)
                                {
                                    $time .= ' - ' . date('H:i', strtotime($end_time)) . ', ' . date('H:i', strtotime($next_start_time_c)) . ' - ' . date('H:i', strtotime($next_end_time_c));
                                }
                            }
                            elseif($next_start_time_b > $end_time)
                            {
                                $time .= ' - ' . date('H:i', strtotime($end_time)) . ', ' . date('H:i', strtotime($next_start_time_b));
                                $end_time = $next_end_time_b;
                                if($next_start_time_c == $end_time)
                                {
                                    $end_time = $next_end_time_c;
                                    $time .= ' - ' . date('H:i', strtotime($end_time));
                                }
                                elseif($next_start_time_c > $end_time)
                                {
                                    $time .= ' - ' . date('H:i', strtotime($end_time)) . ', ' . date('H:i', strtotime($next_start_time_c)) . ' - ' . date('H:i', strtotime($next_end_time_c));
                                }
                            }
                        }
                    }
                }
                }
            $preferences->push($time);
        }
        return $preferences;
    }
}
