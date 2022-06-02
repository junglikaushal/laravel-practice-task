@extends('user.layouts.app')
@section('content')
<div class="container">
    @if(count($products) > 0)
        <div class="row">
            <div class="col-sm-12">
                <div class="d-flex flex-row justify-content-around my-2">
                    <div class="product_image w-25 text-center fw-bold">
                        Product Image
                    </div>
                    <div class="product_name w-25 text-center fw-bold">
                        Product Name
                    </div>
                    <div class="product_price w-25 text-center fw-bold">
                        Product Price
                    </div>
                    <div class="add_to_cart w-25 text-center fw-bold">
                        Action
                    </div>
                </div>
            </div>
        </div>
        @foreach ($products as $product)
            <div class="row">
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
                        <div class="add_to_cart w-25 text-center">
                            <a href="javascript:;" class="btn btn-success addToCart" data-product-id="{{ $product->id }}"> Add To Cart</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="d-flex justify-content-center py-5">
            {!! $products->links() !!}
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
    $('.addToCart').click(function(){
        var product_id = $(this).data('product-id');
        $.ajax({
            type :'POST',
            data : {id:product_id, _token:'{{ csrf_token() }}'},
            dataType: "json",
            url  : SITE_URL+'/user/addToCart',
            success  : function(response) {
                if (response.status == 1) {
                    toastr.success(response.msg);
                }else if(response.status == 2) {
                    toastr.warning(response.msg);
                }else{
                    toastr.error(response.msg);
                }
            }
        });
    });
</script>
@endsection
