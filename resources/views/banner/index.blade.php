@extends('adminlte::page')

@section('title', __('messages.banner'))

@section('content_header')
    <h1>{{__('messages.banner')}}{{ __('messages.list') }}</h1>
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
                        <a href="{{ route('banner.create') }}" class="btn btn-primary">{{ __('messages.create_new') }}</a>
                    </div>
                </div>
                <div class="card-body">
                    <!--DataTable-->
                    <div class="table-responsive">
                        <table id="tblData" class="table table-bordered table-striped dataTable dtr-inline">
                            <thead>
                                <tr>
                                    <th>{{ __('messages.title') }}</th>
                                    <th>{{ __('messages.image') }}</th>
                                    <th>{{ __('messages.url') }}</th>
                                    <th>{{ __('messages.status') }}</th>
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


//   var table = $('#tblData').DataTable({
//     "dom": '<"top"i>rt<"bottom"><"clear">'
//   });
   
//   $('#mySearch').on( 'keyup click', function () {
//         table.column(0).search('^' + $(this).val() + '$', true);
//         if (table.page.info().recordsDisplay != 1) {
//           table.column(0).search('^' + $(this).val(), true);
//         }
     
//         table.draw();
//     } );
// $('#tblData').DataTable().column(0).search('^' + searchString + '$',true).draw()


        var table = $('#tblData').DataTable({
            reponsive:true, processing:true, serverSide:true, autoWidth:false, 
            ajax:"{{route('banner.index')}}", 
            columns:[
                {data:'banner_title', name:'banner_title'},
                {data:'image', name:'image'},
                {data:'url', name:'banner_url', "searchable": false},
                {data:'active', name:'banner_active'},
                {data:'action', name:'action', bSortable:true, className:"text-center"},
            ], 
            // columnDefs:[
            // {
            //     targets:0,
            //     searchable:false,
            // }],
            order:[[0, "desc"]]
        });

        // $('#tblData thead th.filter').each(function() {
        //     var title = $(this).text();
        //     alert(title);
        //     if (title == 'banner_title') {
        //             return NULL;     
        //         } else {
        //     $(this).html('<input type="text" placeholder="Search ' + title + '" />');
        //     }
        // });

        $('body').on('click', '#btnDel', function(){
            //confirmation
            var id = $(this).data('id');
            if(confirm('バナーを削除しますか？')==true)
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