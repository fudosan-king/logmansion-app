@extends('adminlte::page')

@section('title', __('messages.notifications'))

@section('content_header')
    <h1>お知らせ新規追加</h1>
@stop

@section('content')
    <div class="card card-primary"> 
        <form action="{{ route('notification.store') }}" method="POST">
            <div class="col-md-8 mx-auto">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="noti_title">タイトル</label>
                        <span class="red-required">※</span>
                        <input type="text" name="noti_title" id="noti_title" class="form-control @error('noti_title') is-invalid @enderror" value="{{ old('noti_title') }}">
                        @error('noti_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="cat_id">カテゴリ</label>
                        <span class="red-required">※</span>
                        <select name="cat_id" id="cat_id" class="form-control @error('cat_id') is-invalid @enderror">
                            @foreach ($categories as $category)
                                <option value="{{ $category->cat_id }}" {{ $category->cat_id == old('cat_id') ? 'selected' : ''}}>{{ $category->cat_name }}</option>
                            @endforeach
                        </select>
                        @error('cat_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="noti_content">本文</label>
                        <textarea name="noti_content" id="noti_content" class="form-control @error('noti_content') is-invalid @enderror">{{ old('noti_content') }}</textarea>
                        @error('noti_content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-check">
                        <input name="noti_status" type="checkbox" class="form-check-input" {{ old('noti_status') == true ? 'checked' : '' }}>
                        <label>表示</label>
                        @error('noti_status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="noti_date">日付</label>
                        <span class="red-required">※</span>
                        <div class="input-group date" id="notidatepicker" data-target-input="nearest">
                            <input type="text" name="noti_date"  class="form-control datetimepicker-input @error('noti_date') is-invalid @enderror" 
                            data-target="#notidatepicker" value="{{ old('noti_date') }}"/>
                            <div class="input-group-append" data-target="#notidatepicker" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                            @error('noti_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- <input type="date" name="noti_date" id="noti_date"
                            class="form-control @error('noti_date') is-invalid @enderror"> --}}
                    </div>
                    <div class="form-group">
                        <label for="noti_url">URL</label>
                        <input type="url" name="noti_url" id="noti_url"
                            class="form-control @error('noti_url') is-invalid @enderror" placeholder="{{ asset('/') }}" value="{{ old('noti_url') }}">
                        @error('noti_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-center">
                <div class="col-md-8">
                    <a href="{{ route('notification.index') }}" class="btn btn-default">{{ __('messages.cancel') }}</a>
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
  $(function () {
    $('#notidatepicker').datetimepicker({
        changeMonth: true,
        changeYear: true,
        format: 'YYYY/MM/DD',
        yearRange: "-100:+0",
        disabledDates: false,
        minDate: moment().startOf('day'),
    });
  })
</script>
@stop
