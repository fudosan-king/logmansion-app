@extends('adminlte::page')

@section('title', 'お知らせ')

@section('content_header')
    <h1>お知らせ編集</h1>
@stop

@section('content')
    <div class="card card-primary">
        <form action="{{ route('notification.update', $notification->noti_id) }}" method="POST">
            <div class="col-md-8 mx-auto">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="noti_title">タイトル</label>
                        <span class="red-required">※</span>
                        <input type="text" name="noti_title" id="noti_title"
                            class="form-control @error('noti_title') is-invalid @enderror"
                            value="{{ old('noti_title', $notification->noti_title) }}">
                        @error('noti_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="cat_id">カテゴリ</label>
                        <span class="red-required">※</span>
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
                        <span class="red-required">※</span>
                        <?php $dateValue = date('Y-m-d', strtotime($notification->noti_date)); ?>
                        <input type="date" name="noti_date" class="form-control datepicker @error('noti_date') is-invalid @enderror" value="{{$dateValue}}">
                        {{-- <div class="input-group date" id="notidatepicker" data-target-input="nearest">
                            <input type="text" name="noti_date"  class="form-control datetimepicker-input @error('noti_date') is-invalid @enderror" 
                            value="{{ $notification->noti_date ? substr($notification->noti_date, 0, 10) : '' }}"
                            data-target="#notidatepicker" />
                            <div class="input-group-append" data-target="#notidatepicker" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div> --}}
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    $(document).ready(function() {
        function formatDate() {
            flatpickr('.datepicker', {
                dateFormat: 'Y/m/d',
                allowInput: true
            });
        }

        formatDate();

    })
    // $(function () {
    //     $('#notidatepicker').datetimepicker({
    //         changeMonth: true,
    //         changeYear: true,
    //         format: 'YYYY/MM/DD',
    //         yearRange: '2000:2100',
    //         disabledDates: false,
    //     })
    //     $("#notidatepicker").on("change.datetimepicker", function (e) {
    //         $('#notidatepicker').datetimepicker('minDate', e.date);
    //     });
    // })
</script>
@stop
