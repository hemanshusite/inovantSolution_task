@extends('backend.layout.app')
@section('title', 'Order')
@section('content')
<div class="content-overlay"></div>
<div class="content-wrapper">
    <section class="users-list-wrapper">
        <div class="users-list-table">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-12 col-sm-7">
                                        <h5 class="pt-2">View Order : {{ $order->order_unique_id ?? '#0000001' }}</h5>
                                    </div>
                                    <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                        <a href="{{ URL::previous() }}" class="btn btn-sm btn-primary px-3 py-1">
                                            <i class="fa fa-arrow-left"></i> Back
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <h5 class="my-2 text-bold-500"><i class="ft-info mr-2"></i>Order Details</h5>
                                    <table class="table table-bordered table-striped">
                                        <tr>
                                            <td width="50%"><strong>Order ID</strong></td>
                                            <td>{{ $order->order_unique_id ?? '#0000001' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Order Number</strong></td>
                                            <td>{{ $order->order_number ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>User Name</strong></td>
                                            <td>{{ $order->user->name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>User Email</strong></td>
                                            <td>{{ $order->user->email ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Subtotal</strong></td>
                                            <td>₹{{ number_format($order->subtotal, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Discount</strong></td>
                                            <td>₹{{ number_format($order->discount, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total Discount</strong></td>
                                            <td>₹{{ number_format($order->total_discount, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Final Amount</strong></td>
                                            <td>₹{{ number_format($order->total_amount, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total Items</strong></td>
                                            <td>{{ $order->total_items }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Order Status</strong></td>
                                            <td>
                                                @php
                                                    $statusClass = [
                                                        'pending' => 'warning',
                                                        'processing' => 'info',
                                                        'completed' => 'success',
                                                        'cancelled' => 'danger',
                                                        'refunded' => 'secondary',
                                                        'failed' => 'danger'
                                                    ][$order->order_status] ?? 'secondary';
                                                @endphp
                                                <span class="badge bg-{{ $statusClass }}">
                                                    {{ ucfirst($order->order_status) }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Payment Status</strong></td>
                                            <td>
                                                @php
                                                    $paymentClass = [
                                                        'pending' => 'warning',
                                                        'paid' => 'success',
                                                        'failed' => 'danger',
                                                        'refunded' => 'info'
                                                    ][$order->payment_status] ?? 'secondary';
                                                @endphp
                                                <span class="badge bg-{{ $paymentClass }}">
                                                    {{ ucfirst($order->payment_status) }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Created By</strong></td>
                                            <td>{{ $order->creator->name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Created At</strong></td>
                                            <td>{{ $order->created_at ? \Carbon\Carbon::parse($order->created_at)->format('d-m-Y g:i A') : 'N/A' }}</td>
                                        </tr>
                                    </table>
                                    <h5 class="my-2 text-bold-500 mt-4"><i class="ft-info mr-2"></i>Product Details</h5>
                                    <table class="table table-bordered table-striped">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Product Name</th>
                                                <th>Description</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Subtotal</th>
                                                <th>Discount</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($order_details as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $item->product_name }}</td>
                                                <td>{{ Str::limit($item->product_description, 50) }}</td>
                                                <td>₹{{ number_format($item->product_price, 2) }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>₹{{ number_format($item->subtotal, 2) }}</td>
                                                <td>₹{{ number_format($item->total_discount, 2) }}</td>
                                                <td>₹{{ number_format($item->total_price, 2) }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot class="bg-light">
                                            <tr>
                                                <th colspan="5" class="text-right">Total:</th>
                                                <th>₹{{ number_format($order->subtotal, 2) }}</th>
                                                <th>₹{{ number_format($order->total_discount, 2) }}</th>
                                                <th>₹{{ number_format($order->total_amount, 2) }}</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection