@extends('adminlte::page')

@section('title', __("messages.notifications"))

@section('content_header')
    <h1>{{__("messages.notifications")}}{{ __('messages.list') }}</h1>
@stop

@section('content')
   <div class="container-fluid">
    <div class="row">
        <div id="errorBox"></div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h5></h5>
                    </div>
                    <div class="card-tools">
                        <a href="{{ route('notification.create') }}" class="btn btn-primary">{{ __('messages.create_new') }}</a>
                    </div>
                </div>
                <div class="card-body">
                    <!--DataTable-->
                    <div class="table-responsive">
                        <table id="tblData" class="table table-bordered table-striped dataTable dtr-inline">
                            <thead>
                                <tr>
                                    <th>{{ __('messages.id') }}</th>
                                    <th>{{ __('messages.date') }}</th>
                                    <th>{{ __('messages.category') }}</th>
                                    <th>{{ __('messages.title') }}</th>
                                    <th>{{ __('messages.status') }}</th>
                                    <th>{{ __('messages.last_updated') }}</th>
                                    <th>{{ __('messages.action') }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
   </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script>
    $(document).ready(function(){
        var table = $('#tblData').DataTable({
            reponsive:true, processing:true, serverSide:true, autoWidth:false, 
            ajax:"{{route('notification.index')}}", 
            columns:[
                {data:'noti_id', name:'noti_id'},
                {data:'noti_date', name:'noti_date'},
                {data:'cat_name', name:'cat_name'},
                {data:'noti_title', name:'noti_title'},
                {data:'active', name:'active'},
                {data:'updated_at', name:'updated_at'},
                {data:'action', name:'action', bSortable:false, className:"text-center"},
            ], 
            order:[[0, "desc"]]
        });
        $('body').on('click', '#btnDel', function(){
            //confirmation
            var id = $(this).data('id');
            if(confirm('お知らせを削除しますか？')==true)
            {
                var route = "{{route('notification.destroy', ':id')}}"; 
                route = route.replace(':id', id);
                $.ajax({
                    url:route, 
                    type:"delete", 
                    success:function(res){
                        console.log(res);
                        $("#tblData").DataTable().ajax.reload();
                    },
                    error:function(res){
                        // $('#errorBox').html('<div class="alert alert-dander">'+response.message+'</div>');
                        var errorMessage = res.responseJSON.message;
                        alert(errorMessage);
                    }
                });
            }else{
                //do nothing
            }
        });
    });
    
   
</script>
@stop

@section('plugins.Datatables', true)
@section('plugins.Select2', true)