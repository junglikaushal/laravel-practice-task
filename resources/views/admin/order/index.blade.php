@extends('admin.layouts.app')
@section('content')
<div class="container">
    <div class="d-flex justify-content-between mx-0 my-4 w-100">
        <div>
            <h2>Orders</h2>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    {!! $html->table(['id'=>'OrdersDataTable']) !!}
</div>

@endsection
@section('script')
{!! $html->scripts() !!}
@endsection
