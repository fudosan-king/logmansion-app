@extends('adminlte::page')

@section('title', __('messages.faq'))

@section('content_header')
    <h1>{{__('messages.add_new_faq')}}</h1>
@stop

@section('content')
    <div class="card card-primary">
        <form action="{{ route('faq.store') }}" method="POST" enctype="multipart/form-data">
            <div class="col-md-8 mx-auto">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="faq_title">{{ __('messages.title') }}</label>
                        <span class="red-required">※</span>
                        <input type="text" name="faq_title" id="faq_title"
                            class="form-control @error('faq_title') is-invalid @enderror" value="{{ old('faq_title') }}">
                        @error('faq_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group clearfix">
                        <div class="icheck-primary d-inline" style="padding-right:20px">
                            <input type="radio" name="faq_type"" id="faq_type0"  {{ old('faq_type') == '0' || empty(old('faq_type')) ? 'checked' : '' }} value="0">
                            <label>{{ __('messages.faq_home') }}</label>
                        </div>
                        <div class="icheck-primary d-inline">
                          <input type="radio" name="faq_type" id="faq_type1" {{ old('faq_type') ? 'checked' : '' }} value="1">
                          <label>{{ __('messages.faq_app') }}</label>
                        </div>
                        @error('faq_type')
                            <div class="text-danger" style="font-size: 80%;">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                    <div class="form-group">
                        <label for="faq_content">{{ __('messages.content') }}</label>
                        <span class="red-required">※</span>
                        <textarea name="faq_content" id="faq_content"
                            class="form-control @error('faq_content') is-invalid @enderror">{{ old('faq_content') }}</textarea>
                        @error('faq_content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="faq_active" id="faq_active" value="1"
                            {{ old('faq_active') ? 'checked' : '' }}>
                        <label for="faq_active">{{ __('messages.status') }}</label>
                        @error('faq_active')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card-footer d-flex justify-content-center">
                <div class="col-md-8">
                    <a href="{{ route('faq.index') }}" class="btn btn-default">{{ __('messages.cancel') }}</a>
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
