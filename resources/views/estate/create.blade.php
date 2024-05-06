@extends('adminlte::page')

@section('title', 'Create Estate')

@section('content_header')
    <h1>Estate Create</h1>
@stop
@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">①物件基本情報 Basic Information</h3>
            </div>
            <form class="form-horizontal">
                <div class="card-body">
                    <div class="form-group row">
                        <label for="estateName" class="col-sm-2 col-form-label">Estate name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="estateName" placeholder="Estate name" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="roomNo" class="col-sm-2 col-form-label">Room no</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="roomNo" placeholder="Room No" />
                        </div>
                    </div>
                    <div class="form-group row">
                      
                        <label for="address" class="col-sm-2 col-form-label">Address</label>
                        <div class="col-sm-4 row">
                            <input type="text" class="form-control col-sm-4 mr-2" id="address" placeholder="郵便番号" />
                            <span class="m-2">郵便番号入力補助</span>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-info">Submit</button>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>
</section>
@stop



@section('js')
    <script> console.log('Hi!'); </script>
@stop