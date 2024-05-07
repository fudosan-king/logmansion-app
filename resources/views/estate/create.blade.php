@extends('adminlte::page')

@section('title', 'Create Estate')

@section('content_header')
    <h1>Estate Create</h1>
@stop
@section('css')
    <meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS">
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12" >
        <div class="card" id="step1">
            <div class="card-header">
                <h3 class="card-title"><strong>① 物件基本情報 Basic Information</strong> ▶ ② お役立ち情報 ▶  完了</h3>
            </div>
            <form class="form-horizontal">
                <div class="card-body">
                    <div class="form-group row">
                        <label for="estateName" class="col-sm-2 col-form-label">Estate name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="estateName" placeholder="Estate name" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="roomNo" class="col-sm-2 col-form-label">Room no</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="roomNo" placeholder="Room No" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="address" class="col-sm-2 col-form-label">Address</label>
                        <div class="col-sm-10 row">
                            <input type="text" class="form-control col-sm-4 m-2" id="address" name="zip22" size="7" maxlength="7" onKeyUp="AjaxZip3.zip2addr(this,'','pref21','addr21','strt21');">
                            <span class="mt-3">郵便番号入力補助</span>
                            <div class="row container mr-1">
                                <div class="form-group col-sm-3">
                                    <label for="select_prefectures">都道府県</label>
                                    <input id="select_prefectures" name="pref21" class="form-control d-inline">
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for="select_city">市・区</label>
                                    <input type="text" id="select_city" name="addr21" class="form-control d-inline">
                                   
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for="select_ward">区町村</label>
                                    <input type="text" id="select_ward" name="strt21" class="form-control d-inline">
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for="select_street">丁目・番地</label>
                                    <input type="text" id="select_street"  class="form-control d-inline">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                       
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-center">
                    <div type="submit" id="finish_step1" class="btn btn-info">Next</div>
                </div>
            </form>
        </div>
        <div class="card" id="step2">
            <div class="card-header">
                <h3 class="card-title">① 物件基本情報 Basic Information▶ ② <strong>お役立ち情報 </strong> ▶完了</h3>
            </div>
            <form class="form-horizontal">
                <div>
                    <button class="btn btn-info">情報を読み込む</button>
                </div>
                <div class="card-body d-flex justify-content-center">
                    <table style="">
                        <tr>
                            <th>物件所在地</th>
                            <th>URL</th>
                            <th>Action</th>
                        </tr>
                        <tr>
                            <td>
                                <input id="selected_prefectures" placeholder="都道府県" class="form-control m-2">
                            </td>
                            <td>                                
                                <input type="text" class="form-control m-2" id="selected_pref_url">
                            </td>
                            <td>
                                <div class="btn-group ml-2" role="group" aria-label="Basic example">
                                   
                                    <button class="btn btn-secondary d-block" id="hide_city_url">掲載</button>
                                <div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input id="selected_city" placeholder="市・区 " class="form-control m-2">
                            </td>
                            <td>                                
                                <input type="text" class="form-control m-2" id="selected_city_url">
                            </td>
                            <td>
                                <div class="btn-group ml-2" role="group" aria-label="Basic example">
                                   
                                    <button class="btn btn-secondary d-block" id="hide_city_url">掲載</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input id="selected_ward" placeholder="区町村" class="form-control m-2">
                            </td>
                            <td>                                
                                <input type="text" class="form-control m-2" id="selected_ward_url">
                            </td>
                            <td>
                                <div class="btn-group ml-2"" role="group" aria-label="Basic example">
                                   
                                    <button class="btn btn-secondary d-block" id="hide_ward_url">掲載</button>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="card-footer d-flex justify-content-center">
                    <div type="submit" class="btn btn-danger mr-4" id="back_to_step1">Back</div>
                    <date_interval_format type="submit" class="btn btn-info" id="finish_step2">Submit</date_interval_format>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>
</section>
@stop



@section('js')
    <script>
        //Handle next step
        $('#step2').hide();
        $('#finish_step1').click(function(){
            $('#step1').hide();
            $('#step2').show();
            let pref = $('input[name="pref21"]').val();
            let city = $('input[name="addr21"]').val();
            let ward = $('input[name="strt21"]').val();
            $('#selected_prefectures').val(pref);
            $('#selected_city').val(city);
            $('#selected_ward').val(ward);
        });
        $('#back_to_step1').click(function(){
            $('#step2').hide();
            $('#step1').show();
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>
    <script>
        // Lấy đường dẫn đến file CSV
        const csvUrl = '/csv/listURL.csv';

        // Sử dụng Papa Parse để tải và phân tích file CSV
        // Papa.parse(csvUrl, {
        //     download: true,
        //     header: true,
        //     complete: function(results) {
        //         console.log(results.data);
        //     }
        // });
        fetch(csvUrl)
        .then(response => response.arrayBuffer())
        .then(buffer => {
            const decoder = new TextDecoder('utf-8');
            const csv = decoder.decode(buffer);
            return Papa.parse(csv, {header: true});
        })
        .then(results => console.log(results.data));
    </script>
    <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
@stop