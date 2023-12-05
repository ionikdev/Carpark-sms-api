<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $table='status';
    protected $fillable = [
        'status',

    ];


    // Relationship
    public function spaces()
    {
        return $this->hasMany(Space::class, 'status_id');
    }
}
