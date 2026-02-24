<?php

namespace App\Repositories\Api;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CartRepository
{
    /**
     * Get all carts for a user
     *
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCarts(array $attributes)
    {
        try {
            return Cart::with('product')
                ->where('user_id', $attributes['user_id'])
                ->whereNull('deleted_at')
                ->get();
        } catch (\Exception $e) {
            \Log::error("Error in getCarts: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Add item to cart
     *
     * @param array $attributes
     * @return Cart|false
     */
    public function addCart(array $attributes)
    {
        try {
            $product = Product::find($attributes['product_id']);
            
            if (!$product) {
                throw new \Exception('Product not found');
            }

            if ($product->stock_quantity < $attributes['quantity']) {
                throw new \Exception('Insufficient stock available. Available stock: ' . $product->stock_quantity);
            }

            if ($product->status != 1) {
                throw new \Exception('Product is not available for purchase');
            }

            $cart = Cart::where('user_id', $attributes['user_id'])
                ->where('product_id', $attributes['product_id'])
                ->whereNull('deleted_at')
                ->first();

            DB::beginTransaction();

            if ($cart) {
                $newQuantity = $cart->quantity + $attributes['quantity'];
                
                if ($product->stock_quantity < $newQuantity) {
                    throw new \Exception('Insufficient stock for additional quantity. Available stock: ' . $product->stock_quantity);
                }

                $cart->quantity = $newQuantity;
                $cart->subtotal = $product->price * $newQuantity;
                $cart->discount = $product->discount_price ?? 0;
                $cart->total_discount = ($product->discount_price ?? 0) * $newQuantity;
                $cart->total_price = ($product->total_price ?? $product->price) * $newQuantity;
                $cart->save();

                DB::commit();
                return $cart;
            } else {
                $cart = Cart::create([
                    'user_id' => $attributes['user_id'],
                    'product_id' => $attributes['product_id'],
                    'quantity' => $attributes['quantity'],
                    'subtotal' => $product->price * $attributes['quantity'],
                    'discount' => $product->discount_price ?? 0,
                    'total_discount' => ($product->discount_price ?? 0) * $attributes['quantity'],
                    'total_price' => ($product->total_price ?? $product->price) * $attributes['quantity'],
                ]);

                DB::commit();
                return $cart;
            }
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error("Error in addCart: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Edit cart item quantity
     *
     * @param array $attributes
     * @return Cart
     */
    public function editCart(array $attributes)
    {
        try {
            $cart = Cart::where('id', $attributes['cart_id'])
                ->where('user_id', $attributes['user_id'])
                ->whereNull('deleted_at')
                ->first();

            if (!$cart) {
                throw new \Exception('Cart item not found');
            }

            $product = Product::find($cart->product_id);
            
            if (!$product) {
                throw new \Exception('Product not found');
            }

            if ($product->stock_quantity < $attributes['quantity']) {
                throw new \Exception('Insufficient stock available. Available stock: ' . $product->stock_quantity);
            }

            DB::beginTransaction();

            $cart->quantity = $attributes['quantity'];
            $cart->subtotal = $product->price * $attributes['quantity'];
            $cart->discount = $product->discount_price ?? 0;
            $cart->total_discount = ($product->discount_price ?? 0) * $attributes['quantity'];
            $cart->total_price = ($product->total_price ?? $product->price) * $attributes['quantity'];
            $cart->save();

            DB::commit();
            return $cart;
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error("Error in editCart: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Delete/Remove cart item
     *
     * @param array $attributes
     * @return bool
     */
    public function deleteCart(array $attributes)
    {
        try {
            $cart = Cart::where('id', $attributes['cart_id'])
                ->where('user_id', $attributes['user_id'])
                ->whereNull('deleted_at')
                ->first();

            if (!$cart) {
                throw new \Exception('Cart item not found');
            }

            DB::beginTransaction();
            
            $cart->delete();
            
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error("Error in deleteCart: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Process checkout
     *
     * @param array $attributes
     * @return array
     */
    public function checkout(array $attributes): array
    {
        try {
            $cartItems = Cart::with('product')
                ->whereIn('id', $attributes['cart_ids'])
                ->where('user_id', $attributes['user_id'])
                ->whereNull('deleted_at')
                ->get();

            if ($cartItems->isEmpty()) {
                return [
                    'success' => false,
                    'message' => 'No items in cart to checkout'
                ];
            }

            $validationResult = $this->validateCheckoutItems($cartItems);
            
            if (!$validationResult['valid']) {
                throw new CheckoutException(
                    'Checkout validation failed',
                    $validationResult['failed_items'],
                    $attributes['user_id']
                );
            }

            DB::beginTransaction();

            $orderTotals = $this->calculateOrderTotals($cartItems);
            
            $orderNumber = Order::generateOrderNumber();
            $orderUniqueId = 'ORD-' . strtoupper(uniqid()) . '-' . time();

            $order = Order::create([
                'order_unique_id' => $orderUniqueId,
                'order_number' => $orderNumber,
                'user_id' => $attributes['user_id'],
                'subtotal' => $orderTotals['subtotal'],
                'discount' => $orderTotals['discount'],
                'total_discount' => $orderTotals['total_discount'],
                'total_amount' => $orderTotals['total_amount'],
                'total_items' => $cartItems->sum('quantity'),
                'order_status' => 'completed',
                'payment_status' => 'paid',
                'created_by' => $attributes['user_id'],
                'updated_by' => $attributes['user_id']
            ]);

            $orderDetails = [];
            foreach ($cartItems as $item) {
                $orderDetail = $this->createOrderDetail($order, $item);
                $orderDetails[] = $orderDetail;
                
                $item->product->stock_quantity -= $item->quantity;
                $item->product->save();

                $item->delete();
            }

            DB::commit();

            return [
                'order' => [
                    'id' => $order->id,
                    'order_number' => $order->order_number,
                    'order_unique_id' => $order->order_unique_id,
                    'total_amount' => $order->total_amount,
                    'total_items' => $order->total_items,
                    'status' => $order->order_status,
                    'payment_status' => $order->payment_status,
                    'created_at' => $order->created_at->format('Y-m-d H:i:s')
                ],
                'order_details' => collect($orderDetails)->map(function($detail) {
                    return [
                        'id' => $detail->id,
                        'product_name' => $detail->product_name,
                        'quantity' => $detail->quantity,
                        'price' => $detail->product_price,
                        'subtotal' => $detail->subtotal,
                        'discount' => $detail->discount,
                        'total_price' => $detail->total_price
                    ];
                }),
                'summary' => [
                    'subtotal' => $order->subtotal,
                    'discount' => $order->discount,
                    'total_discount' => $order->total_discount,
                    'total_amount' => $order->total_amount,
                    'total_items' => $order->total_items
                ]
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error("Error in checkout: " . $e->getMessage(), [
                'attributes' => $attributes,
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    protected function validateCheckoutItems($cartItems): array
    {
        $failedItems = [];
        $valid = true;

        foreach ($cartItems as $item) {
            $itemErrors = [];

            if (!$item->product) {
                $itemErrors[] = 'Product not found';
                $valid = false;
            } else {
                if ($item->product->status != 1) {
                    $itemErrors[] = 'Product is not available for purchase';
                    $valid = false;
                }

                if ($item->product->stock_quantity < $item->quantity) {
                    $itemErrors[] = sprintf(
                        'Insufficient stock. Available: %d, Requested: %d',
                        $item->product->stock_quantity,
                        $item->quantity
                    );
                    $valid = false;
                }
            }

            if (!empty($itemErrors)) {
                $failedItems[] = [
                    'cart_id' => $item->id,
                    'product_name' => $item->product->name ?? 'Unknown',
                    'errors' => $itemErrors
                ];
            }
        }

        return [
            'valid' => $valid,
            'failed_items' => $failedItems
        ];
    }

    /**
     * Calculate order totals from cart items
     *
     * @param \Illuminate\Database\Eloquent\Collection $cartItems
     * @return array
     */
    protected function calculateOrderTotals($cartItems): array
    {
        $subtotal = 0;
        $discount = 0;
        $totalDiscount = 0;
        $totalAmount = 0;

        foreach ($cartItems as $item) {
            $subtotal += $item->subtotal ?? ($item->product->price * $item->quantity);
            $discount += $item->discount ?? 0;
            $totalDiscount += $item->total_discount ?? 0;
            $totalAmount += $item->total_price ?? (($item->product->price * $item->quantity) - ($item->total_discount ?? 0));
        }

        return [
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total_discount' => $totalDiscount,
            'total_amount' => $totalAmount
        ];
    }

    /**
     * Create order detail from cart item
     *
     * @param Order $order
     * @param Cart $cartItem
     * @return OrderDetail
     */
    protected function createOrderDetail(Order $order, Cart $cartItem): OrderDetail
    {
        $product = $cartItem->product;
        
        $subtotal = $product->price * $cartItem->quantity;
        $discount = $product->discount_price ?? 0;
        $totalDiscount = ($product->discount_price ?? 0) * $cartItem->quantity;
        $totalPrice = ($product->total_price ?? $product->price) * $cartItem->quantity;

        $productSnapshot = [
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'discount_price' => $product->discount_price,
            'total_price' => $product->total_price,
            'image_url' => $product->image_url,
            'status' => $product->status
        ];

        // Create order detail
        $orderDetail = OrderDetail::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'cart_id' => $cartItem->id,
            'product_name' => $product->name,
            'product_description' => $product->description,
            'product_sku' => $product->sku ?? null,
            'product_price' => $product->price,
            'product_discount_price' => $product->discount_price,
            'product_image_url' => $product->image_url,
            'quantity' => $cartItem->quantity,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total_discount' => $totalDiscount,
            'total_price' => $totalPrice,
            'product_details' => $productSnapshot
        ]);

        return $orderDetail;
    }
}