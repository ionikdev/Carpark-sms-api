<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carpark extends Model
{
    use HasFactory;
    protected $fillable = [
        'carpark_name',
        'address',
        'max_capacity',
    ];

    // Relationship
    public function spaces()
    {
        return $this->hasMany(Space::class);
    }
}
