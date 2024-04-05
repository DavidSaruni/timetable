<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lab extends Model
{
    use HasFactory;

    protected $table = 'labs';

    protected $primaryKey = 'lab_id';

    protected $fillable = [
        'lab_id',
        'lab_name',
        'lab_type',
        'building_id',
        'lab_capacity',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function building()
    {
        return $this->belongsTo(Building::class, 'building_id', 'building_id');
    }

    public function labtype()
    {
        return $this->belongsTo(Labtype::class, 'lab_type', 'labtype_id');
    }
}
