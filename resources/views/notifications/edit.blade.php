@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Edit Notification</h1>
@stop

@section('content')
    <div class="card card-primary">
        <form action="{{ route('notification.update', $notification->noti_id) }}" method="POST">
            <div class="col-md-10 mx-auto">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="noti_title">タイトル</label>
                        <input type="text" name="noti_title" id="noti_title"
                            class="form-control @error('noti_title') is-invalid @enderror"
                            value="{{ old('noti_title', $notification->noti_title) }}">
                        @error('noti_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="cat_id">カテゴリ</label>
                        <select name="cat_id" id="cat_id" class="form-control @error('cat_id') is-invalid @enderror">
                            <option value="">Select category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->cat_id }}"
                                    {{ old('cat_id', $notification->cat_id) == $category->cat_id ? 'selected' : '' }}>
                                    {{ $category->cat_name }}</option>
                            @endforeach
                        </select>
                        @error('cat_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="noti_content">本文</label>
                        <textarea name="noti_content" id="noti_content" class="form-control @error('noti_content') is-invalid @enderror">{{ old('noti_content', $notification->noti_content) }}</textarea>
                        @error('noti_content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-check">
                        <input name="noti_status" type="checkbox" class="form-check-input"
                            {{ $notification->noti_status == 1 ? 'checked' : '' }}>
                        <label>有効</label>
                        @error('noti_status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="noti_date">日付</label>
                        <input type="date" name="noti_date" id="noti_date"
                            class="form-control @error('noti_date') is-invalid @enderror"
                            value="{{ $notification->noti_date ? substr($notification->noti_date, 0, 10) : '' }}">
                        @error('noti_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="noti_url">URL</label>
                        <input type="text" name="noti_url" id="noti_url"
                            class="form-control @error('noti_url') is-invalid @enderror"
                            value="{{ $notification->noti_url ?? "" }}">
                        @error('noti_url')
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
