@extends('adminlte::page')

@section('title', 'Estate Schedule')

@section('content_header')
<h1>スケジュール</h1>
@stop

@section('content')
<div class="card card-primary">
    <input type="hidden" id="estateId" value="{{$estateId}}">
    <form>
        <div class="col-md-10 mx-auto">
            <div class="card-body text-center">
                <div class="mx-auto mb-4 estate-name">{{$estateName}}</div>

                <div class="form-group row mx-auto schedule-title">

                    <div class="col-sm-3">
                        <label for="" class="col-form-label">スケジュール名</label>
                        <span class="red-required">※</span>
                    </div>

                    <div class="col-sm-3">
                        <label for="" class="col-form-label">日付</label>
                        <span class="red-required">※</span>
                    </div>

                    <div class="col-sm-5">
                        <label for="newField" class="col-form-label">説明文</label>
                    </div>
                </div>

                <div class="form-group row mx-auto schedule-row">

                    <div class="col-sm-3">
                        <input type="text" name="schedule-name" class="form-control" value="申し込み" maxlength="255">
                    </div>

                    <div class="col-sm-3">
                        <input type="date" name="schedule-date" class="form-control datepicker">
                    </div>

                    <div class="col-sm-5">
                        <textarea class="form-control" name="schedule-description" maxlength="255"></textarea>
                    </div>
                    <div class="col-sm-1 remove-icon">
                        <span class="icon"><i class="fas fa-times-circle"></i></span>
                    </div>
                </div>

                <div class="form-group row mx-auto schedule-row">

                    <div class="col-sm-3">
                        <input type="text" name="schedule-name" class="form-control" value="事前審査" maxlength="255">
                    </div>

                    <div class="col-sm-3">
                        <input type="date" name="schedule-date" class="form-control datepicker">
                    </div>

                    <div class="col-sm-5">
                        <textarea class="form-control" name="schedule-description" maxlength="255"></textarea>
                    </div>
                    <div class="col-sm-1 remove-icon">
                        <span class="icon"><i class="fas fa-times-circle"></i></span>
                    </div>
                </div>

                <div class="form-group row mx-auto schedule-row">

                    <div class="col-sm-3">
                        <input type="text" name="schedule-name" class="form-control" value="契約" maxlength="255">
                    </div>

                    <div class="col-sm-3">
                        <input type="date" name="schedule-date" class="form-control datepicker">
                    </div>

                    <div class="col-sm-5">
                        <textarea class="form-control" name="schedule-description" maxlength="255"></textarea>
                    </div>
                    <div class="col-sm-1 remove-icon">
                        <span class="icon"><i class="fas fa-times-circle"></i></span>
                    </div>
                </div>

                <div class="form-group row mx-auto schedule-row">

                    <div class="col-sm-3">
                        <input type="text" name="schedule-name" class="form-control" value="本申し込み" maxlength="255">
                    </div>

                    <div class="col-sm-3">
                        <input type="date" name="schedule-date" class="form-control datepicker">
                    </div>

                    <div class="col-sm-5">
                        <textarea class="form-control" name="schedule-description" maxlength="255"></textarea>
                    </div>
                    <div class="col-sm-1 remove-icon">
                        <span class="icon"><i class="fas fa-times-circle"></i></span>
                    </div>
                </div>

                <div class="form-group row mx-auto schedule-row">

                    <div class="col-sm-3">
                        <input type="text" name="schedule-name" class="form-control" value="金消契約" maxlength="255">
                    </div>

                    <div class="col-sm-3">
                        <input type="date" name="schedule-date" class="form-control datepicker">
                    </div>

                    <div class="col-sm-5">
                        <textarea class="form-control" name="schedule-description" maxlength="255"></textarea>
                    </div>
                    <div class="col-sm-1 remove-icon">
                        <span class="icon"><i class="fas fa-times-circle"></i></span>
                    </div>
                </div>

                <div class="form-group row mx-auto schedule-row">

                    <div class="col-sm-3">
                        <input type="text" name="schedule-name" class="form-control" value="決済" maxlength="255">
                    </div>

                    <div class="col-sm-3">
                        <input type="date" name="schedule-date" class="form-control datepicker">
                    </div>

                    <div class="col-sm-5">
                        <textarea class="form-control" name="schedule-description" maxlength="255"></textarea>
                    </div>
                    <div class="col-sm-1 remove-icon">
                        <span class="icon"><i class="fas fa-times-circle"></i></span>
                    </div>
                </div>

                <div class="form-group row mx-auto schedule-row">

                    <div class="col-sm-3">
                        <input type="text" name="schedule-name" class="form-control" value="契約日" readonly maxlength="255">
                    </div>

                    <div class="col-sm-3">
                        <input type="date" name="schedule-date" class="form-control datepicker">
                    </div>
                    <div class="col-sm-5">
                        <textarea class="form-control" name="schedule-description" maxlength="255"></textarea>
                    </div>
                </div>

                <div class="form-group row mx-auto schedule-row">

                    <div class="col-sm-3">
                        <input type="text" name="schedule-name" class="form-control" value="引渡し" readonly maxlength="255">
                    </div>

                    <div class="col-sm-3">
                        <input type="date" name="schedule-date" class="form-control datepicker">
                    </div>
                    <div class="col-sm-5">
                        <textarea class="form-control" name="schedule-description" maxlength="255"></textarea>
                    </div>
                </div>


            </div>
        </div>

        <div class="card-footer">
            <a href="{{ URL::previous() }}" class="btn btn-default go-back float-left">{{ __('messages.cancel') }}</a>
            <button type="" class="btn btn-primary float-right save-schedule">{{ __('messages.save') }}</button>
            <button type="" class="btn btn-primary float-right add-schedule">{{ __('messages.add') }}</button>
        </div>
    </form>
</div>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    .form-group textarea {
        height: 38px;
        resize: none;
    }

    .remove-icon {
        position: relative;
    }

    .remove-icon span {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        font-size: 20px;
        cursor: pointer;
    }

    .schedule-title {
        margin-bottom: 35px;
    }

    .schedule-row {
        margin-bottom: 25px;
    }

    .red-required {
        color: red;
    }

    .save-schedule {
        margin-left: 30px;
    }

    .estate-name {
        font-size: 25px;
        font-weight: 600;
    }
</style>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    $(document).ready(function() {

        //function remove schedule
        function attachRemoveEvent() {
            $('.remove-icon').off('click').on('click', function() {
                $(this).closest('.form-group.row.mx-auto').remove();
            });
        }

        //function format date
        function formatDate() {
            flatpickr('.datepicker', {
                dateFormat: 'Y/m/d',
                allowInput: true
            });
        }

        //call function when loaded DOM
        attachRemoveEvent();
        formatDate();

        //event add schedule
        $('.add-schedule').on('click', function(e) {
            e.preventDefault();
            var newBlock = `
                <div class="form-group row mx-auto schedule-row">
                    
                    <div class="col-sm-3">
                        <input type="text" name="schedule-name"  class="form-control" value="" maxlength="255">
                    </div>
                    
                    <div class="col-sm-3">
                        <input type="date" name="schedule-date"  class="form-control datepicker">
                    </div>
                    
                    <div class="col-sm-5">
                        <textarea class="form-control" name="schedule-description" maxlength="255" ></textarea>
                    </div>
                    <div class="col-sm-1 remove-icon">
                        <span class="icon"><i class="fas fa-times-circle"></i></span>
                    </div>
                </div>
            `;

            $('.form-group.row.mx-auto.schedule-row').first().before(newBlock);

            attachRemoveEvent();
            flatpickr($('.form-group.row.mx-auto.schedule-row:first').find('.datepicker'), {
                dateFormat: 'Y/m/d',
                allowInput: true
            });

            $('input[name="schedule-date"]').on('change', function() {
                var scheduleDate = $(this).val();
                var lastDate = $('.datepicker:last').val();
                if (lastDate != '' && scheduleDate > lastDate) {
                    alert('「引き渡し日」より後の日付が入力されています。\n「引き渡し日」より前の日付を登録してください。');
                    $(this).val('');
                    return false;
                }

            });
        });

        //event check date last schedule
        $('.datepicker:last').on('change', function() {
            var maxDate = new Date($(this).val());
            var lastInput = $(this);
            var $allDateInputs = $('.datepicker');

            $allDateInputs.not(':last').each(function() {
                var currentDate = new Date($(this).val());

                if (currentDate > maxDate) {
                    alert('「引渡し日」に他のスケジュールより前の日付が入力されています。\n「引渡し日」には、他のスケジュールで入力した日付以降の日付を登録してください。');
                    lastInput.val('');
                    return false;
                }
            });
        });

        //event check name schedule empty
        $('input[name="schedule-name"]').on('change', function() {
            var scheduleName = $(this).val().trim();
            if (scheduleName == '') {
                alert('この項目 「※」は必須です。');
                $(this).val('');
                $(this).focus();
            }
        });

        $('input[name="schedule-date"]').on('change', function() {
            var scheduleDate = $(this).val();
            var lastDate = $('.datepicker:last').val();
            if (lastDate != '' && scheduleDate > lastDate) {
                alert('「引き渡し日」より後の日付が入力されています。\n「引き渡し日」より前の日付を登録してください。');
                $(this).val('');
                return false;
            }

        });


        //event save schedule
        $('.save-schedule').on('click', function(e) {
            e.preventDefault();

            var schedules = [];
            var error = false;
            var lastDate = $('.datepicker:last').val();

            $('.form-group').each(function(index, element) {
                var schedule = {};

                $(element).find('input[type="text"], input[type="date"], textarea').each(function() {
                    var fieldName = $(this).attr('name');
                    var fieldValue = $(this).val().trim();
                    schedule[fieldName] = fieldValue;
                    schedule['index'] = index;
                });

                if (schedule['schedule-date'] == '' || schedule['schedule-name'] == '') {
                    alert('この項目 「※」は必須です。');
                    error = true;
                    return false;
                }
                schedules.push(schedule);
            });


            if (error) {
                return false;
            }
            var hiddenForm = $('<form method="POST" style="display:none;"></form>');
            var id = $('#estateId').val();
            hiddenForm.attr('action', '{{ route('schedule.store') }}');

            $(this).append(hiddenForm);
            hiddenForm.append('<input type="hidden" name="_token" value="' + $('meta[name="csrf-token"]').attr('content') + '">');
            hiddenForm.append('<input type="hidden" name="schedules" value=\'' + JSON.stringify(schedules) + '\'>');
            hiddenForm.append('<input type="hidden" name="estateId" value=\'' + id + '\'>');
            hiddenForm.submit();

        });

    });
</script>
@stop