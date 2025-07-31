<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoorColor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function productLines()
    {
        return $this->hasMany(ProductLine::class);
    }
}
