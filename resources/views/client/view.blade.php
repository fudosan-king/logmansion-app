@extends('adminlte::page')

@section('title', config('client_labels.client_info'))


@section('content_header')
    <h1>{{ config('client_labels.client_info') }}</h1>
@stop
@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <style>
        .action_bar{
            display: flex;
            justify-content: center;
            gap: 30px;
        }
        .action_bar i{
            font-size:25px;
            cursor: pointer;
        }
        @media print {
            body *:not(.printable) {
                display: none;
            }
        }
    </style>
@stop

@section('content')
<section id="content" class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body d-flex justify-content-center flex-column align-items-center">
            <div class="w-75 d-flex flex-column align-items-center">
                <div>
                    <h2 class="text-center">{{$client->estateName}}</h2>
                    <h3 class="text-center">{{config('client_labels.client_view_infomation')}}</h3>

                </div>
                <div class="w-50">
                    <div class="row mb-2 d-flex justify-content-center">
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-4 font-weight-bold">
                            {{config('client_labels.custome_number')}}
                        </div>
                        <div class="col-md-6">
                            {{$client->client_id}}
                        </div> 
                    </div>
                    <div class="row mb-2 d-flex justify-content-center">
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-4 font-weight-bold">
                            お名前
                        </div>
                        <div class="col-md-6">
                            {{$client->client_f_name}} {{$client->client_l_name}}
                        </div> 
                    </div>
                    <div class="row mb-2 d-flex justify-content-center">
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-4 font-weight-bold">
                            お名前（フリガナ）
                        </div>
                        <div class="col-md-6">
                            {{$client->	client_furigana_firstname}} {{$client->	client_furigana_lastname}}
                        </div> 
                    </div>
                    <div class="row mb-2 d-flex justify-content-center">
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-4 font-weight-bold">
                            電話番号
                        </div>
                        <div class="col-md-6">
                            {{$client->client_tel}}
                        </div> 
                    </div>
                    <div class="row mb-2 d-flex justify-content-center">
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-4 font-weight-bold">
                            メールアドレス
                        </div>
                        <div class="col-md-6">
                            {{$client->client_email}}
                        </div> 
                    </div>
                </div>
                <div class="w-100 text-center mt-4">
                    <a href="{{route('estate.index')}}" class="btn btn-default mr-2">キャンセル</a>
                    <button class="btn btn-primary printf" onclick="printDiv()">印刷</button>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<div class="printable" id="printableArea" style="display:none">
   <div style="display:flex;justify-content:space-between;align-items:center;width:100%">
        <div class="">{{$client->client_f_name}} {{$client->client_l_name}}</div>
        <div>
            <span>{{config('client_labels.custome_number')}}</span>
           <span> {{$client->client_id}} </span>
        </div>
   </div>
   <div style="display:flex;justify-content:center;">
        購入者アプリのご案内
    </div>
    <div style="text-align:center">
        ◎◎▼◎▼◎▼◎▼＠＄＾＊＊））））＄＃◎◎▼◎▼◎▼◎▼＠＄＾＊＊））））＄＃！＄＄
        ◎◎▼◎▼◎▼◎▼＠＄＾＊＊））））＄＃◎◎▼◎▼◎▼◎▼＠＄＾＊＊））））＄＃！＄＄
        ◎◎▼◎▼◎▼◎▼＠＄＾＊＊））））＄＃◎◎▼◎▼◎▼◎▼＠＄＾＊＊））））＄＃！＄＄
        ◎◎▼◎▼◎▼◎▼＠＄＾＊＊））））＄＃◎◎▼◎▼◎▼◎▼＠＄＾＊＊））））＄＃！＄＄
        ◎◎▼◎▼◎▼◎▼＠＄＾＊＊））））＄＃◎◎▼◎▼◎▼◎▼＠＄＾＊＊））））＄＃！＄＄
        ◎◎▼◎▼◎▼◎▼＠＄＾＊＊））））＄＃◎◎▼◎▼◎▼◎▼＠＄＾＊＊））））＄＃！＄＄
        ◎◎▼◎▼◎▼◎▼＠＄＾＊＊））））＄＃◎◎▼◎▼◎▼◎▼＠＄＾＊＊））））＄＃！＄＄
    </div>
    <div style="text-align:center">
        <img style="width:400px" src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/d0/QR_code_for_mobile_English_Wikipedia.svg/1024px-QR_code_for_mobile_English_Wikipedia.svg.png" alt="">
    </div>
    <div style="text-align:center">
        <p>ダウンロードしてください</p>
    </div>
    <div style="text-align:center">
        <p>右上のお客様番号を入力してPW登録してください</p>
    </div>
</div>
@stop


@section('js')
<script>
    function printDiv() {
        var divContents = document.getElementById("printableArea").innerHTML;
        var printWindow = window.open('', '', '');
        printWindow.document.write('<html>');
        printWindow.document.write('<body>');
        printWindow.document.write(divContents);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
        printWindow.close();
    }
</script>
@stop

