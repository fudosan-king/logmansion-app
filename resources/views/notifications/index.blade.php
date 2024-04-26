@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Notifications List</h1>
@stop

@section('content')
    <a href="{{ route('notification.create') }}" class="btn btn-outline-success mb-2">Add New</a>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-hover table-bordered">
        <thead>
            <tr>
                <th scope="col">日付</th>
                <th scope="col">カテゴリ</th>
                <th scope="col">タイトル</th>
                <th scope="col">状態</th>
                <th scope="col">最終更新日</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($notifications as $notification)
            <tr>
                <td>{{ $notification->noti_date ? substr($notification->noti_date, 0, 10) : '' }}</td>
                <td>{{ $notification->category->cat_name ?? "" }}</td>
                <td>{{ $notification->noti_title ?? "" }}</td>
                <td>{{ $notification->noti_status == 1 ? '有効' : '' }}</td>
                <td>{{ $notification->updated_at ?? "" }}</td>
                <td>
                    <a href="{{ route('notification.edit', $notification->noti_id) }}" class="btn btn-primary">編集</a>
                    {{-- <button type="button" class="btn btn-danger">削除</button> --}}
                    <form action="{{ route('notification.destroy', $notification->noti_id) }}" method="POST"
                        style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger "
                            onclick="return confirm('Are you sure you want to delete this notification?')">削除</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        console.log('Hi!');
    </script>
@stop
