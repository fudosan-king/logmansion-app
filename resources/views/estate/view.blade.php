@extends('adminlte::page')

@section('title', config('estate_labels.estate_detail_title'))


@section('content_header')
    <h1>{{config('estate_labels.estate_detail_title')}}</h1>
@stop

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="">
                    <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card" id="step1">
                                    <div class="card-header">
                                        <h3 class="card-title"><strong>物件基本情報</strong></h3>
                                    </div>
                                    <div class="form-horizontal">
                                        <div class="card-body">
                                            <div class="row">
                                                <label for="estateName" class="col-sm-2 col-form-label">物件名 </label>
                                                <div class="col-sm-10 p-2">
                                                    <div>{{$estate->est_name ?? ""}}</div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label for="roomNo" class="col-sm-2 col-form-label">建物名・号室 </label>
                                                <div class="col-sm-10 p-2">
                                                    <div>{{$estate->est_room_no ?? ""}}</div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label for="address" class="col-sm-2 col-form-label">住所 </label>
                                                <div class="col-sm-10 row pl-1 ml-1">
                                                    <div class="row mr-1 mt-2 w-75">
                                                        <div class="col-sm-2">
                                                            {{$estate->est_zip ?? ""}}
                                                        </div>
                                                        <div class="col-sm-10">
                                                            {{$estate->est_pref}}{{$estate->est_city}}{{$estate->est_ward}}{{$estate->est_address}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title"><strong>お役立ち情報 </strong></h3>
                                    </div>
                                    <div class="form-horizontal">
                                        <div class="card-body">
                                            <table style="width:50%">
                                                <tr>
                                                    <td class="font-weight-bold">
                                                        <p>{{$estate->est_pref ?? ""}}</p>
                                                    </td>
                                                    <td>                     
                                                        <p>{{$estate->est_usefulinfo_pref_url ?? ""}}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="font-weight-bold">
                                                        <p>{{$estate->est_city ?? ""}}</p>
                                                    </td>
                                                    <td>  
                                                        <p>{{$estate->est_usefulinfo_city_url ?? ""}}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="font-weight-bold">
                                                        <p>{{$estate->est_ward ?? ""}}</p>
                                                    </td>
                                                    <td>      
                                                        <p>{{$estate->est_usefulinfo_ward_url ?? ""}}</p>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="card">
                                <div class="card-header">
                                        <h3 class="card-title"><strong>クライアント情報</strong></h3>
                                    </div>
                                    <div class="form-horizontal">
                                        <div class="card-body">
                                        <div class="w-100">
                                            <div class="row mb-2">
                                                <div class="col-md-3 font-weight-bold">
                                                    お客様番号
                                                </div>
                                                <div class="col-md-6">
                                                    {{$client->client_id ?? ""}}
                                                </div> 
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-md-3 font-weight-bold">
                                                    お名前
                                                </div>
                                                <div class="col-md-6">
                                                    {{$client->client_f_name ?? ""}}{{$client->client_l_name ?? ""}}
                                                </div> 
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-md-3 font-weight-bold">
                                                    お名前（フリガナ)
                                                </div>
                                                <div class="col-md-6">
                                                    {{$client->	client_furigana_firstname ?? ""}}{{$client->	client_furigana_lastname ?? ""}}
                                                </div> 
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-md-3 font-weight-bold">
                                                    電話番号
                                                </div>
                                                <div class="col-md-6">
                                                    {{$client->client_tel ?? ""}}
                                                </div> 
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-md-3 font-weight-bold">
                                                    メールアドレス
                                                </div>
                                                <div class="col-md-6">
                                                    {{$client->client_email ?? ""}}
                                                </div> 
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title"><strong>スケジュール</strong></h3>
                                    </div>
                                    <div class="form-horizontal">
                                        <div class="card-body">
                                            <table style="width:75%">
                                                <thead>
                                                    <tr>
                                                        <th class="text-nowrap p-4">スケジュール名</th>
                                                        <th class="text-nowrap p-4">日付</th>
                                                        <th class="text-nowrap p-4">説明文</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($estate_schedule as $schedule)
                                                    <tr class="mt-2">
                                                        <td class="px-4">                     
                                                            <p>{{$schedule->schedule_name ?? ""}}</p>
                                                        </td>
                                                        <td class="text-nowrap px-4">                     
                                                            <p>{{ $schedule->schedule_date ? \Carbon\Carbon::parse($schedule->schedule_date)->format('Y-m-d') : "" }}</p>
                                                        </td>
                                                        <td class="px-4">                     
                                                            <p>{{$schedule->schedule_description ?? ""}}</p>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title"><strong>資料アップロード</strong></h3>
                                    </div>
                                    <div class="form-horizontal">
                                        <div class="card-body">
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th class="px-4 text-nowrap">カテゴリー</th>
                                                        <th class="px-4 text-nowrap">ファイル名</th>
                                                        <th class="px-4 text-nowrap">説明文</th>
                                                        <th class="px-4 text-nowrap"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($estate_document as $doc)
                                                    <tr class="px-4">
                                                        <td class="px-4 text-nowrap">
                                                            @php
                                                            if($doc['doc_category']===3 || $doc['doc_category']===4){
                                                                $label = $doc['doc_category']===3 ? '決済までの流れ' : '保証期間';
                                                            }else{
                                                                $category_doc = config('const.category_doc');
                                                                $label = isset($category_doc[$doc['doc_category']]) ? $category_doc[$doc['doc_category']] : '';
                                                            }
                                                            echo $label;
                                                            @endphp
                                                        </td>
                                                        <td class="px-4">{{ $doc['doc_name'] ?? basename($doc['doc_file']) }}</td>
                                                        <td class="px-4">{{ $doc['doc_description'] ?? "" }}</td>
                                                        <td class="px-4">
                                                            @php
                                                            $file_name = basename($doc['doc_file']);
                                                            $cleaned_file_name = preg_replace('/^\d{14}_/', '', $file_name);
                                                            @endphp
                                                            <a href="{{ Storage::url($doc['doc_file']) }}" download="{{ $cleaned_file_name }}">
                                                                <i class="fas fa-download"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 text-center">
                                <a href="{{route('estate.archive_index')}}" class="btn btn-default mr-2">キャンセル</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@stop


@section('js')
    
@stop

