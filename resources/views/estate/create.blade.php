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
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{route('estate.store')}}" method="post">
            @csrf
            <div class="card" id="step1">
                <div class="card-header">
                    <h3 class="card-title"><strong>① 物件基本情報</strong></h3>
                </div>
                <div class="form-horizontal">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="estateName" class="col-sm-2 col-form-label">物件名</label>
                            <div class="col-sm-10">
                                <input required maxlength="255" type="text" value="{{old('est_name')}}" class="form-control" name="est_name" id="estateName" placeholder="物件名" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="roomNo" class="col-sm-2 col-form-label">建物名・号室</label>
                            <div class="col-sm-10">
                                <input required type="text" value="{{old('est_room_no')}}" class="form-control" name="est_room_no" id="roomNo" placeholder="建物名・号室" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="address" class="col-sm-2 col-form-label">住所</label>
                            <div class="col-sm-10 row">
                                <input type="text" value="{{old('zip22')}}" class="form-control col-sm-4 m-2" name="zip22" size="7" maxlength="7" placeholder="Zip Code">
                                <span class="mt-3">郵便番号入力補助</span>
                                <div class="row container mr-1">
                                    <div class="form-group col-sm-3">
                                        <label for="select_prefectures">都道府県</label>
                                        <input id="select_prefectures" value="{{old('pref21')}}" name="pref21" class="form-control d-inline">
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label for="select_city">市・区</label>
                                        <input type="text" id="select_city" value="{{old('addr21')}}" name="addr21" class="form-control d-inline">
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label for="select_ward">区町村</label>
                                        <input type="text" id="select_ward" value="{{old('strt21')}}" name="strt21" class="form-control d-inline">
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label for="select_street">丁目・番地</label>
                                        <input type="text" id="select_street" value="{{old('street')}}" name="street" class="form-control d-inline">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card" id="step2">
                <div class="card-header">
                    <h3 class="card-title"><strong>② お役立ち情報 </strong></h3>
                </div>
                <div class="form-horizontal">
                    <div class="card-body d-flex justify-content-center flex-column align-items-center">
                        <div class="" style="width:50%">
                            <div onclick="getURL()" class="btn btn-info float-right">情報を読み込む</div>
                        </div>
                        <table style="width:50%">
                            <tr>
                                <th>物件所在地</th>
                                <th></th>
                                <th></th>
                            </tr>
                            <tr>
                                <td>
                                    <input id="selected_prefectures" readonly placeholder="都道府県" class="form-control">
                                </td>
                                <td>                                
                                    <input type="text" value="{{old('selected_pref_url')}}" class="form-control m-2" id="selected_pref_url" name="selected_pref_url">
                                </td>
                                <td>
                                    <div class="custom-control custom-switch ml-4">
                                        <input checked type="checkbox" class="custom-control-input" name="showLinkstatus1" id="hideUnhideLink1">
                                        <label class="custom-control-label" for="hideUnhideLink1">掲載</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input id="selected_city" readonly placeholder="市・区 " class="form-control">
                                </td>
                                <td>                                
                                    <input type="text" value="{{old('selected_city_url')}}" class="form-control m-2" id="selected_city_url" name="selected_city_url">
                                </td>
                                <td>
                                    <div class="custom-control custom-switch ml-4">
                                        <input checked type="checkbox" class="custom-control-input" name="showLinkstatus2" id="hideUnhideLink2">
                                        <label class="custom-control-label" for="hideUnhideLink2">掲載</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input id="selected_ward" readonly placeholder="区町村" class="form-control">
                                </td>
                                <td>                                
                                    <input  type="text" value="{{old('selected_ward_url')}}" class="form-control m-2" id="selected_ward_url" name="selected_ward_url">
                                </td>
                                <td>
                                    <div class="custom-control custom-switch ml-4">
                                        <input checked type="checkbox" class="custom-control-input" name="showLinkstatus3" id="hideUnhideLink3">
                                        <label class="custom-control-label" for="hideUnhideLink3">掲載</label>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="card-footer d-flex justify-content-center">
                        <button type="submit" class="btn btn-info" id="finish_step2">物件新規追加</button>
                    </div>
                </form>
            </div>
        </form>
      </div>
    </div>
  </div>
</section>
@stop



