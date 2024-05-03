@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Notifications List</h1>
@stop

@section('content')
    <a href="{{ route('notification.create') }}" class="btn btn-success mb-4">Add New</a>

    @if (session('success'))
        <div aria-live="polite" aria-atomic="true" style="z-index: -1;">
            <div class="toast" data-autohide="true" data-delay="10000" style="position: absolute; top: 0; right: 0;">
                <div class="toast-header alert-success">
                    <strong class="mr-auto"><i class="fa fa-grav"></i> {{ session('success') }}</strong>
                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
                </div>
            </div>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <div class="card-tools">
                <form action="{{ route('notification') }}" method="GET" class="form-inline">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="search" value="{{ $search }}" class="form-control float-right" placeholder="Search">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th scope="col">日付</th>
                        <th scope="col">カテゴリ</th>
                        <th scope="col">タイトル</th>
                        <th scope="col">状態</th>
                        <th scope="col">最終更新日</th>
                        <th scope="col">アクション</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($notifications as $notification)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($notification->noti_date)->format('Y/m/d') }}</td>
                            <td>{{ $notification->category->cat_name ?? '' }}</td>
                            <td>{{ $notification->noti_title ?? '' }}</td>
                            <td>
                                @if ($notification->noti_status == 1)
                                    <div type="button" class="badge badge-primary">有効</div>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($notification->updated_at)->format('Y/m/d  ') }}</td>
                            <td>
                                <a class="btn btn-xs btn-warning" id="btnEdit" href="{{ route('notification.edit', $notification->noti_id) }}"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('notification.destroy', $notification->noti_id) }}" method="POST"
                                    style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-outline-danger"
                                        onclick="return confirm('Are you sure you want to delete this notification?')"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            {{ $notifications->links('pagination::bootstrap-5') }}
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        $('.toast').toast('show');
    </script>
@stop
