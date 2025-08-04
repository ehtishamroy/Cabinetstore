<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoorColor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
        'main_image',
        'gallery_images',
    ];

    protected $casts = [
        'gallery_images' => 'array',
    ];

    public function productLines()
    {
        return $this->hasMany(ProductLine::class);
    }
}
