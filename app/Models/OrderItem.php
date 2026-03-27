<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_order',
        'id_product',
        'quantity',
        'unit_amount',
        'total_amount',
    ];

    protected $casts = [
        'unit_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public function order(){
        return $this->belongsTo(Order::class, 'id_order');
    }

    public function product(){
        return $this->belongsTo(Product::class, 'id_product');
    }
}
