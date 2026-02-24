<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'order_details';
    
    protected $fillable = [
        'order_id',
        'product_id',
        'cart_id',
        'product_name',
        'product_description',
        'product_sku',
        'product_price',
        'product_discount_price',
        'product_image_url',
        'quantity',
        'subtotal',
        'discount',
        'total_discount',
        'total_price',
        'product_details'
    ];

    protected $casts = [
        'product_price' => 'decimal:2',
        'product_discount_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'total_discount' => 'decimal:2',
        'total_price' => 'decimal:2',
        'product_details' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Get the order that owns the detail.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the product for this detail.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the cart item that created this detail.
     */
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
}