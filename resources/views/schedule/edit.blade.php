@extends('adminlte::page')

@section('title', 'Estate Schedule')

@section('content_header')
<h1>Estate List Schedule</h1>
@stop

@section('content')
<div class="card card-primary">
    <input type="hidden" id="estateId" value="{{$estateId}}">
    <form>
        <div class="col-md-10 mx-auto">
            <div class="card-body text-center">
                <div class="mx-auto mb-4">THE SNAMAISON表参道（ザ・サンメゾン表参道） 3階</div>

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

                @foreach($getAllSchedule as $schedule)

                @if ($schedule['schedule_name'] != '引渡し')
                <div class="form-group row mx-auto schedule-row">
                    <input type="hidden" name="schedule-id" value="{{$schedule['schedule_id']}}">
                    <div class="col-sm-3">
                        <input type="text" name="schedule-name" class="form-control" value="{{$schedule['schedule_name']}}">
                    </div>

                    <div class="col-sm-3">
                        <?php $dateValue = date('Y-m-d', strtotime($schedule['schedule_date'])); ?>
                        <input type="date" name="schedule-date" class="form-control datepicker" value="{{$dateValue}}">
                    </div>

                    <div class="col-sm-5">
                        <textarea class="form-control" name="schedule-description">{{$schedule['schedule_description']}}</textarea>
                    </div>

                    <div class="col-sm-1 remove-icon">
                        <span class="icon"><i class="fas fa-times-circle"></i></span>
                    </div>
                </div>

                @else

                <div class="form-group row mx-auto schedule-row">
                    <input type="hidden" name="schedule-id" value="{{$schedule['schedule_id']}}">
                    <div class="col-sm-3">
                        <input type="text" name="schedule-name" class="form-control" value="{{$schedule['schedule_name']}}" readonly>
                    </div>

                    <div class="col-sm-3">
                        <?php $dateValue = date('Y-m-d', strtotime($schedule['schedule_date'])); ?>
                        <input type="date" name="schedule-date" class="form-control datepicker" value="{{$dateValue}}">
                    </div>
                    <div class="col-sm-5">
                        <textarea class="form-control" name="schedule-description">{{$schedule['schedule_description']}}</textarea>
                    </div>
                </div>

                @endif

                @endforeach




            </div>
        </div>

        <div class="card-footer">
            <button type="" class="btn btn-primary float-left add-schedule">Add Schedule</button>
            <button type="" class="btn btn-primary float-right save-schedule">保存</button>
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
</style>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    $(document).ready(function() {

        //function remove schedule
        function attachRemoveEvent() {
            $('.form-group.row.mx-auto').find('.remove-icon').off('click').on('click', function() {
                var scheduleId = $(this).closest('.form-group.row.mx-auto').find('input[name="schedule-id"]').val();
                var element = $(this).closest('.form-group.row.mx-auto');
                if (scheduleId == '') {
                    element.remove();
                } else {
                    if (confirm("スケジュールを削除しますか？")) {
                        deleteSchedule(scheduleId, element);
                    }
                }
            });
        }


        //function format date
        function formatDate() {
            flatpickr('.datepicker', {
                dateFormat: 'Y/m/d',
                allowInput: true
            });
        }

        //function deleteSchedule
        function deleteSchedule(scheduleId, element) {
            $.ajax({
                url: "/estate/schedule/destroy/" + scheduleId,
                type: "DELETE",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response == true) {
                        element.remove();
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                }
            });
        }

        //call function when loaded DOM
        attachRemoveEvent();
        formatDate();

        //event add schedule
        $('.add-schedule').off('click').on('click', function(e) {
            e.preventDefault();
            var newBlock = `
                <div class="form-group row mx-auto schedule-row">
                    <input type="hidden" name="schedule-id" value="">
                    <div class="col-sm-3">
                        <input type="text" name="schedule-name"  class="form-control" value="">
                    </div>
                    
                    <div class="col-sm-3">
                        <input type="date" name="schedule-date"  class="form-control datepicker">
                    </div>
                    
                    <div class="col-sm-5">
                        <textarea class="form-control" name="schedule-description" ></textarea>
                    </div>
                    <div class="col-sm-1 remove-icon">
                        <span class="icon"><i class="fas fa-times-circle"></i></span>
                    </div>
                </div>
            `;

            $('.form-group.row.mx-auto.schedule-row').first().before(newBlock);

            flatpickr($('.form-group.row.mx-auto.schedule-row:first').find('.datepicker'), {
                dateFormat: 'Y/m/d',
                allowInput: true
            });
            attachRemoveEvent();
        });

        //event check date last schedule
        $('.datepicker:last').on('change', function() {
            var maxDate = new Date($(this).val());
            var lastInput = $(this);
            var $allDateInputs = $('.datepicker');

            $allDateInputs.not(':last').each(function() {
                var currentDate = new Date($(this).val());

                if (currentDate > maxDate) {
                    alert('Invalid date! Please select the largest date');
                    lastInput.val('');
                    return false;
                }
            });
        });


        //event save schedule
        $('.save-schedule').off('click').on('click', function(e) {
            e.preventDefault();

            var schedules = [];
            var error = false;
            var lastDate = $('.datepicker:last').val();

            $('.form-group').each(function(index, element) {
                var schedule = {};

                $(element).find('input[type="text"], input[name="schedule-id"], input[type="date"], textarea').each(function() {
                    var fieldName = $(this).attr('name');
                    var fieldValue = $(this).val();
                    schedule[fieldName] = fieldValue;
                    schedule['index'] = index;
                });

                if (schedule['schedule-date'] == '' || schedule['schedule-name'] == '') {
                    alert('この項目は必須です。');
                    error = true;
                    return false;
                } else if (schedule['schedule-date'] > lastDate) {
                    alert('The last schedule date must be the largest');
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
            hiddenForm.attr('action', '{{ route('schedule.update') }}');

            $(this).append(hiddenForm);
            hiddenForm.append('<input type="hidden" name="_token" value="' + $('meta[name="csrf-token"]').attr('content') + '">');
            hiddenForm.append('<input type="hidden" name="schedules" value=\'' + JSON.stringify(schedules) + '\'>');
            hiddenForm.append('<input type="hidden" name="estateId" value=\'' + id + '\'>');
            hiddenForm.submit();

        });

    });
</script>
@stop