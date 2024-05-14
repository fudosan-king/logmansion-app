@extends('adminlte::page')

@section('title', '物件一覧')

@section('content_header')
    <h1>物件一覧</h1>
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
                          <button type="button" class="btn btn-light y-2">アーカイブ</button>
                          <a href="{{route('estate.create')}}" class="btn btn-primary mt-2 mb-2 ml-4">物件新規追加</a>
                        </div>
                    </div>
                  <table id="tblData" class="table table-bordered table-striped dataTable dtr-inline" aria-describedby="example2_info">
                    <thead>
                      <tr>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" >物件名</th>
                        <th class="sorting sorting_desc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="descending">ステータス</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" >次スケジュール</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" >クライアント</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" >アクション</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($estates as $estate)
                      <tr class="odd">
                        <td class="dtr-control">{{$estate['est_name']}}</td>
                        <td class="sorting_1">
                          @if($estate['schedules'] !== [])
                            {{$estate['schedules']['current_schedule']['schedule_name']}}
                          @endif
                        </td>
                        <td>
                          <!-- 24.4.15 事前審査 -->
                            @if($estate['schedules'] !== [])
                            {{ date('Y-m-d', strtotime($estate['schedules']['next_schedule']['schedule_date'])) }} {{$estate['schedules']['next_schedule']['schedule_name']}}
                            @endif
                        </td>
                        <td>山田二郎</td>
                        <td>
                            <div class="action_bar" style="">
                              <a href="{{route('estate.edit',['id'=>$estate['est_id']])}}">
                                <i class="fas fa-hammer"></i>
                              </a>
                              <a href="{{route('schedule.edit', ['id' => $estate['est_id']])}}"><i class="fas fa-calendar"></i></a>
                              <i class="fas fa-file-upload"></i>
                              <a href="{{route('estate.destroy',$estate['est_id'])}}" onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this estate?')) { document.getElementById('delete-form-{{$estate['est_id']}}').submit(); }">
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
          ]
        });
      })
    </script>
@stop

@section('plugins.Datatables', true)
