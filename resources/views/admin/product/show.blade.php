@extends('admin.layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="d-flex justify-content-between mx-0 my-3 w-100">
            <div>
                <h2> Show product</h2>
            </div>
            <div>
                <a class="btn btn-primary" href="{{ route('admin.products.index') }}"> Back</a>
            </div>
        </div>
    </div>
   
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group my-2">
                <strong>Name:</strong>
                {{ $product->name }}
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group my-2">
                <strong>Quantity:</strong>
                {{ $product->quantity }}
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group my-2">
                <strong>Price:</strong>
                {{ $product->price }}
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group my-2">
                <strong>Status:</strong>
                @if($product->status == '1')
                    <span class="text-success"> Active </span>
                @else
                    <span class="text-danger"> Inactive </span>
                @endif
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group my-2">
                <strong>Image:</strong>
                <img src="{{ $product->image }}" alt="{{ $product->name }}" width="50" height="50">
            </div>
        </div>
    </div>
</div>
@endsection