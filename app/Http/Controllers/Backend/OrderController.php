<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.orders.index');
    }

    /**
     * Fetch orders for DataTables.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchOrders(Request $request)
    {
        if ($request->ajax()) {
            try {
                $orders = Order::with('user')->orderBy('created_at', 'desc');

                return DataTables::of($orders)
                    ->filter(function ($query) use ($request) {
                        if (!empty($request['search']['search_order_id']) && $request['search']['search_order_id'] != null) {
                            $query->where(function($q) use ($request) {
                                $q->where('order_unique_id', 'like', "%{$request['search']['search_order_id']}%")
                                  ->orWhere('order_number', 'like', "%{$request['search']['search_order_id']}%");
                            });
                        }
                        
                        if (!empty($request['search']['order_status']) && $request['search']['order_status'] != 'all') {
                            $query->where('order_status', $request['search']['order_status']);
                        }
                    })
                    ->editColumn('order_id', function($order) {
                        return $order->order_unique_id ?? '#0000001';
                    })
                    ->editColumn('user_name', function($order) {
                        return $order->user->name ?? 'N/A';
                    })
                    ->editColumn('subtotal', function($order) {
                        return "₹" . number_format($order->subtotal, 2);
                    })
                    ->editColumn('discount', function($order) {
                        return "₹" . number_format($order->discount, 2);
                    })
                    ->editColumn('total_discount', function($order) {
                        return "₹" . number_format($order->total_discount, 2);
                    })
                    ->editColumn('total_amount', function($order) {
                        return "₹" . number_format($order->total_amount, 2);
                    })
                    ->editColumn('total_items', function($order) {
                        return $order->total_items;
                    })
                    ->editColumn('order_status', function($order) {
                        $badgeClass = [
                            'pending' => 'badge bg-warning',
                            'processing' => 'badge bg-info',
                            'completed' => 'badge bg-success',
                            'cancelled' => 'badge bg-danger',
                            'refunded' => 'badge bg-secondary',
                            'failed' => 'badge bg-danger'
                        ];
                        $class = $badgeClass[$order->order_status] ?? 'badge bg-secondary';
                        return '<span class="' . $class . '">' . ucfirst($order->order_status) . '</span>';
                    })
                    ->editColumn('action', function($order) {
                        $actions = '<span class="d-flex gap-2">';
                        $actions .= '<a href="order/view/'.$order->id.'" class="btn btn-sm btn-outline-primary" title="View"><i class="fa fa-eye"></i></a>';
                        $actions .= '</span>';
                        return $actions;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['order_id', 'user_name', 'subtotal', 'discount', 'total_discount', 'total_amount', 'total_items', 'order_status', 'action'])
                    ->setRowId('id')
                    ->make(true);
                    
            } catch (\Exception $e) {
                \Log::error("Error in fetchOrders: " . $e->getMessage());
                return response()->json(['error' => 'Something went wrong'], 500);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['order'] = Order::with(['user', 'creator', 'details'])->findOrFail($id);
        
        $data['order_details'] = $data['order']->details;
        
        $cartIds = $data['order_details']->pluck('cart_id')->filter()->toArray();
        if (!empty($cartIds)) {
            $data['carts'] = Cart::whereIn('id', $cartIds)->with('product')->get();
        } else {
            $data['carts'] = collect([]);
        }

        return view('backend.orders.view', $data);
    }
}
