@extends('adminlte::page')

@section('title', 'Estates')

@section('content_header')
    <h1>Estate list</h1>
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
                    <div class="d-flex justify-content-between">
                        <div class="btn btn-primary mt-2 mb-2">Add new Estate</div>
                        <div >
                            <nav class="navbar navbar-light bg-light">
                            <form class="form-inline">
                                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                            </form>
                            </nav>
                        </div>
                        <button type="button" class="btn btn-light y-2">Archive</button>
                    </div>
                  <table id="example2" class="table table-bordered table-hover dataTable dtr-inline" aria-describedby="example2_info">
                    <thead>
                      <tr>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending">Estate name</th>
                        <th class="sorting sorting_desc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" aria-sort="descending">Status</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Next Schedule</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">Client</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr class="odd">
                        <td class="dtr-control">マートルコート奥沢 5階</td>
                        <td class="sorting_1">引渡し済</td>
                        <td>024.4.15 事前審査</td>
                        <td>山田二郎</td>
                        <td>
                            <div class="action_bar" style="">
                                <i class="fas fa-hammer"></i>
                                <i class="fas fa-calendar"></i>
                                <i class="fas fa-file-upload"></i>
                                <i class="fas fa-trash-alt text-danger"></i>
                            </div>
                        </td>
                      </tr>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th rowspan="1" colspan="1">Esate</th>
                        <th rowspan="1" colspan="1">Status</th>
                        <th rowspan="1" colspan="1">Next Schedule</th>
                        <th rowspan="1" colspan="1">Client</th>
                        <th rowspan="1" colspan="1">Action</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12 col-md-5">
                  <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Showing 41 to 50 of 57 entries</div>
                </div>
                <div class="col-sm-12 col-md-7">
                  <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                    <ul class="pagination">
                      <li class="paginate_button page-item previous" id="example2_previous">
                        <a href="#" aria-controls="example2" data-dt-idx="0" tabindex="0" class="page-link">Previous</a>
                      </li>
                      <li class="paginate_button page-item active">
                        <a href="#" aria-controls="example2" data-dt-idx="1" tabindex="0" class="page-link">1</a>
                      </li>
                     
                      <li class="paginate_button page-item next" id="example2_next">
                        <a href="#" aria-controls="example2" data-dt-idx="7" tabindex="0" class="page-link">Next</a>
                      </li>
                    </ul>
                  </div>
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
    <script> console.log('Hi!'); </script>
@stop