<?php

namespace App\Repositories\Api;

use App\Models\City;
use App\Models\Product;

class ProductRepository
{
    /**
     * Display a listing of the city.
     *
     * @param array $input
     */
    public function getProducts()
    {
        return Product::where('status', 1)->get();
    }
}
