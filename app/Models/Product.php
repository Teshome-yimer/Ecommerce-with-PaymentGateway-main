<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_category',
        'id_brand',
        'name',
        'slug',
        'images',
        'description',
        'price',
        'is_active',
        'is_featured',
        'in_stock',
        'on_sale',
    ];

    protected $casts = [
        'images' => 'array',
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'in_stock' => 'boolean',
        'on_sale' => 'boolean',
    ];

    public function category(){
        return $this->belongsTo(Category::class, 'id_category');
    }

    public function brand(){
        return $this->belongsTo(Brand::class, 'id_brand');
    }

    public function orderItems(){
        return $this->hasMany(OrderItem::class, 'id_product');
    }

    /**
     * Get the first image URL
     * Cloudinary stores full URLs directly
     */
    public function getFirstImageAttribute()
    {
        if (is_array($this->images) && count($this->images) > 0) {
            $image = $this->images[0];
            // Cloudinary returns full URLs; local fallback uses storage path
            return str_starts_with($image, 'http') ? $image : asset('storage/' . $image);
        }
        return asset('images/no-image.jpg');
    }

    /**
     * Get all image URLs
     */
    public function getImageUrlsAttribute()
    {
        if (is_array($this->images)) {
            return array_map(function($image) {
                return str_starts_with($image, 'http') ? $image : asset('storage/' . $image);
            }, $this->images);
        }
        return [];
    }
}
