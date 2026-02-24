<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $images = [];

        if (!empty($this->product->image_url)) {
            $decoded = is_array($this->product->image_url)
                ? $this->product->image_url
                : json_decode($this->product->image_url, true);

            foreach ($decoded as $image) {
                $images[] = asset('storage/' . $image);
            }
        }
        return [
            'id' => $this->id,
            'user_id' => [
                'id' => $this->user_id,
                'name' => $this->user->name,
                'email' => $this->user->email,
            ],
            'product_id' => [
                'id' => $this->product->id,
                'name' => $this->product->name,
                'price' => $this->product->price,
                'discount_price' => $this->product->discount_price,
                'total_price' => $this->product->total_price,
                'image_url' => $images,
                'stock_quantity' => $this->product->stock_quantity
            ],
            'quantity' => $this->quantity,
            'subtotal' => (float) $this->subtotal,
            'discount' => (float) $this->discount,
            'total_discount' => (float) $this->total_discount,
            'total_price' => (float) $this->total_price,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
