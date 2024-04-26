@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Add New Notification</h1>
@stop

@section('content')
    <div class="card card-primary"> 
        <form action="{{ route('notification.store') }}" method="POST">
            <div class="col-md-10 mx-auto">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="noti_title">タイトル</label>
                        <input type="text" name="noti_title" id="noti_title"
                            class="form-control @error('noti_title') is-invalid @enderror"
                            value="">
                        @error('noti_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="cat_id">カテゴリ</label>
                        <select name="cat_id" id="cat_id" class="form-control @error('cat_id') is-invalid @enderror">
                            @foreach ($categories as $category)
                                <option value="{{ $category->cat_id }}">{{ $category->cat_name }}</option>
                            @endforeach
                        </select>
                        @error('cat_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="noti_content">本文</label>
                        <textarea name="noti_content" id="noti_content" class="form-control @error('noti_content') is-invalid @enderror"></textarea>
                        @error('noti_content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-check">
                        <input name="noti_status" type="checkbox" class="form-check-input">
                        <label>有効</label>
                        @error('noti_status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="noti_date">日付</label>
                        <input type="date" name="noti_date" id="noti_date"
                            class="form-control @error('noti_date') is-invalid @enderror">
                        @error('noti_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="noti_url">URL</label>
                        <input type="text" name="noti_url" id="noti_url"
                            class="form-control @error('noti_url') is-invalid @enderror">
                        @error('noti_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        console.log('Hi!');
    </script>
@stop
