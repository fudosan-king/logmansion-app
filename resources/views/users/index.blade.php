@extends('adminlte::page')

@section('title', __('messages.user') .' | '. __('messages.dashboard'))

@section('content_header')
    <h1>{{ __('messages.user') }}</h1>
@stop

@section('content')


   <div class="container-fluid">
    <div class="row">
        <div id="errorBox"></div>
        <div class="col-3">
            <form method="POST" action="{{route('users.store')}}">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h5>{{__('messages.addnew')}}</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name" class="form-label">{{__('messages.name')}} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" placeholder="Enter Full Name" value="{{old('name')}}">
                            @if($errors->has('name'))
                                <span class="text-danger">{{$errors->first('name')}}</span>
                            @endif
                        </div>
                
                        <div class="form-group">
                            <label for="department" class="form-label">{{__('messages.department')}}<span class="text-danger">*</span></label>
                            <select class="form-control select2"  id="select3" data-placeholder="Select Department" name="department">
                            @foreach (config('const.department') as $k=>$v)
                                <option value="{{$k}}" {{ (old('department') && old('department') == $k) ? "selected" : ""}} >{{ucfirst($v)}}</option>
                            @endforeach
                            </select>
                            @if($errors->has('department'))
                            <span class="text-danger">{{$errors->first('department')}}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="email" class="form-label">{{__('messages.mail')}} <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" placeholder="Enter Users Email" value="{{old('email')}}">
                            @if($errors->has('email'))
                                <span class="text-danger">{{$errors->first('email')}}</span>
                            @endif
                        </div>
                        {{-- <div class="form-group">
                            <label for="password" class="form-label">{{__('messages.password')}}</label>
                            <input type="password" class="form-control" name="password" placeholder="Enter Users Password" value="{{old('password')}}">
                            @if($errors->has('password'))
                                <span class="text-danger">{{$errors->first('password')}}</span>
                            @endif
                        </div> --}}
                        <div class="form-group">
                            <label for="roles" class="form-label">{{__('messages.role')}}</label>
                            <select class="form-control select2"
                            {{-- multiple="multiple"  --}}
                            id="select2" data-placeholder="Select Roles" name="roles[]">
                            @foreach ($roles as $role)
                                <option selected value="{{$role->id}}">{{ucfirst($role->name)}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">{{__('messages.save')}}</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-9">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h5>{{__('messages.user-list')}}</h5>
                    </div>
                </div>
                <div class="card-body">
                    <!--DataTable-->
                    <div class="table-responsive">
                        <table id="tblData" class="table table-bordered table-striped dataTable dtr-inline">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>{{__('messages.name')}}</th>
                                    <th>{{__('messages.department')}}</th>
                                    <th>{{__('messages.mail')}}</th>
                                    {{-- <th>{{__('messages.date')}}</th> --}}
                                    <th>{{__('messages.role')}}</th>
                                    <th>{{__('messages.action')}}</th>
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
        $('#select3').select2();
    });    
    $(document).ready(function(){ 
        var table = $('#tblData').DataTable({
            reponsive:true, processing:true, serverSide:true, autoWidth:false, 
            ajax:"{{route('users.index')}}", 
            columns:[
                {data:'id', name:'id'},
                {data:'name', name:'name'},
                {
                    data:'department',  
                    name:'department',
                    render: function (data)  {
                        switch (data) {
                            case 0:
                                html = 'LogSuite';
                                break;
                            case 1:
                                html = 'LogArchitect';
                                break;
                        }
                        return  html;
                    },
                },
                {data:'email', name:'email'},
                // {data:'date', name:'date'},
                {data:'roles', name:'roles'},
                {data:'action', name:'action', bSortable:false, className:"text-center"},
            ], 

            // data: dataSet,
            order:[[0, "desc"]]
        });
        $('body').on('click', '#btnDel', function(){
            //confirmation
            var id = $(this).data('id');
            if(confirm('Delete Data '+id+'?')==true)
            {
                var route = "{{route('users.destroy', ':id')}}"; 
                route = route.replace(':id', id);
                $.ajax({
                    url:route, 
                    type:"delete", 
                    success:function(res){
                        console.log(res);
                        $("#tblData").DataTable().ajax.reload();
                    },
                    error:function(res){
                        $('#errorBox').html('<div class="alert alert-dander">'+response.message+'</div>');
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