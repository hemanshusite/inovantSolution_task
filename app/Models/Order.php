<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    
    protected $fillable = [
        'order_unique_id',
        'order_number',
        'user_id',
        'subtotal',
        'discount',
        'total_discount',
        'total_amount',
        'total_items',
        'order_status',
        'payment_status',
        'payment_method',
        'notes',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'total_discount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Get the user that owns the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the order details for the order.
     */
    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }

    /**
     * Get the order details with product relationship.
     */
    public function items()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Generate unique order number.
     */
    public static function generateOrderNumber()
    {
        $prefix = 'ORD';
        $year = date('Y');
        $month = date('m');
        $day = date('d');
        
        $lastOrder = self::whereDate('created_at', today())->orderBy('id', 'desc')->first();
        
        if ($lastOrder && preg_match('/(\d{4})$/', $lastOrder->order_number, $matches)) {
            $lastNumber = intval($matches[1]);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }
        
        return $prefix . $year . $month . $day . $newNumber;
    }
}