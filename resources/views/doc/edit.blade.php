@extends('adminlte::page')

@section('title', '資料アップロード')

@section('content_header')
<h1>ファイルアップロード</h1>
@stop

@section('content')
<div class="card card-primary">
    <input type="hidden" id="estateId" value="{{$estateId}}">
    <form>
        <div class="col-md-10 mx-auto">
            <div class="card-body text-center">
                <div class="mx-auto mb-4 estate-name">{{$estateName}}</div>
                <div class="doc-title">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>ファイル選択</label>
                                <span class="red-required">※</span>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>カテゴリー</label>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>ファイル名</label>
                                <span class="red-required">※</span>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>説明文</label>
                            </div>
                        </div>
                        <div class="col-sm-1">

                        </div>
                    </div>
                </div>
                @foreach($getAllDoc as $doc)
                <div class="doc-section">

                    <div class="row doc-row">
                        <input type="hidden" name="doc-id" value="{{$doc['doc_id']}}">
                        <div class="col">
                            <div class="form-group">
                                <input type="file" class="form-control-file" name="doc-file" accept=".pdf">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <select class="form-control" name="doc-category">
                                    @foreach(Config::get('const.category_doc') as $key => $value)
                                    <option value="{{ $key }}" @if($key==$doc['doc_category']) selected @endif>
                                        {{ $value }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <input type="text" class="form-control" name="doc-name" maxlength="255" value="{{$doc['doc_name']}}">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <textarea class="form-control" name="doc-description" maxlength="255">{{$doc['doc_description']}}</textarea>
                            </div>
                        </div>
                        <div class="col-sm-1 remove-icon">
                            <span class="icon"><i class="fas fa-times-circle"></i></span>
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

        <div class="card-footer">
            <button type="" class="btn btn-primary float-right save-doc">{{ __('messages.save') }}</button>
            <button type="" class="btn btn-primary float-right add-doc">{{ __('messages.add') }}</button>
        </div>
    </form>
</div>

<div class="card card-primary">
    <input type="hidden" id="estateId" value="{{$estateId}}">
    <form>
        <div class="col-md-10 mx-auto">
            <div class="card-body text-center">
                <div class="form-upload doc-permanent">

                    @if($getDocPayment)

                    <div class="row doc-row form-group">
                        <input type="hidden" name="doc-permanent" value="{{$getDocPayment['doc_id']}}">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="float-left">決済までの流れ</label>
                                <input type="file" class="form-control-file" name="doc-file" accept=".pdf">
                                <input type="hidden" name="doc-category" value="3">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <p class="pdf-name">
                            @php $file_name = basename($getDocPayment->doc_file); $cleaned_file_name = preg_replace('/^\d{14}_/', '', $file_name); @endphp
                                {{$cleaned_file_name}}
                            </p>
                        </div>
                        <div class="col-sm-1 remove-icon-permanent">
                            <span class="icon"><i class="fas fa-trash"></i>
                            </span>
                        </div>
                        <div class="col-sm-1 download-pdf icon-permanent">
                            <span class="icon">
                                <a href="{{ Storage::url($getDocPayment->doc_file) }}" download="{{ $cleaned_file_name }}">
                                    <i class="fas fa-download"></i>
                                </a>
                            </span>
                        </div>
                    </div>

                    @else

                    <div class="row doc-row form-group">
                        <input type="hidden" name="doc-permanent" value="">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="float-left">決済までの流れ</label>
                                <input type="file" class="form-control-file" name="doc-file" accept=".pdf">
                                <input type="hidden" name="doc-category" value="3">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <p class="pdf-name">
                            </p>
                        </div>
                        <div class="col-sm-1 remove-icon-permanent">
                            <span class="icon"><i class="fas fa-trash"></i>
                            </span>
                        </div>
                    </div>

                    @endif

                    @if($getWarrantyPeriod)

                    <div class="row doc-row form-group">
                        <input type="hidden" name="doc-permanent" value="{{$getWarrantyPeriod['doc_id']}}">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="float-left">保証期間</label>
                                <input type="file" class="form-control-file" name="doc-file" accept=".pdf">
                                <input type="hidden" name="doc-category" value="4">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <p class="pdf-name">
                            @php $file_name = basename($getWarrantyPeriod->doc_file); $cleaned_file_name = preg_replace('/^\d{14}_/', '', $file_name); @endphp
                                {{$cleaned_file_name}}
                            </p>
                        </div>
                        <div class="col-sm-1 remove-icon-permanent">
                            <span class="icon"><i class="fas fa-trash"></i>
                            </span>
                        </div>
                        <div class="col-sm-1 download-pdf icon-permanent">
                            <span class="icon">
                                <a href="{{ Storage::url($getWarrantyPeriod->doc_file) }}" download="{{ $cleaned_file_name }}">
                                    <i class="fas fa-download"></i>
                                </a>
                            </span>
                        </div>
                    </div>

                    @else

                    <div class="row doc-row form-group">
                        <input type="hidden" name="doc-permanent" value="">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="float-left">保証期間</label>
                                <input type="file" class="form-control-file" name="doc-file" accept=".pdf">
                                <input type="hidden" name="doc-category" value="4">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <p class="pdf-name">
                            </p>
                        </div>
                        <div class="col-sm-1 remove-icon-permanent">
                            <span class="icon"><i class="fas fa-trash"></i>
                            </span>
                        </div>
                    </div>

                    @endif


                </div>


            </div>
        </div>

        <div class="card-footer">
            <button type="" class="btn btn-primary float-right save-doc-permanent">{{ __('messages.save') }}</button>
        </div>
    </form>
</div>
<a href="{{ URL::previous() }}" class="btn btn-default go-back float-left">{{ __('messages.cancel') }}</a>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<style>
    .form-group textarea {
        height: 38px;
        resize: none;
    }

    .remove-icon,
    .remove-icon-permanent,
    .download-pdf {
        position: relative;
    }

    .remove-icon span {
        position: absolute;
        top: 36%;
        transform: translateY(-50%);
        font-size: 20px;
        cursor: pointer;
    }

    .remove-icon-permanent span {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        font-size: 20px;
        cursor: pointer;
    }

    .download-pdf span {
        position: absolute;
        top: 36%;
        left: 0;
        transform: translateY(-50%);
        font-size: 20px;
        cursor: pointer;
    }

    .schedule-title {
        margin-bottom: 35px;
    }

    .schedule-row {
        margin-bottom: 25px;
    }

    .red-required {
        color: red;
    }

    .save-schedule,
    .save-doc {
        margin-left: 30px;
    }

    .estate-name {
        font-size: 25px;
        font-weight: 600;
    }

    .pdf-name {
        margin-top: 27px;
    }

    .download-pdf > a {
        color: inherit;
        text-decoration: none;
    }

    .download-pdf .fas {
        color: black;
    }

    .icon-permanent span {
        top: 50%;
    }
</style>
@stop

@section('js')
<script>
    $(document).ready(function() {

        //function remove doc
        function attachRemoveEvent() {
            $('.remove-icon').off('click').on('click', function() {
                var docId = $(this).closest('.doc-row').find('input[name="doc-id"]').val();
                var element = $(this).closest('.doc-section');
                if (docId == '') {
                    element.remove();
                    maxUpload--;
                } else {
                    if (confirm("ファイルを削除しますか？")) {
                        deleteDoc(docId, element);
                        maxUpload--;
                    }
                }
            });
        }


        //function deleteDoc
        function deleteDoc(docId, element) {
            $.ajax({
                url: "/estate/doc/destroy/" + docId,
                type: "DELETE",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response == true) {
                        element.remove();
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                }
            });
        }

        //event remove doc permanent
        $('.remove-icon-permanent').off('click').on('click', function() {
            var pdfName = $(this).closest('.doc-row').find('.pdf-name');
            if (pdfName.text().trim() != '') {
                if (confirm("ファイルを削除しますか？")) {
                    var docPermanentId = $(this).closest('.doc-row').find('input[name="doc-permanent"]');
                    if (docPermanentId != '') {
                        deleteDocPermanent(docPermanentId, pdfName);
                    }
                }
            }
        });

        //function deleteDocPermanent
        function deleteDocPermanent(docPermanentId, pdfName) {
            $.ajax({
                url: "/estate/doc/destroy/" + docPermanentId.val(),
                type: "DELETE",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response == true) {
                        pdfName.text('');
                        docPermanentId.val('');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                }
            });
        }


        //call function when loaded DOM
        attachRemoveEvent();
        var maxUpload = $('.doc-section').length;
        //event add doc
        $('.add-doc').on('click', function(e) {
            e.preventDefault();
            // var categoryDoc = @json(config('const.category_doc'));
            if (maxUpload == 12) {
                // alert("max add section upload is 12");
                return;
            }
            var newBlock =
                `
            <div class="doc-section">
                <div class="row doc-row">
                    <input type="hidden" name="doc-id" value="">
                    <div class="col">
                        <div class="form-group">
                            <input type="file" class="form-control-file" name="doc-file" accept=".pdf">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <select class="form-control" name="doc-category">
                                @php $count = 0; @endphp
                                @foreach(Config::get('const.category_doc') as $key => $value)
                                    @if($count < 3)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endif
                                    @php $count++; @endphp
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <input type="text" class="form-control" name="doc-name" maxlength="255">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <textarea class="form-control" name="doc-description" maxlength="255"></textarea>
                        </div>
                    </div>

                    <div class="col-sm-1 remove-icon">
                        <span class="icon"><i class="fas fa-times-circle"></i></span>
                    </div>
                    <div class="col-sm-1 download-pdf">
                    </div>
                </div>
            </div>
            `;

            // $('.doc-section').last().after(newBlock);
            if ($('.doc-section').length > 0) {
                $('.doc-section').last().after(newBlock);
            } else {
                $('.doc-title').after(newBlock);
            }
            maxUpload++;

            attachRemoveEvent();
        });


        //event save doc
        $('.save-doc').on('click', function(e) {
            e.preventDefault();

            var formData = new FormData();
            var estateId = $('#estateId').val();
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var error = false;

            formData.append('estateId', estateId);
            formData.append('_token', csrfToken);

            var rows = $('.doc-section .doc-row');

            if (rows.length === 0) {
                return false;
            }

            $('.doc-section .doc-row').each(function(index, row) {
                var docFile = $(row).find('.form-group input[type="file"]')[0].files[0];
                var docCategory = $(row).find('.form-group select[name="doc-category"]').val();
                var docName = $(row).find('.form-group input[name="doc-name"]').val().trim();
                var docDescription = $(row).find('.form-group textarea[name="doc-description"]').val().trim();
                var docId = $(row).find('input[name="doc-id"]').val();

                if ((docId == '' && docFile == undefined) || docName == '') {
                    alert('この項目 「※」は必須です。');
                    error = true;
                    return false;
                }

                // formData.append('docFile[]', docFile);
                // formData.append('docCategory[]', docCategory);
                // formData.append('docName[]', docName);
                // formData.append('docDescription[]', docDescription);
                // formData.append('docId[]', docId);
                formData.append('docs[' + index + '][docFile]', docFile);
                formData.append('docs[' + index + '][docCategory]', docCategory);
                formData.append('docs[' + index + '][docName]', docName);
                formData.append('docs[' + index + '][docDescription]', docDescription);
                formData.append('docs[' + index + '][docId]', docId);
            });

            if (error) {
                return false;
            }

            $.ajax({
                url: '/estate/doc/update',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response == true) {
                        window.location.href = "/estate";
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });

        });

        //event save doc permanent
        $('.save-doc-permanent').on('click', function(e) {
            e.preventDefault();

            var formData = new FormData();
            var estateId = $('#estateId').val();
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var error = false;
            var undefinedCount = 0;

            formData.append('estateId', estateId);
            formData.append('_token', csrfToken);

            $('.doc-permanent .doc-row').each(function(index, row) {
                var docFile = $(row).find('.form-group input[type="file"]')[0].files[0];
                var docCategory = $(row).find('.form-group input[name="doc-category"]').val();
                var docId = $(row).find('input[name="doc-permanent"]').val();

                if (docFile == undefined) {
                    undefinedCount++;
                }
                // formData.append('docId[]', docId);
                // formData.append('docFile[]', docFile);
                // formData.append('docCategory[]', docCategory);
                formData.append('docs[' + index + '][docId]', docId);
                formData.append('docs[' + index + '][docCategory]', docCategory);
                formData.append('docs[' + index + '][docFile]', docFile);
            });

            if (undefinedCount == 2) {
                error = true;
            }

            if (error) {
                return false;
            }

            $.ajax({
                url: '/estate/doc/permanent',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response == true) {
                        window.location.href = "/estate";
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });

        });

    });
</script>
@stop