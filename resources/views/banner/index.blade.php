@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Banners</h1>
@stop

@section('content')
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
    {{-- <div class="float">
        <a href="{{ route('banner.create') }}" class="btn btn-outline-success mb-1">Add New</a>
    </div> --}}

    <div class="card">
        <div class="card-header">
            <div class="card-tools">
                <a href="{{ route('banner.create') }}" class="btn btn-outline-success mr-2">Add New</a>
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Image</th>
                        <th>URL</th>
                        <th>Active</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($banners as $banner)
                        <tr>
                            <td>{{ $banner->banner_title }}</td>
                            <td><img src="{{ asset('storage/' . $banner->banner_image) }}"
                                    alt="{{ $banner->banner_description }}" style="max-width: 100px;"></td>
                            <td>{{ $banner->banner_url }}</td>
                            <td>
                                @if ($banner->banner_active)
                                    <div type="button" class="badge badge-primary">Active</div>
                                @else
                                    <div type="button" class="badge badge-secondary">Deactive</div>
                                @endif</td>
                            <td>
                                <a class="btn btn-xs btn-warning" id="btnEdit" href="{{ route('banner.edit', $banner->banner_id) }}"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('banner.destroy', $banner->banner_id) }}" method="POST"
                                    style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-outline-danger"
                                        onclick="return confirm('Are you sure you want to delete this banner?')"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
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
