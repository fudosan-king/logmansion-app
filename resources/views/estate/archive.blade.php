@extends('adminlte::page')

@section('title', config('estate_labels.title_archive'))

@section('content_header')
    <h1>{{ config('estate_labels.title_archive') }}</h1>
@stop
@section('css')
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
                            <a href="{{route('estate.index')}}" type="button" class="btn btn-danger y-2">{{ config('estate_labels.back') }}</a>
                            </div>
                        </div>
                        <table id="tblData" class="table table-bordered table-striped dataTable dtr-inline">
                            <thead>
                            <tr>
                                <th class="text-nowrap w-50" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" >
                                    {{ config('estate_labels.estate_name') }}</th>
                                <th class="text-nowrap w-50" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" >{{ config('estate_labels.client') }}</th>
                                <th class="text-nowrap" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" >{{ config('estate_labels.action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($estates as $estate)
                            <tr>
                                <td class="dtr-control">
                                    <a href="{{route('estate.view',$estate['est_id'])}}">{{$estate['est_name']}}</a>
                                </td>
                                <td>
                                    @if(isset($estate['client']))
                                        {{$estate['client']['client_f_name']}}{{$estate['client']['client_l_name']}}
                                    @endif
                                </td> 
                                <td>
                                    <div class="action_bar">
                                    <a href="{{route('estate.destroy',$estate['est_id'])}}" onclick="event.preventDefault(); if(confirm('{{ config('estate_labels.delete_confim') }}')) { document.getElementById('delete-form-{{$estate['est_id']}}').submit(); }">
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
            "language": {
                "sProcessing": "処理中...",
                "sLengthMenu": "_MENU_ 件表示",
                "sZeroRecords": "データはありません。",
                "sInfo": " _TOTAL_ 件中 _START_ から _END_ まで表示",
                "sInfoEmpty": " 0 件中 0 から 0 まで表示",
                "sInfoFiltered": "（全 _MAX_ 件より抽出）",
                "sInfoPostFix": "",
                "sSearch": "検索:",
                "sUrl": "",
                "oPaginate": {
                    "sFirst": "先頭",
                    "sPrevious": "前",
                    "sNext": "次",
                    "sLast": "最終"
                }
            },
            "order": []
        });
      })
    </script>
@stop

@section('plugins.Datatables', true)
