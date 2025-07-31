<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductLine extends Model
{
    use HasFactory;

    protected $fillable = [
        'door_style_id',
        'door_color_id',
    ];

    public function doorStyle()
    {
        return $this->belongsTo(DoorStyle::class);
    }

    public function doorColor()
    {
        return $this->belongsTo(DoorColor::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_line_category');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Helper method to get the display name
    public function getDisplayNameAttribute()
    {
        return $this->doorStyle->name . ' - ' . $this->doorColor->name;
    }
}
