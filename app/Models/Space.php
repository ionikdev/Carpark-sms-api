<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Space extends Model
{
    use HasFactory;
    protected $fillable = [
        'carpark_id',
        'space_name',
        'space_type',
        'amount',
        'status',

    ];

// Relationship
    public function carpark()
    {
        return $this->belongsTo(Carpark::class);
    }

    public function status()
    {
        return $this->belongsTo(SpaceStatus::class, 'status_id');
    }
}
