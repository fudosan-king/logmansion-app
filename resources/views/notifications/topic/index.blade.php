@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Notification category list</h1>
@stop

@section('content')
    <a href="{{ route('topic.create') }}" class="btn btn-outline-success mb-2">Add New</a>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-hover table-bordered">
        <thead>
            <tr>
                <th scope="col">カテゴリ</th>
                <th scope="col">最終更新日</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>{{ $category->cat_name ?? "" }}</td>
                <td>{{ $category->updated_at ?? "" }}</td>
                <td>
                    <a href="{{ route('topic.edit', $category->cat_id) }}" class="btn btn-primary">編集</a>
                    <form action="{{ route('topic.destroy', $category->cat_id) }}" method="POST"
                        style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger "
                            onclick="return confirm('Are you sure you want to delete this category?')">削除</button>
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
    </script>
@stop
