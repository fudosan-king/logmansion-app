@extends('adminlte::page')

@section('title', __('messages.catalogue'))

@section('content_header')
    <h1>{{__('messages.edit_catalogue')}}</h1>
@stop

@section('content')
    <div class="card card-primary">
        <form action="{{ route('catalogue.update', $catalogue->cata_id) }}" method="POST" enctype="multipart/form-data">
            <div class="col-md-8 mx-auto">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="cata_title">{{ __('messages.title') }}</label>
                        <input type="text" name="cata_title" id="cata_title"
                            class="form-control @error('cata_title') is-invalid @enderror"
                            value="{{ old('cata_title', $catalogue->cata_title) }}">
                        @error('cata_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="cata_description">{{ __('messages.description') }}</label>
                        <textarea name="cata_description" id="cata_description"
                            class="form-control @error('cata_description') is-invalid @enderror">{{ old('cata_description', $catalogue->cata_description) }}</textarea>
                        @error('cata_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="cata_image">{{ __('messages.image') }}</label>
                        <span class="red-required">※</span>
                        <div class="input-group">
                            <input type="file" class="custom-file-input @error('cata_image') is-invalid @enderror" name="cata_image" id="cata_image" accept="image/*" onchange="previewImage(this)">
                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                            @error('cata_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @if ($catalogue->cata_image)
                            <img id="cata_image_preview" src="{{ asset('storage/' . $catalogue->cata_image) }}"
                                alt="Image Preview" style="max-width: 200px; margin-top: 10px;">
                        @else
                            <img id="cata_image_preview" src="#" alt="Image Preview"
                                style="display: none; max-width: 200px; margin-top: 10px;">
                        @endif
                    </div>
                    {{-- <div class="form-group">
                        <label for="noti_url">{{ __('messages.url') }}</label>
                        <input type="url" name="cata_url" id="cata_url"
                            class="form-control @error('cata_url') is-invalid @enderror"
                            value="{{ old('cata_url', $catalogue->cata_url) }}" placeholder="{{ asset('/') }}">
                        @error('cata_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div> --}}
                    <div class="form-group">
                        <input type="checkbox" name="cata_active" id="cata_active" value="1"
                            {{ old('cata_active', $catalogue->cata_active) ? 'checked' : '' }}>
                        <label for="cata_active">{{ __('messages.status') }}</label>
                        @error('cata_active')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-center">
                <div class="col-md-8">
                    <a href="{{ route('catalogue.index') }}" class="btn btn-default">{{ __('messages.cancel') }}</a>
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
            var preview = document.getElementById('cata_image_preview');
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
