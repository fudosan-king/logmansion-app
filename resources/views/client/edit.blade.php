@extends('adminlte::page')

@section('title', config('client_labels.client_info'))

@section('content_header')
    <h1>{{config('client_labels.client_info')}}</h1>
@stop
@section('css')
    <meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS">
@stop

@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12" >
            @csrf
            <div class="card" id="step2">
                <div class="form-horizontal">
                    <form method="POST" action="{{route('client.update',['id'=>$client->id])}}" novalidate>
                        @csrf
                        @method('PUT')
                        <div class="card-body d-flex justify-content-center flex-column align-items-center">
                            <h3 class="">{{$client->estateName}}</h3>
                            <div class="w-75 mt-4">
                                <input type="hidden" value="{{$client->est_id}}" name="est_id">
                                <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label">{{config('client_labels.custome_number')}} <span class="text-danger">※</span></label>
                                    <div class="col-sm-3">
                                        <div>{{$client->first_name}}</div>
                                        <input required readonly name="client_id" value="{{$client->client_id}}" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">氏名 <span class="text-danger">※</span></label>
                                    <div class="col-sm-4">
                                        <label for="">姓 <span class="text-danger">※</span></label>
                                        <input value="{{old('client_f_name')?? $client->client_f_name}}" required maxlength="500" name="first_name" type="text" class="form-control">
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="">名 <span class="text-danger">※</span></label>
                                        <input value="{{old('client_l_name')?? $client->client_l_name}}" required name="last_name" maxlength="500" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3">氏名（フリガナ) </label>
                                    <div class="col-sm-4">
                                        <label for="">セイ</label>
                                        <input value="{{ old('client_furigana_firstname') ?? $client->client_furigana_firstname }}"  name="first_name_furi" maxlength="500" type="text" class="form-control">
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="" for="">メイ</label>
                                        <input value="{{ old('last_name_furi') ??  $client->client_furigana_lastname}}"  name="last_name_furi" maxlength="500" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3">電話番号 <span class="text-danger">※</span></label>
                                    <div class="col-sm-4">
                                        <input value="{{ old('telephone') ??  $client->client_tel}}" maxlength="10" required name="telephone" type="number" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3">メールアドレス <span class="text-danger">※</span></label>
                                    <div class="col-sm-4">
                                        <input value="{{ old('email')??  $client->client_email}}" required name="email" type="email" class="form-control @error('email') is-invalid @enderror">
                                        @error('email')
                                            <div class="d-inline invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-center">
                            <a href="{{route('estate.index')}}" class="btn btn-default mr-2">キャンセル</a>
                            @if ($client->client_f_name && $client->client_l_name)
                                <div id="delete_client" class="btn btn-danger mr-2 delete-button">削除</div>
                            @endif
                            <button type="submit" class="btn btn-primary" id="finish_step2">保存</button>
                        </div>
                    </form>
                </div>
            </div>
      </div>
    </div>
  </div>
</section>
@stop



@section('js')
<script>
    $('form').on('submit', function(e) {
        e.preventDefault();
        $('.invalid-feedback').remove();
        let isValid = true;
        $(this).find(':input[required]').each(function() {
            if (!$(this).val()) {
                $(this).addClass('is-invalid');
                $(this).after('<div class="d-block invalid-feedback">この項目は必須です。</div>');
                isValid = false;
            }else{
                $(this).removeClass('is-invalid');
            }
        });
        //input name telephone
        let phone = $(this).find('input[name="telephone"]').val();
        if(phone){
            if (!/^\d+$/.test(phone)) {
                $(this).find('input[name="telephone"]').addClass('is-invalid');
                $(this).find('input[name="telephone"]').after('<div class="d-block invalid-feedback">無効な形式です。</div>');
                isValid = false;
            } else {
                $(this).find('input[name="telephone"]').removeClass('is-invalid');
            }
        }
        //inoput name email
        let email = $(this).find('input[name="email"]').val();
        if(email){
            let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if(!emailPattern.test(email)){
                $(this).find('input[name="email"]').addClass('is-invalid');
                $(this).find('input[name="email"]').after('<div class="d-block invalid-feedback">無効な形式です。</div>');
                isValid = false;
            } else {
                $(this).find('input[name="email"]').removeClass('is-invalid');
            }
        }
        if(isValid){
            this.submit();
        }
       
    });
       $('input').on('input', function() {
          this.value = this.value.replace(/^\s+/, '');
       });
       $('input[type="number"]').on('input', function() {
          if (this.value.length > 15) {
             this.value = this.value.slice(0, 15);
          }
          this.value = this.value.replace(/[^0-9]/g, '');
          
       });
    </script>
<script>
    $('#delete_client').on('click', function(e) {
        e.preventDefault();
        if (confirm('クライアントを削除しますか？')) {
            $.ajax({
                url: "{{ route('client.destroy', ['id' => $client->id]) }}",
                type: "DELETE",
                success: function(response) {
                    window.location.href = "{{ route('client.edit',['id'=>$client->id]) }}";
                }
            });
        }
    });
</script>
</script>
</script>
@stop
@section('plugins.Select2', true)
