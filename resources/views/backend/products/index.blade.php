@extends('backend.layout.app')
@section('title', 'Products')
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
                                                <h5 class="pt-2">Manage Products</h5>
                                            </div>
                                            <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                                <button class="btn btn-sm btn-outline-danger px-3 py-1 mx-2"
                                                        id="listing-filter-toggle"><i class="fa fa-filter"></i> Filter
                                                </button>
                                                <a href="{{ route('product.create') }}" class="btn btn-sm btn-outline-primary px-3 py-1 src_data"><i class="fa fa-plus"></i> Add Product</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-2" id="listing-filter-data" style="display: none;">
                                            <div class="col-md-4">
                                                <label for="search_product_name">Product Name</label>
                                                <input type="text" class="form-control" id="search_product_name" name="search_product_name"></br>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped " id="productTable">
                                                <thead>
                                                    <tr>
                                                        <th class="sorting_disabled" id="id" data-orderable="false" data-searchable="false">Id</th>
                                                        <th class="text-nowrap" id="name" data-orderable="false" data-searchable="false">Name</th>
                                                        <th class="text-nowrap" id="price" data-orderable="false" data-searchable="false">Price</th>
                                                        <th class="text-nowrap" id="status" data-orderable="false" data-searchable="false">Status</th>
                                                        <th class="text-nowrap" id="action" data-orderable="false" data-searchable="false">Actions</th>
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
            $('#productTable').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                pageLength: 10,
                ajax: {
                    url: "{{ route('products.fetch') }}",
                    type: "POST",
                    data: function(d) {
                        d._token = $('meta[name="csrf-token"]').attr('content');
                        $("#listing-filter-data .form-control").each(function () {
                            d.search[$(this).attr('id')] = $(this).val();
                        });
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'name', name: 'name' },
                    { data: 'price', name: 'price' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'actions' }
                ]
            });
            $('#listing-filter-toggle').on('click', function() {
                $('#listing-filter-data').slideToggle();
            });
            $('#search_product_name').on('keyup', function () {
                $('#productTable').DataTable().draw();
            });
        </script>
@endsection