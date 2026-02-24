@extends('backend.layout.app')
@section('title', 'Products')
@section('content')
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
                                        <h5 class="pt-2">Update Stock :  {{ ($product->name ?? '') ." (". ($product->stock_quantity ?? 0) .")" }}</h5>
                                    </div>
                                    <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                        <a href="{{ URL::previous() }}" class="btn btn-sm btn-primary px-3 py-1"><i
                                                    class="fa fa-arrow-left"></i> Back</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form id="updateStockData" method="post" action="{{ route('product.stock.update', $product->id) }}">
                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <p><b>Product Name : </b>{{ ($product->name ?? '')}}</p>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <p><b>Product Description : </b>{{ ($product->description ?? '')}}</p>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <p><b>Current Product Stock : </b>{{ ($product->stock_quantity ?? 0)}}</p>
                                        </div>
                                    </div>
                                    <hr>
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="stock_quantity">Stock Quantity</label>
                                            <input class="form-control required" type="number" id="stock_quantity" name="stock_quantity" value="{{ $product->stock_quantity ?? 0 }}"><br/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="pull-right">
                                                <button type="button" class="btn btn-success" onclick="submitForm('updateStockData','post')">Submit</button>
                                                <a href="{{URL::previous()}}" class="btn btn-danger"> Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection