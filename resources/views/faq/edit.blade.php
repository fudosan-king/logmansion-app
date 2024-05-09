@extends('adminlte::page')

@section('title', 'よくある質問')

@section('content_header')
    <h1>バナー編集</h1>
@stop

@section('content')
    <div class="card card-primary">
        <form action="{{ route('faq.update', $faq->faq_id) }}" method="POST" enctype="multipart/form-data">
            <div class="col-md-8 mx-auto">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="faq_title">タイトル</label>
                        <span class="red-required">※</span>
                        <input type="text" name="faq_title" id="faq_title"
                            class="form-control @error('faq_title') is-invalid @enderror"
                            value="{{ old('faq_title', $faq->faq_title) }}">
                        @error('faq_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="faq_content">内容</label>
                        <span class="red-required">※</span>
                        <textarea name="faq_content" id="faq_content"
                            class="form-control @error('faq_content') is-invalid @enderror">{{ old('faq_content', $faq->faq_content) }}</textarea>
                        @error('faq_content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="faq_active" id="faq_active" value="1"
                            {{ old('faq_active', $faq->faq_active) ? 'checked' : '' }}>
                        <label for="faq_active">表示</label>
                        @error('faq_active')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card-footer d-flex justify-content-center">
                <div class="col-md-8">
                    <a href="{{ url()->previous() }}" class="btn btn-default">{{ __('messages.cancel') }}</a>
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
        function previewImage(input) {
            var preview = document.getElementById('faq_image_preview');
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
