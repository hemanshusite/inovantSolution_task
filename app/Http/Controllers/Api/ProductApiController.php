<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Repositories\Api\ProductRepository;

class ProductApiController extends Controller
{
    private $productRepository;
    /**
     * ProductApiController constructor.
     * @param ProductRepository $productRepository
     */
    public function __construct(ProductRepository $productRepository){
        $this->productRepository = $productRepository;
    }

    /**
     * Display a listing of the product.
     *
     * @return \Illuminate\Http\Response
     */
    public function productList() {
        try {
            $products = $this->productRepository->getProducts();
            return response()->json([
                'status' => 1,
                'message' => "Product list",
                'data' => ProductResource::collection($products)
             ]);
        } catch (\Exception $e) {
            \Log::error("Something went wrong ". $e->getMessage());
        }
    }
}
