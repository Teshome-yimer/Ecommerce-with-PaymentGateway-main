<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'grand_total',
        'payment_method',
        'payment_status',
        'status',
        'currency',
        'shipping_amount',
        'shipping_method',
        'notes',
    ];

    protected $casts = [
        'grand_total' => 'decimal:2',
        'shipping_amount' => 'decimal:2',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'id_user');
    }

    public function items(){
        return $this->hasMany(OrderItem::class, 'id_order');
    }

    public function address(){
        return $this->hasOne(Address::class, 'id_order');
    }
}
