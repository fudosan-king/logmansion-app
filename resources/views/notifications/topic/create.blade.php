@extends('adminlte::page')

@section('title', __('messages.category'))

@section('content_header')
    <h1>{{__('messages.new_category')}}</h1>
@stop

@section('content')
    <div class="card card-primary"> 
        <form action="{{ route('topic.store') }}" method="POST">
            <div class="col-md-8 mx-auto">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="cat_name">{{ __('messages.title') }}</label>
                        <span class="red-required">※</span>
                        <input type="text" name="cat_name" id="cat_name"
                            class="form-control @error('cat_name') is-invalid @enderror"
                            value="">
                        @error('cat_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-center">
                <div class="col-md-8">
                    <a href="{{ route('topic.index') }}" class="btn btn-default">{{ __('messages.cancel') }}</a>
                    <button type="submit" class="btn btn-primary float-right">{{ __("messages.submit") }}</button>
                </div>
            </div>
        </form>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
    </script>
@stop
