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
                                                <div class="col-sm-10">
                                                    <div>{{$estate->est_name ?? ""}}</div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label for="roomNo" class="col-sm-2 col-form-label">建物名・号室 </label>
                                                <div class="col-sm-10">
                                                    <div>{{$estate->est_room_no ?? ""}}</div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label for="address" class="col-sm-2 col-form-label">住所 </label>
                                                <div class="col-sm-10 row pl-1 ml-1">
                                                    <div class="row mr-1 mt-2 w-75">
                                                        <div class="col-sm-2">
                                                            <!-- <label for="select_prefectures">郵便番号入力 </label> -->
                                                            <div></div>
                                                            {{$estate->est_zip ?? ""}}
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <!-- <label for="select_prefectures">都道府県 </label> -->
                                                            <div>{{$estate->est_pref ?? ""}}</div>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <!-- <label for="select_city">市・区 </label> -->
                                                            <div>{{$estate->est_city ?? ""}}</div>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <!-- <label for="select_ward">区町村</label> -->
                                                            <div>{{$estate->est_ward ?? ""}}</div>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <!-- <label for="select_street">丁目・番地</label> -->
                                                            <div>{{$estate->est_address ?? ""}}</div>
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
                                        <h3 class="card-title"><strong>スケジュール</strong></h3>
                                    </div>
                                    <div class="form-horizontal">
                                        <div class="card-body">
                                            <table style="width:50%">
                                                <tr class="mt-2">
                                                    <th>スケジュール名</th>
                                                    <th>日付</th>
                                                    <th>説明文</th>
                                                </tr>
                                                @foreach($estate_schedule as $schedule)
                                                <tr class="mt-2">
                                                    <td>                     
                                                        <p>{{$schedule->schedule_name ?? ""}}</p>
                                                    </td>
                                                    <td>                     
                                                        <p>{{ $schedule->schedule_date ? \Carbon\Carbon::parse($schedule->schedule_date)->format('Y-m-d') : "" }}</p>
                                                    </td>
                                                    <td>                     
                                                        <p>{{$schedule->schedule_description ?? ""}}</p>
                                                    </td>
                                                </tr>
                                                @endforeach
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
                                            @foreach($estate_document as $doc)
                                                    <div class="col doc-section w-50">
                                                        <div class="row doc-row">
                                                            <div class="col">
                                                                <p class="font-weight-bold">
                                                                    @php
                                                                        if($doc['doc_category']===3 || $doc['doc_category']===4){
                                                                            $label = $doc['doc_category']===3 ? '決済までの流れ' : '保証期間';
                                                                        }else{
                                                                            $category_doc = config('const.category_doc');
                                                                            $label = isset($category_doc[$doc['doc_category']]) ? $category_doc[$doc['doc_category']] : '';
                                                                        }
                                                                        echo $label;
                                                                    @endphp
                                                                </p>
                                                            </div>
                                                            <div class="col">
                                                                <div class="">
                                                                    {{$doc['doc_name'] ?? ""}}
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="">
                                                                    {{$doc['doc_description'] ?? ""}}
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-1 download-pdf">
                                                                <span class="icon">
                                                                    @php $file_name = basename($doc['doc_file']); $cleaned_file_name = preg_replace('/^\d{14}_/', '', $file_name); @endphp
                                                                    <a href="{{ Storage::url($doc['doc_file']) }}" download="{{ $cleaned_file_name }}">
                                                                        <i class="fas fa-download"></i>
                                                                    </a>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
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

