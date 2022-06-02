@extends('user.layouts.app')
@section('content')
<div class="container">
    <div class="d-flex justify-content-between mx-0 my-4 w-100">
        <div>
            <h2>My Cart</h2>
        </div>
        <div>
            <a class="btn btn-success" href="{{ route('user.home') }}"> Back</a>
        </div>
    </div>
    @if(count($cartData) > 0)
        <div class="row">
            <div class="col-sm-12">
                <div class="d-flex flex-row justify-content-around my-2">
                    <div class="w-25 text-center fw-bold">
                        Delete
                    </div>
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
        @php $total = 0 ; @endphp
        @foreach ($cartData as $product)
            <div class="row">
                <div class="col-sm-12">
                    <div class="d-flex flex-row justify-content-around my-2">
                        <div class="product_image w-25 text-center">
                            <a href="javascript:;" class="btn btn-danger deleteFromCart" data-product-id="{{ $product->id }}"> X </a>
                        </div>
                        <div class="product_image w-25 text-center">
                            <img src="{{ $product->image }}" alt="{{ $product->name }}" width="50px" height="50px">
                        </div>
                        <div class="product_name w-25 text-center">
                            {{ $product->name }}
                        </div>
                        <div class="product_price w-25 text-center">
                            ₹ {{ $product->price }}
                        </div>
                        <div class="product_quantity w-25 text-center">
                            X &nbsp;
                            <a href="javascript:;" class="btn btn-default border qtyRemove" data-product-id="{{ $product->id }}"> - </a>
                            <span class="mx-2">{{ $product->user_quantity }}</span>
                            <a href="javascript:;" class="btn btn-default border qtyAdd" data-product-id="{{ $product->id }}"> + </a>
                        </div>
                        <div class="product_sub_total w-25 text-center">
                            @php $total = $total + ($product->user_quantity * $product->price); @endphp 
                            ₹ {{ ($product->user_quantity * $product->price) }}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="row">
            <div class="col-sm-12">
                <div class="d-flex flex-row justify-content-end my-2">
                    <div class="w-100"></div>
                    <div class="product_total w-25 text-center">
                        <b>Total</b> : ₹ {{ $total }}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="d-flex flex-row justify-content-end my-2">
                    <div class="w-100">
                        <div id="paymentCard"></div>
                    </div>
                    <div class="w-25 text-center">
                        <a class="btn btn-success" id="checkOut" href="javascript:;"> Checkout </a>
                    </div>
                </div>
            </div>
        </div>

    @else
    <div class="text-center my-5">
        <h2> No Products </h2>
    </div>
    @endif
</div>
@endsection
@section('script')
@if(Session::has('message'))
<script>
    $(function() {
        toastr.{{ Session::get('alert-class') }}('{{ Session::get('message') }}');
    });
</script>
@endif
<script>
    // Delete product from cart
    $('.deleteFromCart').click(function(){
        var product_id = $(this).data('product-id');
        $.ajax({
            type :'POST',
            data : {id:product_id, _token:'{{ csrf_token() }}'},
            dataType: "json",
            url  : SITE_URL+'/user/deleteFromCart',
            success  : function(response) {
                if (response.status == 1) {
                    toastr.success(response.msg);
                    location.reload();
                }else{
                    toastr.error(response.msg);
                }
            }
        });
    });
    // Add product quantity
    $('.qtyAdd').click(function(){
        var product_id = $(this).data('product-id');
        $.ajax({
            type :'POST',
            data : {id:product_id, _token:'{{ csrf_token() }}',type:1},
            dataType: "json",
            url  : SITE_URL+'/user/qtyUpdate',
            success  : function(response) {
                if (response.status == 1) {
                    location.reload();
                }else{
                    toastr.error(response.msg);
                }
            }
        });
    });
    // Remove product quantity
    $('.qtyRemove').click(function(){
        var product_id = $(this).data('product-id');
        $.ajax({
            type :'POST',
            data : {id:product_id, _token:'{{ csrf_token() }}',type:2},
            dataType: "json",
            url  : SITE_URL+'/user/qtyUpdate',
            success  : function(response) {
                if (response.status == 1) {
                    location.reload();
                }else{
                    toastr.error(response.msg);
                }
            }
        });
    });
    // Check products stock
    $('#checkOut').click(function(){
        $.ajax({
            type :'POST',
            data : { _token:'{{ csrf_token() }}'},
            dataType: "json",
            url  : SITE_URL+'/user/checkStock',
            success  : function(response) {
                if (response.status == 1) {
                    window.location.href = "{{ route('user.payment')}}";
                }else{
                    toastr.error(response.msg);
                    return false;
                }
            }
        });
    });
</script>
@endsection
