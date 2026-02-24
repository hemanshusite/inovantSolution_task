<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'discount_price',
        'total_price',
        'stock_quantity',
        'image_url',
        'status',
        'quantity',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'image_url' => 'array',
    ];

    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function modifier()
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'product_id');
    }
}
