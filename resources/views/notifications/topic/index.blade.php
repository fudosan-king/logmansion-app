@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Notification category list</h1>
@stop

@section('content')
    <a href="{{ route('topic.create') }}" class="btn btn-outline-success mb-2">Add New</a>

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
        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th scope="col">カテゴリ</th>
                        <th scope="col">最終更新日</th>
                        <th scope="col">アクション</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $category->cat_name ?? '' }}</td>
                            <td>{{ \Carbon\Carbon::parse($category->updated_at)->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('topic.edit', $category->cat_id) }}" class="btn btn-primary">{{__("messages.edit")}}</a>
                                <form action="{{ route('topic.destroy', $category->cat_id) }}" method="POST"
                                    style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger "
                                        onclick="return confirm('Are you sure you want to delete this category?')">{{ __("messages.delete")}}</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
