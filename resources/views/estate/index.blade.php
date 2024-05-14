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
                        <a href="{{route('estate.create')}}" class="btn btn-primary mt-2 mb-2">物件新規追加</a>
                        <div class="w-50">
                            <nav class="navbar navbar-light bg-light w-100">
                              <form class="form-inline w-100"  method="GET" action="{{ request()->url() }}">
                                  <input name="search" value="{{ request()->input('search') }}" class="form-control mr-sm-2 w-75" type="search" placeholder="検索" aria-label="Search">
                                  <button class="btn btn-outline-success my-2 my-sm-0" type="submit">検索</button>
                                  @if(request()->has('search'))
                                    <a href="{{route('estate.index')}}" class="btn btn-outline-danger ml-2" type="submit">キャンセル</a>
                                  @endif
                              </form>
                            </nav>
                        </div>
                        <button type="button" class="btn btn-light y-2">アーカイブ</button>
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
                        <td class="dtr-control">{{$estate->est_name}}</td>
                        <td class="sorting_1">Status</td>
                        <td>024.4.15 事前審査</td>
                        <td>山田二郎</td>
                        <td>
                            <div class="action_bar" style="">
                              <a href="{{route('estate.edit',['id'=>$estate->est_id])}}">
                                <i class="fas fa-hammer"></i>
                              </a>
                              <a href="{{route('schedule.edit', ['id' => $estate->est_id])}}"><i class="fas fa-calendar"></i></a>
                              <a href="{{route('doc.edit', ['id' => $estate->est_id])}}"><i class="fas fa-file-upload"></i></a>
                              <a href="{{route('estate.destroy',$estate->est_id)}}" onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this estate?')) { document.getElementById('delete-form-{{$estate->est_id}}').submit(); }">
                                <form id="delete-form-{{$estate->est_id}}" action="{{route('estate.destroy',$estate->est_id)}}" method="POST" style="display: none;">
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
              <div class="row d-flex justify-content-between">
                {{ $estates->links() }}
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
          "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Japanese.json"
          }
        });
      })
    </script>
@stop

@section('plugins.Datatables', true)
