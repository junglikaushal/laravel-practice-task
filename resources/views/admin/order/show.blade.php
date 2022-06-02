@extends('admin.layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="d-flex justify-content-between mx-0 my-3 w-100">
            <div>
                <h2>Order Details</h2>
            </div>
            <div>
                <a class="btn btn-primary" href="{{ route('admin.orders.index') }}"> Back</a>
            </div>
        </div>
    </div>
   
    <div class="row">
        <div class="col-sm-6 text-start">
            <div class="form-group my-2">
                <strong>User Name : </strong>
                {{ $order->user->name }}
            </div>
        </div>
        <div class="col-sm-6 text-end">
            <div class="form-group my-2">
                <strong>Order Id : </strong>
                {{ $order->id }}
            </div>
        </div>
        <div class="col-sm-6 text-start">
            <div class="form-group my-2">
                <strong>Total Amount : </strong>
                ₹ {{ $order->total_amount }}
            </div>
        </div>
        <div class="col-sm-6 text-end">
            <div class="form-group my-2">
                <strong>Order Date : </strong>
                {{ date('d-m-Y',strtotime($order->created_at)) }}
            </div>
        </div>
    </div>

    <div class="row mt-5">
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
                    Quantity
                </div>
                <div class="w-25 text-center fw-bold">
                    Sub Total
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        @foreach ($order->order_details as $value)
            <div class="col-sm-12">
                <div class="d-flex flex-row justify-content-around my-2">
                    <div class="product_image w-25 text-center">
                        <img src="{{ $value->product->image }}" alt="{{ $value->product->name }}" width="50px" height="50px">
                    </div>
                    <div class="product_name w-25 text-center">
                        {{ $value->product->name }}
                    </div>
                    <div class="product_price w-25 text-center">
                        ₹ {{ $value->price }}
                    </div>
                    <div class="product_quantity w-25 text-center">
                        X {{ $value->quantity }}
                    </div>
                    <div class="product_sub_total w-25 text-center">
                        ₹ {{ ($value->quantity * $value->price) }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection