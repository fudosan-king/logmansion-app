@extends('adminlte::page')

@section('title', __("messages.notifications"))

@section('content_header')
    <h1>{{__('messages.edit_notification')}}</h1>
@stop

@section('content')
    <div class="card card-primary">
        <form action="{{ route('notification.update', $notification->noti_id) }}" method="POST">
            <div class="col-md-8 mx-auto">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="noti_title">{{ __('messages.title') }}</label>
                        <span class="red-required">※</span>
                        <input type="text" name="noti_title" id="noti_title"
                            class="form-control @error('noti_title') is-invalid @enderror"
                            value="{{ old('noti_title', $notification->noti_title) }}">
                        @error('noti_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="cat_id">{{ __('messages.category') }}</label>
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
                        <label for="noti_content">{{ __('messages.content') }}</label>
                        <textarea name="noti_content" id="noti_content" class="form-control @error('noti_content') is-invalid @enderror">{{ old('noti_content', $notification->noti_content) }}</textarea>
                        @error('noti_content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-check">
                        <input name="noti_status" type="checkbox" class="form-check-input"
                            {{ $notification->noti_status == 1 ? 'checked' : '' }}>
                        <label>{{ __('messages.status') }}</label>
                        @error('noti_status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="noti_date">{{ __('messages.date') }}</label>
                        <span class="red-required">※</span>
                        <?php $dateValue = date('Y-m-d', strtotime($notification->noti_date)); ?>
                        {{-- <input type="date" class="form-control datepicker @error('noti_date') is-invalid @enderror" value="{{$dateValue}}" > --}}
                        {{-- <div class="input-group date" id="notidatepicker" data-target-input="nearest">
                            <input type="text" name="noti_date"  class="form-control datetimepicker-input @error('noti_date') is-invalid @enderror" 
                            value="{{ \Carbon\Carbon::createFromFormat('Y-m-d', $notification->noti_date)->format('Y/m/d') }}"
                            data-target="#notidatepicker" />
                            <div class="input-group-append" data-target="#notidatepicker" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                            @error('noti_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div> --}}
                        <input type="text" name="noti_date"  class="form-control datepicker_start_date @error('noti_date') is-invalid @enderror" 
                            value="{{ \Carbon\Carbon::createFromFormat('Y-m-d', $notification->noti_date)->format('Y/m/d') }}"/>
                        @error('noti_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="noti_url">{{ __('messages.url') }}</label>
                        <input type="url" name="noti_url" id="noti_url" placeholder="{{ asset('/') }}"
                            class="form-control @error('noti_url') is-invalid @enderror"
                            value="{{ old('noti_url', $notification->noti_url) }}">
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="/css/admin_custom.css">
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"> --}}
@stop

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script> --}}
<script>
    // $(document).ready(function() {
    //     function formatDate() {
    //         flatpickr('.datepicker', {
    //             dateFormat: 'Y/m/d',
    //             allowInput: true
    //         });
    //     }

    //     formatDate();

    // })

    // $(function () {
    //     $('#notidatepicker').datetimepicker({
    //         changeMonth: true,
    //         changeYear: true,
    //         format: 'YYYY/MM/DD',
    //         yearRange: "-100:+0",
    //         disabledDates: false,
    //         minDate: moment().startOf('day'),
    //     });
    // })
    $('.datepicker_start_date').datepicker({
            format: 'yyyy/mm/dd',
            language: 'ja',
            startDate: new Date,
            // endDate: new Date
        });
</script>
@stop

@section('plugins.Datatables', true)
@section('plugins.Select2', true)
