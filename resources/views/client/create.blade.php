@extends('adminlte::page')

@section('title', 'クライアント登録')

@section('content_header')
    <h1>クライアント登録</h1>
@stop
@section('css')
    <meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS">
@stop

@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12" >
        
        <form novalidate action="{{route('client.store')}}" method="post">
            @csrf
            <div class="card" id="step2">
                <div class="card-header">
                    <h3 class="card-title"><strong>クライアント登録</strong></h3>
                </div>
                <div class="form-horizontal">
                    <form method="POST" action="{{route('client.store')}}">
                        @csrf
                        <div class="card-body d-flex justify-content-center flex-column align-items-center">
                            <h3 class="">{{$estateName}}</h3>
                            <div class="w-75 mt-4">
                                <h4 class="mb-2">クライアント登録</h4>
                                <input type="hidden" value="{{$est_id}}" name="est_id">
                                <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label">クライアントID <span class="text-danger">※</span></label>
                                    <div class="col-sm-3">
                                        <input required readonly name="client_id" value="{{$genClientid}}" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">氏名 <span class="text-danger">※</span></label>
                                    <div class="col-sm-4">
                                        <label for="">姓 <span class="text-danger">※</span></label>
                                        <input value="{{ old('first_name') }}" required maxlength="500" name="first_name" type="text" class="form-control">
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="">名 <span class="text-danger">※</span></label>
                                        <input value="{{ old('last_name') }}" required name="last_name" maxlength="500" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3">氏名（フリガナ）<span class="text-danger">※</span></label>
                                    <div class="col-sm-4">
                                        <label for="">セイ <span class="text-danger">※</span></label>
                                        <input value="{{ old('first_name_furi') }}" required name="first_name_furi" maxlength="500" type="text" class="form-control">
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="" for="">メイ <span class="text-danger">※</span></label>
                                        <input value="{{ old('last_name_furi') }}" required name="last_name_furi" maxlength="500" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3">電話番号 <span class="text-danger">※</span></label>
                                    <div class="col-sm-4">
                                        <input value="{{ old('telephone') }}" maxlength="10" required name="telephone" type="number" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3">メールアドレス <span class="text-danger">※</span></label>
                                    <div class="col-sm-4">
                                        <input value="{{ old('email') }}" required name="email" type="email" class="form-control @error('email') is-invalid @enderror">
                                        @error('email')
                                            <div class="d-inline invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-center">
                            <a href="{{route('estate.index')}}" class="btn btn-default mr-2">キャンセル</a>
                            <button type="submit" class="btn btn-primary" id="finish_step2">保存</button>
                        </div>
                    </form>
                </div>
            </div>
        </form>
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
        //validate furigana for input name first_name_furi and last_name_furi
        // let first_name_furi = $(this).find('input[name="first_name_furi"]').val();
        // let last_name_furi = $(this).find('input[name="last_name_furi"]').val();
        // if(first_name_furi){
        //     if(/^[ぁ-んァ-ヶーa-zA-Z0-9一-龠々〆〤]+$/u.test(first_name_furi)){
        //         $(this).find('input[name="first_name_furi"]').addClass('is-invalid')
        //         $(this).find('input[name="first_name_furi"]').after('<div class="d-block invalid-feedback">無効な形式です。</div>');
        //         isValid = false;
        //     } else {
        //         $(this).find('input[name="first_name_furi"]').removeClass('is-invalid');
        //     }
        // }
        // if(last_name_furi){
        //     if(/^[ぁ-んァ-ヶーa-zA-Z0-9一-龠々〆〤]+$/u.test(last_name_furi)){
        //         $(this).find('input[name="last_name_furi"]').addClass('is-invalid')
        //         $(this).find('input[name="last_name_furi"]').after('<div class="d-block invalid-feedback">無効な形式です。</div>');
        //         isValid = false;
        //     } else {
        //         $(this).find('input[name="last_name_furi"]').removeClass('is-invalid');
        //     }
        // }
        if(isValid){
            this.submit();
        }
       
    });
</script>
<script>
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
@stop
@section('plugins.Select2', true)
