@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Add FAQ</h1>
@stop

@section('content')
    <div class="card card-primary">
        <form action="{{ route('faq.store') }}" method="POST" enctype="multipart/form-data">
            <div class="col-md-8 mx-auto">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="faq_title">Title</label>
                        <input type="text" name="faq_title" id="faq_title"
                            class="form-control @error('faq_title') is-invalid @enderror" value="{{ old('faq_title') }}">
                        @error('faq_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="faq_content">Description</label>
                        <textarea name="faq_content" id="faq_content"
                            class="form-control @error('faq_content') is-invalid @enderror">{{ old('faq_content') }}</textarea>
                        @error('faq_content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="faq_active" id="faq_active" value="1"
                            {{ old('faq_active') ? 'checked' : '' }}>
                        <label for="faq_active">Active</label>
                        @error('faq_active')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <div class="col-md-8 mx-auto">
                    <a href="{{ url()->previous() }}" class="btn btn-default" style="width:150px;margin-left:10px">{{ __('messages.cancel') }}</a>
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
