@extends('adminlte::page')

@section('title', __('messages.banner'))

@section('content_header')
    <h1>{{__('messages.edit_banner')}}</h1>
@stop

@section('content')
    <div class="card card-primary">
        <form action="{{ route('banner.update', $banner->banner_id) }}" method="POST" enctype="multipart/form-data">
            <div class="col-md-8 mx-auto">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="banner_title">{{ __('messages.title') }}</label>
                        <input type="text" name="banner_title" id="banner_title"
                            class="form-control @error('banner_title') is-invalid @enderror"
                            value="{{ old('banner_title', $banner->banner_title) }}">
                        @error('banner_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group clearfix">
                        <div class="icheck-primary d-inline" style="padding-right:20px">
                            <input type="radio" name="banner_type"" id="banner_type0" {{ old('banner_type', $banner->banner_type) == '0' ? 'checked' : '' }} value="0">
                            <label>{{ __('messages.banner_img') }}</label>
                        </div>
                        <div class="icheck-primary d-inline">
                          <input type="radio" name="banner_type" id="banner_type1" {{ old('banner_type', $banner->banner_type) ? 'checked' : '' }} value="1">
                          <label>{{ __('messages.banner_img_text') }}</label>
                        </div>
                        @error('banner_type')
                            <div class="text-danger" style="font-size: 80%;">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="banner_description">{{ __('messages.description') }}</label>
                        <textarea name="banner_description" id="banner_description"
                            class="form-control @error('banner_description') is-invalid @enderror">{{ old('banner_description', $banner->banner_description) }}</textarea>
                        @error('banner_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="banner_image">{{ __('messages.image') }}</label>
                        <span class="red-required">※</span>
                        <div class="input-group">
                            <input type="file" class="custom-file-input @error('banner_image') is-invalid @enderror" name="banner_image" id="banner_image" accept="image/*" onchange="previewImage(this)">
                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                            @error('banner_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @if ($banner->banner_image)
                            <img id="banner_image_preview" src="{{ asset('storage/' . $banner->banner_image) }}"
                                alt="Image Preview" style="max-width: 200px; margin-top: 10px;">
                        @else
                            <img id="banner_image_preview" src="#" alt="Image Preview"
                                style="display: none; max-width: 200px; margin-top: 10px;">
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="noti_url">{{ __('messages.url') }}</label>
                        <input type="url" name="banner_url" id="banner_url"
                            class="form-control @error('banner_url') is-invalid @enderror"
                            value="{{ old('banner_url', $banner->banner_url) }}" placeholder="{{ asset('/') }}">
                        @error('banner_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="banner_active" id="banner_active" value="1"
                            {{ old('banner_active', $banner->banner_active) ? 'checked' : '' }}>
                        <label for="banner_active">{{ __('messages.status') }}</label>
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

        if($('input[type=radio][name=banner_type]:checked').val()==='0') {
            $('#banner_description').prop('disabled', true);
        }
        
        $('input[type=radio][name=banner_type]').on('change', function() {
            switch ($(this).val()) {
                case '0':
                    $('#banner_description').prop('disabled', true);
                    $('#banner_description').val('');
                break;
                case '1':
                    $('#banner_description').prop('disabled', false);
                break;
              }
        });

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
