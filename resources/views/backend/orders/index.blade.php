@extends('backend.layout.app')
@section('title', 'Orders')
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
                                        <h5 class="pt-2">Manage Orders</h5>
                                    </div>
                                    <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                        <button class="btn btn-sm btn-outline-danger px-3 py-1 mx-2"
                                                id="listing-filter-toggle"><i class="fa fa-filter"></i> Filter
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- Filter Section -->
                                <div class="row mb-3" id="listing-filter-data" style="display: none;">
                                    <div class="col-md-3">
                                        <label for="search_order_id">Order ID/Number</label>
                                        <input type="text" class="form-control" id="search_order_id" name="search_order_id" placeholder="Search by order ID">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="order_status">Order Status</label>
                                        <select class="form-control" id="order_status" name="order_status">
                                            <option value="" disabled selected>All Status</option>
                                            <option value="pending">Pending</option>
                                            <option value="processing">Processing</option>
                                            <option value="completed">Completed</option>
                                            <option value="cancelled">Cancelled</option>
                                            <option value="refunded">Refunded</option>
                                            <option value="failed">Failed</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="orderTable">
                                        <thead>
                                            <tr>
                                                <th class="sorting_disabled" id="id" data-orderable="false" data-searchable="false">#</th>
                                                <th class="text-nowrap" id="order_id" data-orderable="false" data-searchable="false">Order ID</th>
                                                <th class="text-nowrap" id="user_name" data-orderable="false" data-searchable="false">User Name</th>
                                                <th class="text-nowrap" id="subtotal" data-orderable="false" data-searchable="false">Subtotal</th>
                                                <th class="text-nowrap" id="discount" data-orderable="false" data-searchable="false">Discount</th>
                                                <th class="text-nowrap" id="total_amount" data-orderable="false" data-searchable="false">Total Amount</th>
                                                <th class="text-nowrap" id="order_status" data-orderable="false" data-searchable="false">Order Status</th>
                                                <th class="text-nowrap" id="action" data-orderable="false" data-searchable="false">Action</th>
                                            </tr>
                                        </thead>
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

<script>
$(document).ready(function() {
    var table = $('#orderTable').DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        pageLength: 10,
        ajax: {
            url: "{{ route('orders.fetch') }}",
            type: "POST",
            data: function(d) {
                d._token = $('meta[name="csrf-token"]').attr('content');
                d.search = {
                    search_order_id: $('#search_order_id').val(),
                    order_status: $('#order_status').val(),
                };
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'order_id', name: 'order_id' },
            { data: 'user_name', name: 'user_name' },
            { data: 'subtotal', name: 'subtotal' },
            { data: 'discount', name: 'discount' },
            { data: 'total_amount', name: 'total_amount' },
            { data: 'order_status', name: 'order_status' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });

    $('#listing-filter-toggle').on('click', function() {
        $('#listing-filter-data').slideToggle();
    });

    $('#search_order_id, #order_status, #payment_status').on('change keyup', function() {
        table.draw();
    });
});
</script>
@endsection