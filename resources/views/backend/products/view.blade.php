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
                                        <h5 class="pt-2">View Product : {{ $product->name }}</h5>
                                    </div>
                                    <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                        <a href="{{ URL::previous() }}" class="btn btn-sm btn-primary px-3 py-1"><i
                                                    class="fa fa-arrow-left"></i> Back</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @php
                                    $images = [];
                                    if (!empty($product->image_url)) {
                                        $images = is_array($product->image_url)
                                            ? $product->image_url
                                            : json_decode($product->image_url, true);
                                    }
                                @endphp

                                @if(!empty($images))
                                    <div id="productImageSlider" class="carousel slide mb-4" data-bs-ride="carousel">
                                        
                                        <div class="carousel-inner">
                                            @foreach($images as $key => $image)
                                                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                                    <img src="{{ asset('storage/'.$image) }}"
                                                        class="d-block w-100 rounded"
                                                        style="height:400px; object-fit:cover;">
                                                </div>
                                            @endforeach
                                        </div>

                                        {{-- Controls --}}
                                        <button class="carousel-control-prev" type="button"
                                                data-bs-target="#productImageSlider" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon"></span>
                                        </button>

                                        <button class="carousel-control-next" type="button"
                                                data-bs-target="#productImageSlider" data-bs-slide="next">
                                            <span class="carousel-control-next-icon"></span>
                                        </button>
                                    </div>
                                @endif
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <td><strong>Product Name</strong></td>
                                        <td>{{$product->name ?? ''}}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Description</strong></td>
                                        <td>{{$product->description ?? ''}}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Price</strong></td>
                                        <td>₹{{ number_format($product->price, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Discount Price</strong></td>
                                        <td>₹{{ number_format($product->discount_price ?? 0, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Total Price</strong></td>
                                        <td>₹{{ number_format($product->total_price ?? 0, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status</strong></td>
                                        <td>{{$product->status == 1 ? 'Active' : 'Inactive'}}</td>
                                    </tr>

                                    @if(!empty($product->updated_by))
                                    <tr>
                                        <td><strong>Updated By</strong></td>
                                        <td>{{$product->modifier->name ?? ''}}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Updated At</strong></td>
                                        <td>{{ isset($product->updated_at) ? \Carbon\Carbon::parse($product->updated_at)->format('d-m-Y g:i A') : '' }}</td>
                                    </tr>
                                    @endif

                                    <tr>
                                        <td><strong>Created By</strong></td>
                                        <td>{{$product->creator->name ?? ''}}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Created At</strong></td>
                                        <td>{{ isset($product->created_at) ? \Carbon\Carbon::parse($product->created_at)->format('d-m-Y g:i A') : '' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection