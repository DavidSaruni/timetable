<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
    use HasFactory;

    public const ROLE_LECTURER = 'LECTURER';

    // lecturers are users with the role of lecturer. Let this model return only those users.
    protected static function booted()
    {
        static::addGlobalScope('role', function ($query) {
            $query->where('role', '!=', 'ADMIN')->where('role', '!=', 'USER');
        });
    }

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
     * Get the users with the role of lecturer.
     */
    public static function lecturers()
    {
        return User::where('role', self::ROLE_LECTURER)->get();
    }

    public function schools()
    {
        return $this->belongsToMany(School::class, 'school_lecturers', 'user_id', 'school_id');
    }
}
