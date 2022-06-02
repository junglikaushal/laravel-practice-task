@extends('admin.layouts.app')
@section('css')
<link rel="stylesheet" href="https://neofusion.github.io/hierarchy-select/v2/dist/hierarchy-select.min.css">
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="d-flex justify-content-between mx-0 my-4 w-100">
            <div>
                <h2>Edit Product</h2>
            </div>
            <div>
                <a class="btn btn-primary" href="{{ route('admin.products.index') }}"> Back</a>
            </div>
        </div>
    </div>
  
    {{ Form::model($product, ['route' => ['admin.products.update', $product->id],'method'=>'put','enctype' => 'multipart/form-data']) }}
        {{ Form::label('name', 'Name',['class'=>'font-weight-bold']); }}
        {{ Form::text('name',null,['class'=>'form-control' . ($errors->has('name') ? ' is-invalid' : null)]); }}
        @error('name') <div class="alert alert-danger"> {{ $message }} </div> @enderror
        {{ Form::label('quantity', 'Quantity',['class'=>'font-weight-bold']); }}
        {{ Form::number('quantity',null,['step' => '1', 'min' => '1','class'=>'form-control' . ($errors->has('quantity') ? ' is-invalid' : null),'rows'=>'3']); }}
        @error('quantity') <div class="alert alert-danger"> {{ $message }} </div> @enderror
        {{ Form::label('price', 'Price',['class'=>'font-weight-bold']); }}
        {{ Form::number('price',null,['step' => '0.01', 'min' => '1','class'=>'form-control' . ($errors->has('price') ? ' is-invalid' : null),'rows'=>'3']); }}
        @error('price') <div class="alert alert-danger"> {{ $message }} </div> @enderror
        {{ Form::label('image', 'Image',['class'=>'font-weight-bold']); }}
        @if($product->getRawOriginal('image') != null)
            @if(\Storage::disk('public')->exists('product_images/'.$product->getRawOriginal('image')))
                <span><img class="d-inline" src="{{ $product->image }}" alt="{{ $product->name }}" width="50" height="50"></span>
            @else
                <span> (No image)</span>
            @endif
        @else
            <span> (No image)</span>
        @endif
        {{ Form::file('image',['class'=>'form-control' . ($errors->has('image') ? ' is-invalid' : null)]); }}
        <div class="text-center mt-3">
            {{ Form::submit('Update',['class'=>'btn btn-primary']); }}
        </div>
    {{ Form::close() }}
</div>
@endsection
@section('script')
<script src="https://neofusion.github.io/hierarchy-select/v2/dist/hierarchy-select.min.js"></script>
<script>
    $(document).ready(function() {
        $('#example-one').hierarchySelect({
            width: '100%'
        });
    });
</script>
@endsection