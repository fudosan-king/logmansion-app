@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Edit Category</h1>
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
                        <input type="text" name="cat_name" id="cat_name"
                            class="form-control @error('cat_name') is-invalid @enderror"
                            value="{{ old('cat_name', $category->cat_name) }}">
                        @error('cat_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary float-right">保存</button>
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