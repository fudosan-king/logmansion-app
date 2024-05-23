@extends('adminlte::page')

@section('title', __('messages.catalogue'))

@section('content_header')
    <h1>{{__('messages.catalogue')}}{{ __('messages.list') }}</h1>
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
                        <a href="{{ route('catalogue.create') }}" class="btn btn-primary">{{ __('messages.create_new') }}</a>
                    </div>
                </div>
                <div class="card-body">
                    <!--DataTable-->
                    <div class="table-responsive">
                        <table id="tblData" class="table table-bordered table-striped dataTable dtr-inline">
                            <thead>
                                <tr>
                                    <th>{{ __('messages.date') }}</th>
                                    <th></th>
                                    <th>{{ __('messages.title') }}</th>
                                    <th>{{ __('messages.status') }}</th>
                                    <th>{{ __('messages.action') }}</th>
                                    <th></th>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

@stop

@section('js')
<script>
    $(document).ready(function(){
        var table = $('#tblData').DataTable({
            reponsive:true, processing:true, serverSide:true, autoWidth:false, 
            ajax:"{{route('catalogue.index')}}", 
            columns:[
                {data:'updated_at', name:'updated_at'},
                {data:'image', name:'image'},
                {data:'cata_title', name:'cata_title', width: '50%', className: 'limited-width' },
                {data:'active', name:'cata_active', searchable: false, bSortable: false},
                {data:'action', name:'action', searchable: false, bSortable: false, className:"text-center"},
                
                {data:'position', name:'position'},
                // {
                //     name: 'position',
                //     data: null,
                //     searchable: false,
                //     sortable: false,
                //     render: function (data, type, full, meta) {
                //         if (type === 'display') {
                //             var $span = $('<span></span>');

                //             if (full.cate_index > 1) {
                //                 $('<a class="dtMoveUp" data-id="' + full.cate_index + '"><i class="fas fa-arrow-up"></i></a>').css('margin-right', '10px').appendTo($span);
                //             }

                //             $('<a class="dtMoveDown" data-id="' + full.cate_index + '"><i class="fas fa-arrow-down"></i></a>').appendTo($span);

                //             return $span.html();
                //         }
                //         return data;
                //     }
                // }
            ], 
            'drawCallback': function (settings) {
                $('#ArgumentsTable tr:last .dtMoveDown').remove();

                $('.dtMoveUp').unbind('click');
                $('.dtMoveDown').unbind('click');

                $('.dtMoveUp').click(moveUp);
                $('.dtMoveDown').click(moveDown);
            },
            order: [],
        });

        $('body').on('click', '#btnDel', function(){
            //confirmation
            var id = $(this).data('id');
            if(confirm('{{__('messages.delete_catalogue')}}')==true)
            {
                var route = "{{route('catalogue.destroy', ':id')}}"; 
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
        
        function moveUp() {
            // var tr = $(this).parents('tr');
            // moveRow(tr, 'up');

            var index = $(this).data('index');
            var route = "{{route('catalogue.index.up', ':index')}}"; 
            route = route.replace(':index', index);
            changeIndex(route);
        }

        function moveDown() {
            // var tr = $(this).parents('tr');
            // moveRow(tr, 'down');

            var index = $(this).data('index');
            var route = "{{route('catalogue.index.down', ':index')}}"; 
            route = route.replace(':index', index);
            changeIndex(route);
        }

        function changeIndex(route){
            $.ajax({
                url:route, 
                type:"post", 
                success:function(res){
                    console.log(res);
                    $("#tblData").DataTable().ajax.reload();
                },
                error:function(res){
                    var errorMessage = res.responseJSON.message;
                    alert(errorMessage);
                }
            });
        }

        function moveRow(row, direction) {
            // var index = table.row(row).index();

            // var order = -1;
            // if (direction === 'down') {
            //     order = 1;
            // }

            // var data1 = table.row(index).data();
            // data1.order += order;

            // var data2 = table.row(index + order).data();
            // data2.order += -order;

            // table.row(index).data(data2);
            // table.row(index + order).data(data1);

            table.page(0).draw(false);
        }
    });
    
   
</script>
@stop

@section('plugins.Datatables', true)
@section('plugins.Select2', true)