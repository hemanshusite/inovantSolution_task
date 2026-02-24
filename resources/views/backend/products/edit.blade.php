@extends('backend.layout.app')
@section('title', 'Edit Product')

@section('content')
<div class="content-wrapper">
    <div class="card">
        <div class="card-header">
            <h4>Edit Product : {{ $product->name }}</h4>
        </div>

        <div class="card-body">

            <form id="updateProductData" method="POST" action="{{ route('product.update', $product->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="col-sm-6">
                        <label for="product_name">Product Name<span class="text-danger">*</span></label>
                        <input class="form-control required" type="text" id="product_name" name="product_name" value="{{ $product->name ?? '' }}"><br/>
                    </div>
                    <div class="col-sm-6">
                        <label for="product_description">Product Description<span class="text-danger">*</span></label>
                        <textarea class="form-control required" id="product_description" name="product_description">{{ $product->description ?? '' }}</textarea><br/>
                    </div>
                    <div class="col-sm-6">
                        <label for="product_price">Price<span class="text-danger">*</span></label>
                        <input class="form-control required" type="text" id="product_price" name="product_price" oninput="validateNumberInput(this)" maxlength="6" value="{{ $product->price ?? 0 }}"><br/>
                    </div>
                    <div class="col-sm-6">
                        <label for="product_discount">Discount<span class="text-danger">*</span></label>
                        <input class="form-control required" type="text" id="product_discount" name="product_discount" oninput="validateNumberInput(this)" maxlength="6" value="{{ $product->discount_price ?? 0 }}"><br/>
                    </div>
                    <div class="col-sm-6">
                        <label for="product_quantity">Stock Quantity<span class="text-danger">*</span></label>
                        <input class="form-control required" type="text" id="product_quantity" name="product_quantity" oninput="validateNumberInput(this)" maxlength="6" value="{{ $product->stock_quantity ?? 0 }}"><br/>
                    </div>
                    <div class="col-md-6 text-center file-input-div mt-3">
                        <label for="product_document" class="fw-bold">
                            File Upload <span class="text-danger">*</span>
                        </label><br>
                        <p class="text-primary mb-2">Product Image</p>

                        <div class="file-upload-wrapper">
                            <label for="image" class="custom-file-upload">
                                <i class="ft-upload"></i> Choose File
                            </label>

                            <input 
                                type="file" 
                                name="product_document[]"
                                class="product-document"
                                id="image"
                                accept=".jpg,.jpeg,.png,.webp,.svg"
                                multiple
                                hidden
                            >
                        </div>
                        <p id="files-area">
                            <span id="filesList">
                                <span id="files-names"></span>
                            </span>
                        </p>

                        @php
                            $images = [];
                            if (!empty($product->image_url)) {
                                $images = is_array($product->image_url)
                                    ? $product->image_url
                                    : json_decode($product->image_url, true);
                            }
                        @endphp

                        <div class="mt-3">
                            @foreach($images as $key => $image)
                                <div class="d-flex mb-2 align-items-center">

                                    {{-- File Name --}}
                                    <input type="text"
                                        class="form-control bg-white document-border w-75"
                                        value="{{ basename($image) }}"
                                        readonly
                                        style="color:black !important;">

                                    <a href="{{ asset('storage/'.$image) }}"
                                    class="btn btn-primary mx-2 px-2"
                                    target="_blank">
                                        <i class="fa fa-eye"></i>
                                    </a>

                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row mt-2s">
                    <div class="col-sm-12">
                        <div class="pull-right">
                            <button type="button" class="btn btn-success" onclick="submitForm('updateProductData','post')">Update</button>
                            <a href="{{URL::previous()}}" class="btn btn-danger"> Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        handleMultipleImageShow();
    });
</script>
@endsection
