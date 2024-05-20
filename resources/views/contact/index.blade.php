@extends('adminlte::page')

@section('title', 'お問い合わせ')


@section('content_header')
<h1>お問い合わせ</h1>
@stop
@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<style>
    #tblData_filter {
        display: none;
    }

    .search-contact {
        margin-bottom: 20px;
    }
</style>
@stop

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row search-contact">
                                        <!-- <div class="col-sm-1">
                                            <label for="">type search</label>
                                        </div> -->
                                        <div class="col-sm-2">
                                            <select class="form-control contact-type-search">
                                                <option value="empty">All</option>
                                                @foreach(Config::get('const.text_search') as $key => $value)
                                                <option value="{{ $key }}">
                                                    {{ $value }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!-- <div class="col-sm-1">
                                            <label for="">data search</label>
                                        </div> -->
                                        <div class="col-sm-2">
                                            <select class="form-control contact-value-search" name="">
                                            </select>

                                        </div>
                                        <!-- <div class="col-sm-1">
                                            <a href="" type="button" class="btn btn-primary y-2">Search</a>
                                        </div> -->
                                    </div>
                                    <table id="tblData" class="table table-bordered table-striped dataTable dtr-inline" aria-describedby="example2_info">
                                        <thead>
                                            <tr>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Client</th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Contact Type</th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Spot</th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Contact Title</th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Status</th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Last Updated</th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Staff</th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach($contacts as $contact)
                                            <tr>
                                                <td><a href="{{route('estcontact.edit', ['id' => $contact->contact_id])}}">{{ $contact->client->client_name ?? "" }}</a></td>
                                                <td>
                                                    {{ Config::get('const.contact_type.'.$contact->contact_type) }}
                                                </td>
                                                <td>{{ Config::get('const.contact_spot.'.$contact->contact_spot) }}</td>
                                                <td>{{ $contact->contact_title ?? "" }}</td>
                                                <td>{{ Config::get('const.contact_status.'.$contact->contact_status) }}</td>
                                                <td>{{ $contact->updated_at->format('Y-m-d') ?? "" }}</td>
                                                <td>{{ $contact->user->name ?? "" }}</td>
                                                <td>{{ $contact->created_at->format('Y-m-d') ?? "" }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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
<script src="https://cdn.datatables.net/plug-ins/1.11.5/sorting/intl.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.11.5/sorting/type-based/numeric-comma.js"></script>

<script>
    $(document).ready(function() {
        var index = null;
        $('#tblData').DataTable({
            "columnDefs": [{
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.11.5/sorting/intl.js"
                },
                "columnDefs": [{
                    "type": "numeric-comma",
                    "targets": "_all"
                }]
            }]
        });


        $('.contact-type-search').change(function() {
            var dataTable = $('#tblData').DataTable();
            dataTable.search('').columns().search('').draw();
            var valueType = $(this).val();
            var docNameSelect = $('.contact-value-search');
            if (valueType == 'empty') {
                docNameSelect.empty();
                dataTable.column(index).search('', true, false).draw();
                return;
            }
            $.ajax({
                url: "{{ route('estcontact.getDocSearch') }}",
                method: 'GET',
                data: {
                    value_type: valueType
                },
                success: function(response) {
                    if (response == false) {
                        return;
                    }
                    docNameSelect.empty();
                    docNameSelect.append($('<option>', {
                        value: 'empty',
                        text: ''
                    }));
                    response.forEach(function(item) {
                        switch (valueType) {
                            case '0':
                                docNameSelect.append($('<option>', {
                                    value: item.client_name,
                                    text: item.client_name,
                                }));
                                index = 0;
                                break;

                            case '1':
                                docNameSelect.append($('<option>', {
                                    value: item.name,
                                    text: item.name,
                                }));
                                index = 6;
                                break;

                            case '2':
                                docNameSelect.append($('<option>', {
                                    value: item,
                                    text: item,
                                }));
                                index = 1;
                                break;

                            default:
                                docNameSelect.empty();
                                index = null;
                                break;
                        }
                    });
                }
            });
        });


        $('.contact-value-search').change(function() {
            var searchValue = $(this).val().trim();
            var dataTable = $('#tblData').DataTable();
            var regexPattern = '^' + $.fn.dataTable.util.escapeRegex(searchValue) + '$';

            dataTable.column(index).search(regexPattern, true, false).draw();
        });


    })
</script>
@stop

@section('plugins.Datatables', true)