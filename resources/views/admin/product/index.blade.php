@extends('admin.layouts.app')
@section('content')
<div class="container">
    <div class="d-flex justify-content-between mx-0 my-4 w-100">
        <div>
            <h2>Products CRUD</h2>
        </div>
        <div>
            <a class="btn btn-success" href="{{ route('admin.products.create') }}"> Create New Product</a>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    {!! $html->table(['id'=>'ProductsDataTable']) !!}
</div>

@endsection
@section('script')
{!! $html->scripts() !!}
<script>
    // Delete product
    function deleteConfirm(id){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: SITE_URL+'/admin/products/'+id,
            type: 'DELETE',
            dataType: 'json',
            data: {method: '_DELETE', submit: true}
        }).always(function (data) {
            $('#ProductsDataTable').DataTable().draw(false);
        });
    }

    // Change product status
    $(document.body).on('click', '.actStatus' ,function(event){
        var row = this.id;
        var dbid = $(this).attr('data-sid');
        bootbox.confirm({
            message: "Are you sure you want to change user status ?",
            buttons: {
                'cancel': { label: 'No',className: 'btn-danger'},
                'confirm': { label: 'Yes',className: 'btn-success'}
            },
            callback: function(result){
                if (result){
                    $.ajax({
                        type :'POST',
                        data : {id:dbid, _token:'{{ csrf_token() }}'},
                        url  : SITE_URL+'/admin/products/status-change',
                        success  : function(response) {
                            if (response == 'Active') {
                                $('#'+row+'').text('Active').removeClass('text-danger').addClass('text-success');
                            }
                            else if(response == 'Deactive') {
                                $('#'+row+'').text('Deactive').removeClass('text-success').addClass('text-danger');
                            }
                            else if(response == 'error') {
                                bootbox.alert('Something Went to Wrong');
                            }
                        }
                    });
                }
            }
        });
    });
</script>
@endsection
