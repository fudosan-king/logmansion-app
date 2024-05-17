@extends('adminlte::page')

@section('title', config('estate_labels.title_estate'))


@section('content_header')
    <h1>{{ config('estate_labels.title_estate') }}</h1>
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
                    <div class="d-flex justify-content-between my-2">
                        <div></div>
                        <div class="w-50">
                        </div>
                        <div>
                          <a href="{{route('estate.archive_index')}}" type="button" class="btn btn-light y-2">{{ config('estate_labels.archive') }}</a>
                          <a href="{{route('estate.create')}}" class="btn btn-primary mt-2 mb-2 ml-4">{{ config('estate_labels.add_new_estate') }}</a>
                        </div>
                    </div>
                  <table id="tblData" class="table table-bordered table-striped dataTable dtr-inline" aria-describedby="example2_info">
                    <thead>
                      <tr>
                        <th class="sorting w-50" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" >{{ config('estate_labels.estate_name') }}</th>
                        <th class="sorting text-nowrap sorting_desc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="descending">{{ config('estate_labels.status') }}</th>
                        <th class="sorting text-nowrap" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" >{{ config('estate_labels.next_schedule') }}</th>
                        <th class="sorting text-nowrap" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" >{{ config('estate_labels.client') }}</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" >{{ config('estate_labels.action') }}</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($estates as $estate)
                          <tr class="odd">
                            <td class="dtr-control"><a href="{{route('estate.edit',['id'=>$estate['est_id']])}}">{{$estate['est_name']}}</a></td>
                            <td class="sorting_1">
                              @if($estate['schedules'] !== [])
                                {{$estate['schedules']['current_schedule']['schedule_name'] ?? ""}}
                              @endif
                            </td>
                            <td>
                                @if($estate['schedules'] !== [] && isset($estate['schedules']['next_schedule']))
                                  {{ date('Y-m-d', strtotime($estate['schedules']['next_schedule']['schedule_date'])) }} {{$estate['schedules']['next_schedule']['schedule_name'] ?? ""}}
                                @endif
                            </td>
                            <td></td>
                            <td>
                                <div class="action_bar" style="">
                                    <a href="#" data-toggle="tooltip" data-placement="top" title="Add Client">
                                    <i class="fas fa-hammer"></i>
                                    </a>
                                  <a href="{{route('schedule.edit', ['id' => $estate['est_id']])}}" data-toggle="tooltip" data-placement="top" title="Add Calendar">
                                    <i class="fas fa-calendar"></i>
                                  </a>
                                  <a href="{{route('doc.edit', ['id' => $estate['est_id']])}}" data-toggle="tooltip" data-placement="top" title="Add Files">
                                    <i class="fas fa-file-upload"></i>
                                  </a>
                                  <a href="{{route('estate.destroy',$estate['est_id'])}}" onclick="event.preventDefault(); if(confirm('{{ config('estate_labels.delete_confim') }}')) { document.getElementById('delete-form-{{$estate['est_id']}}').submit(); }" data-toggle="tooltip" data-placement="top" title="Delete Estate">
                                    <form id="delete-form-{{$estate['est_id']}}" action="{{route('estate.destroy',$estate['est_id'])}}" method="POST" style="display: none;">
                                      @csrf
                                      @method('DELETE')
                                    </form>
                                    <i class="fas fa-trash-alt text-danger"></i>
                                  </a>
                                </div>
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
    <script>
      $(document).ready(function(){
      $('#tblData').DataTable({
        "columnDefs": [
        { "searchable": false, "targets": [1, 2, 4] }
        ],
        "order": []
      });
      })
    </script>
@stop

@section('plugins.Datatables', true)