@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>
    <script>
         $('[name="zip22"]').on('keyup', function() {
            $('[name="pref21"]').val('');
            $('[name="addr21"]').val('');
            $('[name="strt21"]').val('');
            $('[name="street"]').val('');
            $('#selected_prefectures').val('');
            $('#selected_city').val('');
            $('#selected_ward').val('');
            AjaxZip3.zip2addr(this,'','pref21','addr21','strt21');
            let checkInterval = setInterval(function() {
                if ($('[name="pref21"]').val() && $('[name="addr21"]').val()) {
                    clearInterval(checkInterval);
                    let pref = $('input[name="pref21"]').val();
                    let city = $('input[name="addr21"]').val();
                    let ward = $('input[name="strt21"]').val();
                    if(city.length>=6){
                        let firstText = city.substring(0, city.length / 2);
                        let secondText = city.substring(city.length / 2);
                        if(ward){
                            $('#select_street').val(ward);
                        }
                        city = firstText;
                        ward = secondText; 
                        $('input[name="addr21"]').val(firstText);
                        $('input[name="strt21"]').val(ward);
                    }
                    if(city.length==5){
                        let firstText = city.substring(0, 3);
                        let secondText = city.substring(3);
                        if(ward){
                            $('#select_street').val(ward);
                        }
                        city = firstText;
                        ward = secondText; 
                        $('input[name="addr21"]').val(firstText);
                        $('input[name="strt21"]').val(ward);
                    }
                    $('#selected_prefectures').val(pref);
                    $('#selected_city').val(city);
                    $('#selected_ward').val(ward);
                    getURL();
                }
            }, 200);
        });
        // $('[name="zip22"]').on('keyup', function() {
        //     $('input[name="pref21"]').val('');
        //     $('input[name="addr21"]').val('');
        //     $('input[name="strt21"]').val('');
        //     AjaxZip3.zip2addr(this,'','pref21','addr21','strt21')
        //     let pref = $('input[name="pref21"]').val();
        //     let city = $('input[name="addr21"]').val();
        //     let ward = $('input[name="strt21"]').val();
        //     $('#selected_prefectures').val(pref);
        //     $('#selected_city').val(city);
        //     $('#selected_ward').val(ward);
        //     getURL();
        // });
        // $('[name="zip22"]').on('focusout', function() {
        //     let pref = $('input[name="pref21"]').val();
        //     let city = $('input[name="addr21"]').val();
        //     let ward = $('input[name="strt21"]').val();
        //     $('#selected_prefectures').val(pref);
        //     $('#selected_city').val(city);
        //     $('#selected_ward').val(ward);
        //     getURL();
        // });
        $('[name="pref21"]').on('keyup', function() {
            $('#selected_prefectures').val(this.value);
        });
        $('[name="addr21"]').on('keyup', function() {
            $('#selected_city').val(this.value);
        });
        $('[name="strt21"]').on('keyup', function() {
            $('#selected_ward').val(this.value);
        });
        @if ($errors->any())
            $(document).ready(function() {
                $('#selected_prefectures').val($('[name="pref21"]').val());
                $('#selected_city').val($('[name="addr21"]').val());
                $('#selected_ward').val($('[name="strt21"]').val());
            });
        @endif
        
    </script>
    <script>
        const csvUrl = '/csv/listURL.csv';
        var dataUrlCsv;
        const fetchDataCSV = () => {
            return new Promise((resolve, reject) => {
                Papa.parse(csvUrl, {
                    download: true,
                    header: true,
                    complete: function(results) {
                        resolve(results.data);
                    },
                    error: function(err) {
                        reject(err);
                    }
                });
            });
        }
        (async () => {
            try {
                dataUrlCsv = await fetchDataCSV();
            } catch (err) {
                console.error(err);
            }
        })();
        const getURL = ()=>{
            let pref = $('#selected_prefectures').val();
            let city = $('#selected_city').val();
            let ward = $('#selected_ward').val();
            // $('#error_message').hide();
            if (pref !== '') {
                let urlPref = dataUrlCsv.find((data) => data.name.includes(pref));
                if (urlPref) {
                    $('#selected_pref_url').val(urlPref.URL || '');
                } else {
                    $('#selected_pref_url').val('');
                    $('#error_message').show();
                }
            }else{
                $('#selected_pref_url').val('');
            }
            if (city !== '') {
                let urlCity = dataUrlCsv.find((data) => data.name.includes(city));
                if (urlCity) {
                    $('#selected_city_url').val(urlCity.URL || '');
                } else {
                    $('#selected_city_url').val('');
                }
            }else{
                $('#selected_city_url').val('');
            }
            if (ward !== '') {
                let urlWard = dataUrlCsv.find((data) => data.name.includes(ward));
                if (urlWard) {
                    $('#selected_ward_url').val(urlWard.URL || '');
                } else {
                    $('#selected_ward_url').val('');
                }
            }else{
                $('#selected_ward_url').val('');
            }
        }
    </script>
    <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
@stop