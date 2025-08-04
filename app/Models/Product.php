<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_line_id',
        'sub_category_id',
        'sku',
        'name',
        'price',
        'labor_cost',
        'hinge_type',
        'is_modifiable',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'labor_cost' => 'decimal:2',
        'is_modifiable' => 'boolean',
    ];

    public function productLine()
    {
        return $this->belongsTo(ProductLine::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_category');
    }

    public function subCategories()
    {
        return $this->belongsToMany(SubCategory::class, 'product_sub_category');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Helper method to get the display name
    public function getDisplayNameAttribute()
    {
        return $this->name;
    }
}
