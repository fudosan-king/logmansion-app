@extends('adminlte::page')

@section('title', '物件編集')

@section('content_header')
    <h1>物件編集</h1>
@stop
@section('css')
    <meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS">
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
        <form novalidate action="{{route('estate.update',['id'=>$estate->est_id])}}" method="POST">
            @csrf
            @method('PUT')
            <div class="card" id="step1">
                <div class="card-header">
                    <h3 class="card-title"><strong>① 物件基本情報</strong> </h3>
                </div>
                <div class="form-horizontal">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="estateName" class="col-sm-2 col-form-label">物件名 <span class="text-danger">※</span></label>
                            <div class="col-sm-10">
                                <input required value="{{$estate->est_name}}" type="text" class="form-control" name="est_name" id="estateName" placeholder="物件名"  />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="roomNo" class="col-sm-2 col-form-label">建物名・号室 <span class="text-danger">※</span></label>
                            <div class="col-sm-10">
                                <input required value="{{$estate->est_room_no}}" type="text" class="form-control" name="est_room_no" id="roomNo" placeholder="建物名・号室"  />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="address" class="col-sm-2 col-form-label">住所 <span class="text-danger">※</span></label>
                            <div class="col-sm-10 row pl-1 ml-1">
                                <input required value="{{$estate->est_zip}}" type="number" class="form-control col-sm-4" name="zip22" size="7" maxlength="7" placeholder="郵便番号入力" />
                                
                                <div class="row mr-1 mt-2">
                                    <div class="form-group col-sm-3 ">
                                        <label for="select_prefectures">都道府県 <span class="text-danger">※</span></label>
                                        <input required value="{{$estate->est_pref}}" id="select_prefectures" name="pref21" class="form-control d-inline">
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label for="select_city">市・区 <span class="text-danger">※</span></label>
                                        <input required value="{{$estate->est_city}}" type="text" id="select_city" name="addr21" class="form-control d-inline">
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
                            <div onclick="getURL()" class="btn btn-primary float-right">情報を読み込む</div>
                        </div>
                        <div id="fulladdress" class="text-success"></div>
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
                        <a href="{{route('estate.index')}}" class="btn btn-default mr-2">キャンセル</a>
                        <button type="submit" class="btn btn-primary" id="finish_step2">保存</button>
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
        updateFullAddress();
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
                    
                    if(city.length>=5){
                        if(city.endsWith("市") || city.endsWith("県")){
                            //do nothing
                        }else{
                            if(ward){
                                $('#select_street').val(ward);
                            }
                            if (city.includes('県')) {
                                const parts = city.split('県');
                                city = parts[0] + '県';
                                ward = parts[1];
                            } else if (city.includes('市')) {
                                const parts = city.split('市');
                                city = parts[0] + '市';
                                ward = parts[1];
                            }
                        }
                        $('input[name="addr21"]').val(city);
                        $('input[name="strt21"]').val(ward);
                    }
                    $('#selected_prefectures').val(pref);
                    $('#selected_city').val(city);
                    $('#selected_ward').val(ward);
                    updateFullAddress();
                    getURL();
                }
            }, 200);
        });
        $('[name="pref21"]').on('keyup', function() {
            $('#selected_prefectures').val(this.value);
            updateFullAddress();
        });
        $('[name="addr21"]').on('keyup', function() {
            $('#selected_city').val(this.value);
            updateFullAddress();
        });
        $('[name="strt21"]').on('keyup', function() {
            $('#selected_ward').val(this.value);
            updateFullAddress();
        });
        $('[name="street"]').on('keyup', function() {
            updateFullAddress();
        });
        function updateFullAddress() {
            let pref = $('#selected_prefectures').val();
            let city = $('#selected_city').val();
            let ward = $('#selected_ward').val();
            let street = $('input[name="street"]').val();
            $('#fulladdress').text(pref + city + ward + street);
        }
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
        const getURL = () => {
            const pref = $('#selected_prefectures').val();
            const city = $('#selected_city').val();
            const ward = $('#selected_ward').val();
            $('#selected_pref_url').attr('placeholder', '');
            $('#selected_city_url').attr('placeholder', '');
            $('#selected_ward_url').attr('placeholder', '');

            const setUrl = (selector, name) => {
                const urlData = dataUrlCsv.find(data => data.name.includes(name));
                const url = urlData ? urlData.URL : '';
                $(selector).val(url);
                if (url==='') {
                    $(selector).attr('placeholder', 'リストに存在しない地名です');
                }
            };
            setUrl('#selected_pref_url', pref);
            setUrl('#selected_city_url', city);
            setUrl('#selected_ward_url', ward);
            if (!pref ) {
                $('#selected_pref_url').val('');
            }
            if (!city ) {
                $('#selected_city_url').val('');
            }
            if (!ward ) {
                $('#selected_ward_url').val('');
            }
        };
        

    </script>
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
            if (isValid) {
                this.submit();
            }
        });
    </script>
    <script>
       $('input').on('input', function() {
            this.value = this.value.replace(/^\s+/, '');
        });
        $('input[type="number"]').on('input', function() {
            if (this.value.length > 7) {
                this.value = this.value.slice(0, 7);
            }
        });
    </script>
    <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
@stop