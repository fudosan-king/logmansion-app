@extends('adminlte::page')

@section('title', 'バナー')

@section('content_header')
    <h1>バナー</h1>
@stop

@section('content')
   <div class="container-fluid">
    <div class="row">
        <div id="errorBox"></div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h5>List</h5>
                    </div>
                    <div class="card-tools">
                        <a href="{{ route('banner.create') }}" class="btn btn-primary">新規追加</a>
                    </div>
                </div>
                <div class="card-body">
                    <!--DataTable-->
                    <div class="table-responsive">
                        <table id="tblData" class="table table-bordered table-striped dataTable dtr-inline">
                            <thead>
                                <tr>
                                    <th>タイトル</th>
                                    <th>画像</th>
                                    <th>URL</th>
                                    <th>ステータス</th>
                                    <th>アクション</th>
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
    $(function (){
        $('#select2').select2();
    });
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })
    jQuery(function($){
       $.extend( $.fn.dataTable.defaults, {
         language: { url: "json/japanese.json" }
       });
    });
    $(document).ready(function(){
        var table = $('#tblData').DataTable({
            reponsive:true, processing:true, serverSide:true, autoWidth:false, 
            ajax:"{{route('banner.index')}}", 
            columns:[
                {data:'banner_title', name:'banner_title'},
                {data:'image', name:'image'},
                {data:'url', name:'banner_url'},
                {data:'active', name:'banner_active'},
                {data:'action', name:'action', bSortable:true, className:"text-center"},
            ], 
            order:[[0, "desc"]]
        });
        $('body').on('click', '#btnDel', function(){
            //confirmation
            var id = $(this).data('id');
            if(confirm('削除しますか？')==true)
            {
                var route = "{{route('banner.destroy', ':id')}}"; 
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