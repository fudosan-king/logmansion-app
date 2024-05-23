@extends('adminlte::page')

@section('title', config('estate_labels.contact'))


@section('content_header')
<h1> {{config('estate_labels.contact')}} </h1>
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
                                        <div class="col-sm-2">
                                            <select class="form-control contact-type-search">
                                                <option value="empty">{{ config('estate_labels.all') }}</option>
                                                @foreach(Config::get('const.text_search') as $key => $value)
                                                <option value="{{ $key }}">
                                                    {{ $value }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-2">
                                            <select class="form-control contact-value-search" name="">
                                            </select>
                                        </div>
                                    </div>
                                    <table id="tblData" class="table table-bordered table-striped dataTable dtr-inline" aria-describedby="example2_info">
                                        <thead>
                                            <tr>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">{{ config('estate_labels.client') }}</th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">{{ config('estate_labels.contact_type') }}</th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">{{ config('estate_labels.spot') }}</th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">{{ config('estate_labels.contact_title') }}</th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">{{ config('estate_labels.status') }}</th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">{{ config('estate_labels.last_update') }}</th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">{{ config('estate_labels.staff') }}</th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">{{ config('estate_labels.date') }}</th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"></th>
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
                                                <?php $listStaff = App\Models\ContactDetail::where('author_type', 1)
                                                    ->where('contact_id', $contact->contact_id)
                                                    ->distinct()
                                                    ->orderByDesc('contact_id')
                                                    ->get();
                                                    $dataPluck = $listStaff->pluck('author');
                                                    $result = [];
                                                    $results = App\Models\User::whereIn('id', $dataPluck)->orderByDesc('id')->get('name');

                                                ?>
                                                <td>
                                                    @foreach($results as $value)
                                                       {{$value->name}}
                                                    @endforeach
                                                </td>
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
            }],
            "columns": [{
                    "data": "column1"
                },
                {
                    "data": "column2"
                },
                {
                    "data": "column3"
                },
                {
                    "data": "column4"
                },
                {
                    "data": "column5"
                },
                {
                    "data": "column6"
                },
                {
                    "data": "column7"
                },
                {
                    "data": "column8"
                },
                {
                    "data": "column9",
                    "visible": false
                },
            ]
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
                                    value: item.name,
                                    text: item.name,
                                }));
                                index = 8;
                                break;

                            case '3':
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

            if (index == 8) {
                dataTable.column(index).search(searchValue, true, false).draw();
            } else {
                var regexPattern = '^' + $.fn.dataTable.util.escapeRegex(searchValue) + '$';
                dataTable.column(index).search(regexPattern, true, false).draw();
            }
            
        });


    })
</script>
@stop

@section('plugins.Datatables', true)
@section('plugins.Select2', true)