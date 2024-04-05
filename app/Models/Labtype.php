<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Labtype extends Model
{
    use HasFactory;

    protected $table = "labtypes";

    protected $primaryKey = "labtype_id";

    protected $fillable = [
        'type',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function labs()
    {
        return $this->hasMany(Lab::class, 'lab_type', 'labtype_id');
    }

    public function units()
    {
        return $this->hasMany(Unit::class, 'labtype_id', 'labtype_id');
    }
}
