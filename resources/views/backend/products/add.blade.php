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
                                        <h5 class="pt-2">Add Product </h5>
                                    </div>
                                    <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                        <a href="{{ URL::previous() }}" class="btn btn-sm btn-primary px-3 py-1"><i
                                                    class="fa fa-arrow-left"></i> Back</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form id="saveProductData" method="post" action="{{ route('product.store') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="product_name">Product Name<span class="text-danger">*</span></label>
                                            <input class="form-control required" type="text" id="product_name" name="product_name" ><br/>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="product_description">Product Description<span class="text-danger">*</span></label>
                                            <textarea class="form-control required" id="product_description" name="product_description"></textarea><br/>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="product_price">Price<span class="text-danger">*</span></label>
                                            <input class="form-control required" type="text" id="product_price" name="product_price" oninput="validateNumberInput(this)" maxlength="6"><br/>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="product_discount">Discount<span class="text-danger">*</span></label>
                                            <input class="form-control required" type="text" id="product_discount" name="product_discount" oninput="validateNumberInput(this)" maxlength="6" value="0"><br/>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="product_quantity">Stock Quantity<span class="text-danger">*</span></label>
                                            <input class="form-control required" type="text" id="product_quantity" name="product_quantity" oninput="validateNumberInput(this)" maxlength="6"><br/>
                                        </div>
                                        <div class="col-md-6 text-center file-input-div">
                                            <label class="fw-bold">
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
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row mt-2s">
                                        <div class="col-sm-12">
                                            <div class="pull-right">
                                                <button type="button" class="btn btn-success" onclick="submitForm('saveProductData','post')">Submit</button>
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
<script>
    $(document).ready(function () {
        handleMultipleImageShow();
    });
</script>
@endsection