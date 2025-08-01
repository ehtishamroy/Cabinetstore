<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoorStyle extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
    ];

    public function productLines()
    {
        return $this->hasMany(ProductLine::class);
    }
}
