@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h4>Admin :: Dashboard</h4>
    <div class="row justify-content-center mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center"><h5>Top selling products</h5></div>
                <div class="card-body text-center">
                    @if(count($products) > 0)
                        <div class="row table">
                            <div class="col-sm-12">
                                <div class="d-flex flex-row justify-content-around my-2">
                                    <div class="w-25 text-center fw-bold">
                                        Product Image
                                    </div>
                                    <div class="w-25 text-center fw-bold">
                                        Product Name
                                    </div>
                                    <div class="w-25 text-center fw-bold">
                                        Product Price
                                    </div>
                                    <div class="w-25 text-center fw-bold">
                                        Selling Quantity
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            @foreach ($products as $product)
                                <div class="col-sm-12">
                                    <div class="d-flex flex-row justify-content-around my-2">
                                        <div class="product_image w-25 text-center">
                                            <img src="{{ $product->image }}" alt="{{ $product->name }}" width="50px" height="50px">
                                        </div>
                                        <div class="product_name w-25 text-center">
                                            {{ $product->name }}
                                        </div>
                                        <div class="product_price w-25 text-center">
                                            ₹ {{ $product->price }}
                                        </div>
                                        <div class="sell_quantity w-25 text-center">
                                            {{ $product->sell_quantity }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <h5> No Products</h5>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
