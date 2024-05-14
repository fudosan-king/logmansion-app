@extends('adminlte::page')

@section('title', 'バナー')

@section('content_header')
    <h1>バナー新規追加</h1>
@stop

@section('content')
    <div class="card card-primary">
        <form action="{{ route('banner.store') }}" method="POST" enctype="multipart/form-data">
            <div class="col-md-8 mx-auto">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="banner_title">タイトル</label>
                        <input type="text" name="banner_title" id="banner_title"
                            class="form-control @error('banner_title') is-invalid @enderror"
                            value="{{ old('banner_title') }}">
                        @error('banner_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="banner_description">説明文</label>  
                        <textarea name="banner_description" id="banner_description"
                            class="form-control @error('banner_description') is-invalid @enderror">{{ old('banner_description') }}</textarea>
                        @error('banner_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="banner_image">画像</label>
                        <span class="red-required">※</span>
                        <div class="input-group">
                            <input type="file" class="custom-file-input @error('banner_image') is-invalid @enderror" name="banner_image" id="banner_image" accept="image/*" onchange="previewImage(this)">
                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                            @error('banner_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- <input type="file" name="banner_image" id="banner_image"
                            class="form-control-file 
                            @error('banner_image') is-invalid @enderror"
                            onchange="previewImage(this)"> --}}
                        <img id="banner_image_preview" src="#" alt="Image Preview"
                            style="display: none; max-width: 200px; margin-top: 10px;"/>
                    </div>
                    <div class="form-group">
                        <label for="noti_url">URL</label>
                        <input type="url" name="banner_url" id="banner_url"
                            class="form-control @error('banner_url') is-invalid @enderror" value="{{ old('banner_url') }}" placeholder="{{ asset('/') }}">
                        @error('banner_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="banner_active" id="banner_active" value="1"
                            {{ old('banner_active') ? 'checked' : '' }}>
                        <label for="banner_active">表示</label>
                        @error('banner_active')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-center">
                <div class="col-md-8">
                    <a href="{{ route('banner.index') }}" class="btn btn-default">{{ __('messages.cancel') }}</a>
                    <button type="submit" class="btn btn-primary float-right">{{ __('messages.submit') }}</button>
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
        function previewImage(input) {
            var preview = document.getElementById('banner_image_preview');
            var file = input.files[0];
            var reader = new FileReader();

            reader.onloadend = function() {
                preview.src = reader.result;
                preview.style.display = 'block';
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = "";
                preview.style.display = null;
            }
        }
    </script>
@stop
