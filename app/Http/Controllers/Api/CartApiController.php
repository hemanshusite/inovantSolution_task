<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AddCartApiRequest;
use App\Http\Requests\Api\CartListApiRequest;
use App\Http\Requests\Api\EditCartApiRequest;
use App\Http\Requests\Api\CheckoutApiRequest;
use App\Http\Requests\Api\DeleteCartApiRequest;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Repositories\Api\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartApiController extends Controller
{
    protected $cartRepository;

    /**
     * CartApiController constructor.
     * @param CartRepository $cartRepository
     */
    public function __construct(CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    /**
     * Display a listing of the cart.
     *
     * @param CartListApiRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(CartListApiRequest $request)
    {
        try {
            $input = $request->all();
            $carts = $this->cartRepository->getCarts($input);

            if ($carts->isEmpty()) {
                return response()->json([
                    'status' => 1,
                    'message' => "Your cart is empty",
                    'data' => []
                ]);
            }

            $summary = [
                'total_items' => $carts->sum('quantity'),
                'subtotal' => $carts->sum('subtotal'),
                'total_discount' => $carts->sum('total_discount'),
                'total_price' => $carts->sum('total_price'),
                'unique_products' => $carts->count()
            ];

            return response()->json([
                'status' => 1,
                'message' => "Cart retrieved successfully",
                'summary' => $summary,
                'data' => CartResource::collection($carts)
            ]);
        } catch (\Exception $e) {
            \Log::error("Error in cart index: " . $e->getMessage());
            return response()->json([
                'status' => 0,
                'message' => "Failed to retrieve cart: " . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Add item to cart.
     *
     * @param AddCartApiRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addCart(AddCartApiRequest $request)
    {
        try {
            $input = $request->validated();
            $cart = $this->cartRepository->addCart($input);

            return response()->json([
                'status' => 1,
                'message' => "Item added to cart successfully",
                'data' => new CartResource($cart)
            ], 201);
        } catch (\Exception $e) {
            \Log::error("Error in addCart: " . $e->getMessage());
            return response()->json([
                'status' => 0,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Edit cart item quantity.
     *
     * @param EditCartApiRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function editCart(EditCartApiRequest $request)
    {
        try {
            $input = $request->validated();
            $cart = $this->cartRepository->editCart($input);

            return response()->json([
                'status' => 1,
                'message' => "Cart updated successfully",
                'data' => new CartResource($cart)
            ]);
        } catch (\Exception $e) {
            \Log::error("Error in editCart: " . $e->getMessage());
            return response()->json([
                'status' => 0,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Remove item from cart.
     *
     * @param DeleteCartApiRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteCart(DeleteCartApiRequest $request)
    {
        try {
            $input = $request->all();
            $result = $this->cartRepository->deleteCart($input);

            if ($result) {
                return response()->json([
                    'status' => 1,
                    'message' => "Item removed from cart successfully"
                ]);
            }
        } catch (\Exception $e) {
            \Log::error("Error in removeCart: " . $e->getMessage());
            return response()->json([
                'status' => 0,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Process checkout.
     *
     * @param CheckoutApiRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkout(CheckoutApiRequest $request)
    {
        try {
            $input = $request->validated();
            $result = $this->cartRepository->checkout($input);

            return response()->json([
                'status' => 1,
                'message' => "Checkout completed successfully",
                'data' => $result
            ]);
        } catch (\Exception $e) {
            \Log::error("Error in checkout: " . $e->getMessage());
            return response()->json([
                'status' => 0,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}