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
     * Resolve a stored image path/public_id/URL to a browser-ready URL.
     * Supports Cloudinary full URLs, Cloudinary public IDs, and local storage paths.
     */
    public static function resolveImageUrl(?string $image): string
    {
        if (!$image) {
            return asset('images/no-image.svg');
        }

        if (str_starts_with($image, 'http://') || str_starts_with($image, 'https://')) {
            return $image;
        }

        // Cloudinary public IDs / remote disk paths
        try {
            if (config('filesystems.disks.cloudinary.cloud_name') || config('filesystems.disks.cloudinary.url')) {
                return \Illuminate\Support\Facades\Storage::disk('cloudinary')->url($image);
            }
        } catch (\Throwable $e) {
            // fall through to local storage
        }

        return asset('storage/' . ltrim($image, '/'));
    }

    /**
     * Get the first image URL
     */
    public function getFirstImageAttribute()
    {
        if (is_array($this->images) && count($this->images) > 0) {
            return self::resolveImageUrl($this->images[0]);
        }

        return asset('images/no-image.svg');
    }

    /**
     * Get all image URLs
     */
    public function getImageUrlsAttribute()
    {
        if (is_array($this->images)) {
            return array_map(fn ($image) => self::resolveImageUrl($image), $this->images);
        }

        return [];
    }
}
