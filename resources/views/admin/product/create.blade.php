@extends('admin.layouts.app')
@section('css')
<link rel="stylesheet" href="https://neofusion.github.io/hierarchy-select/v2/dist/hierarchy-select.min.css">
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="d-flex justify-content-between mx-0 my-4 w-100">
            <div>
                <h2>Add New Product</h2>
            </div>
            <div>
                <a class="btn btn-primary" href="{{ route('admin.products.index') }}"> Back</a>
            </div>
        </div>
    </div>
       
    {{ Form::open(['route' => 'admin.products.store','enctype' => 'multipart/form-data']) }}
        {{ Form::label('name', 'Name',['class'=>'font-weight-bold']); }}
        {{ Form::text('name',null,['class'=>'form-control' . ($errors->has('name') ? ' is-invalid' : null)]); }}
        @error('name') <div class="alert alert-danger"> {{ $message }} </div> @enderror
        {{ Form::label('quantity', 'Quantity',['class'=>'font-weight-bold']); }}
        {{ Form::number('quantity','1',['step' => '1', 'min' => '1','class'=>'form-control' . ($errors->has('quantity') ? ' is-invalid' : null),'rows'=>'3']); }}
        @error('quantity') <div class="alert alert-danger"> {{ $message }} </div> @enderror
        {{ Form::label('price', 'Price',['class'=>'font-weight-bold']); }}
        {{ Form::number('price','1',['step' => '0.01', 'min' => '1','class'=>'form-control' . ($errors->has('price') ? ' is-invalid' : null),'rows'=>'3']); }}
        @error('price') <div class="alert alert-danger"> {{ $message }} </div> @enderror
        {{ Form::label('image', 'Image',['class'=>'font-weight-bold']); }}
        {{ Form::file('image',['class'=>'form-control' . ($errors->has('image') ? ' is-invalid' : null)]); }}
        @error('image') <div class="alert alert-danger"> {{ $message }} </div> @enderror
        <div class="text-center mt-3">
            {{ Form::submit('Save',['class'=>'btn btn-primary']); }}
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