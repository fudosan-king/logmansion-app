@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Estate List Schedule</h1>
@stop

@section('content')
    <div class="card card-primary">
        <form action="{{ route('notification.store') }}" method="POST">
            <div class="col-md-10 mx-auto">
                @csrf
                <div class="card-body text-center">
                    <div class="mx-auto mb-4">THE SNAMAISON表参道（ザ・サンメゾン表参道） 3階</div>
                    <div class="form-group row mx-auto">
                        <label for="date1" class="col-sm-5 col-form-label">Ngày 1</label>
                        <div class="col-sm-5">
                            <input type="date" name="date1" id="date1" class="form-control date-input @error('date1') is-invalid @enderror">
                            @error('date1')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row mx-auto">
                        <label for="date1" class="col-sm-5 col-form-label">Ngày 1</label>
                        <div class="col-sm-5">
                            <input type="date" name="date1" id="date1" class="form-control date-input @error('date1') is-invalid @enderror">
                            @error('date1')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row mx-auto">
                        <label for="date1" class="col-sm-5 col-form-label">Ngày 1</label>
                        <div class="col-sm-5">
                            <input type="date" name="date1" id="date1" class="form-control date-input @error('date1') is-invalid @enderror">
                            @error('date1')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row mx-auto">
                        <label for="date1" class="col-sm-5 col-form-label">Ngày 1</label>
                        <div class="col-sm-5">
                            <input type="date" name="date1" id="date1" class="form-control date-input @error('date1') is-invalid @enderror">
                            @error('date1')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row mx-auto">
                        <label for="date1" class="col-sm-5 col-form-label">Ngày 1</label>
                        <div class="col-sm-5">
                            <input type="date" name="date1" id="date1" class="form-control date-input @error('date1') is-invalid @enderror">
                            @error('date1')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row mx-auto">
                        <label for="date2" class="col-sm-5 col-form-label">Ngày 2</label>
                        <div class="col-sm-5">
                            <input type="date" name="date2" id="date2" class="form-control date-input @error('date2') is-invalid @enderror">
                            @error('date2')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary float-right">保存</button> 
            </div>
        </form>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script>
    document.querySelectorAll('.date-input').forEach(function (element) {
        element.addEventListener('change', checkDate);
    });

    function checkDate(event) {
        var date1 = document.getElementById('date1').value;
        var date2 = document.getElementById('date2').value;

        if (date1 && date2 && date1 > date2) {
            alert('Ngày 1 phải nhỏ hơn hoặc bằng Ngày 2');
            event.target.value = '';
        }
    }
</script>
@stop
