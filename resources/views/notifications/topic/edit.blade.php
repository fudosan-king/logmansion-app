@extends('adminlte::page')

@section('title', 'カテゴリ')

@section('content_header')
    <h1>カテゴリー編集</h1>
@stop

@section('content')
    <div class="card card-primary">
        <form action="{{ route('topic.update', $category->cat_id) }}" method="POST">
            <div class="col-md-10 mx-auto">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="cat_name">タイトル</label>
                        <span class="red-required">※</span>
                        <input type="text" name="cat_name" id="cat_name"
                            class="form-control @error('cat_name') is-invalid @enderror"
                            value="{{ old('cat_name', $category->cat_name) }}">
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
