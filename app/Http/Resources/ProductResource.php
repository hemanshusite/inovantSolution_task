<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $images = [];

        if (!empty($this->image_url)) {
            $decoded = is_array($this->image_url)
                ? $this->image_url
                : json_decode($this->image_url, true);

            foreach ($decoded as $image) {
                $images[] = asset('storage/' . $image);
            }
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => (float) $this->price,
            'discount_price' => (float) $this->discount_price,
            'total_price' => (float) $this->total_price,
            'stock_quantity' => (int) $this->stock_quantity,
            'images' => $images,
            'status' => $this->status == 1 ? 'Active' : 'Inactive',
        ];
    }
}
