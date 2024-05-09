@extends('adminlte::page')

@section('title', 'Edit Estate')

@section('content_header')
    <h1>Edit Estate</h1>
@stop
@section('css')
    <meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS">
@stop

@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12" >
        <form action="{{route('estate.update',['id'=>$estate->est_id])}}" method="POST">
            @csrf
            @method('PUT')
            <div class="card" id="step1">
                <div class="card-header">
                    <h3 class="card-title"><strong>① 物件基本情報</strong> </h3>
                </div>
                <div class="form-horizontal">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="estateName" class="col-sm-2 col-form-label">Estate name</label>
                            <div class="col-sm-10">
                                <input value="{{$estate->est_name}}" type="text" class="form-control" name="est_name" id="estateName" placeholder="Estate name" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="roomNo" class="col-sm-2 col-form-label">Room no</label>
                            <div class="col-sm-10">
                                <input value="{{$estate->est_room_no}}" type="text" class="form-control" name="est_room_no" id="roomNo" placeholder="Room No" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="address" class="col-sm-2 col-form-label">Address</label>
                            <div class="col-sm-10 row">
                                <input value="{{$estate->est_zip}}" type="text" class="form-control col-sm-4 m-2" name="zip22" size="7" maxlength="7" ">
                                <span class="mt-3">郵便番号入力補助</span>
                                <div class="row container mr-1">
                                    <div class="form-group col-sm-3">
                                        <label for="select_prefectures">都道府県</label>
                                        <input value="{{$estate->est_pref}}" id="select_prefectures" name="pref21" class="form-control d-inline">
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label for="select_city">市・区</label>
                                        <input value="{{$estate->est_city}}" type="text" id="select_city" name="addr21" class="form-control d-inline">
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label for="select_ward">区町村</label>
                                        <input value="{{$estate->est_ward}}" type="text" id="select_ward" name="strt21" class="form-control d-inline">
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label for="select_street">丁目・番地</label>
                                        <input value="{{$estate->est_address}}" type="text" id="select_street" name="street" class="form-control d-inline">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card" id="step2">
                <div class="card-header">
                    <h3 class="card-title"> <strong>② お役立ち情報 </strong></h3>
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
                                    <input value="{{$estate->est_pref}}" id="selected_prefectures" readonly class="form-control">
                                </td>
                                <td>                                
                                    <input value="{{$estate->est_usefulinfo_pref_url}}" type="url" class="form-control m-2" id="selected_pref_url" name="selected_pref_url">
                                </td>
                                <td>
                                    <div class="custom-control custom-switch ml-4">
                                        <input {{ $estate->est_usefulinfo_pref_show == 1 ? 'checked' : '' }} type="checkbox" class="custom-control-input" name="showLinkstatus1" id="hideUnhideLink1">
                                        <label class="custom-control-label" for="hideUnhideLink1">掲載</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input value="{{$estate->est_city}}" id="selected_city" readonly class="form-control">
                                </td>
                                <td>                                
                                    <input value="{{$estate->est_usefulinfo_city_url}}" type="url" class="form-control m-2" id="selected_city_url" name="selected_city_url">
                                </td>
                                <td>
                                    <div class="custom-control custom-switch ml-4">
                                        <input {{ $estate->est_usefulinfo_city_show == 1 ? 'checked' : '' }} type="checkbox" class="custom-control-input" name="showLinkstatus2" id="hideUnhideLink2">
                                        <label class="custom-control-label" for="hideUnhideLink2">掲載</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input value="{{$estate->est_ward}}" id="selected_ward" readonly class="form-control">
                                </td>
                                <td>                                
                                    <input value="{{$estate->est_usefulinfo_ward_url}}" type="url" class="form-control m-2" id="selected_ward_url" name="selected_ward_url">
                                </td>
                                <td>
                                    <div class="custom-control custom-switch ml-4">
                                        <input {{ $estate->est_usefulinfo_ward_show == 1 ? 'checked' : '' }} type="checkbox" class="custom-control-input" name="showLinkstatus3" id="hideUnhideLink3">
                                        <label class="custom-control-label" for="hideUnhideLink3">掲載</label>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <!-- <div>
                            <div id="error_message" class="alert alert-warning alert-dismissible fade show" role="alert">
                                リストに存在しない地名で.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div> -->
                    </div>
                    <div class="card-footer d-flex justify-content-center">
                        <button type="submit" class="btn btn-info" id="finish_step2">Update Estate</button>
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
    <script>
        // lắng nghe sự kiện onkeyup của input có name là zip22
        $('[name="zip22"]').on('keyup', function() {
            AjaxZip3.zip2addr(this,'','pref21','addr21','strt21')
            let pref = $('input[name="pref21"]').val();
            let city = $('input[name="addr21"]').val();
            let ward = $('input[name="strt21"]').val();
            $('#selected_prefectures').val(pref);
            $('#selected_city').val(city);
            $('#selected_ward').val(ward);
            getURL();
        });
        $('[name="pref21"]').on('keyup', function() {
            $('#selected_prefectures').val(this.value);
        });
        $('[name="addr21"]').on('keyup', function() {
            $('#selected_city').val(this.value);
        });
        $('[name="strt21"]').on('keyup', function() {
            $('#selected_ward').val(this.value);
        });
    </script>
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>
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
            if (pref !== '') {
                let urlPref = dataUrlCsv.find((data) => data.name.includes(pref));
                if (urlPref) {
                    $('#selected_pref_url').val(urlPref.URL || '');
                } else {
                    $('#selected_pref_url').val('');
                    // $('#error_message').show();
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
                    // $('#error_message').show();
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
                    // $('#error_message').show();
                }
            }else{
                $('#selected_ward_url').val('');
            }
        }
    </script>
    <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
@stop