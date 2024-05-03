@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>FAQ</h1>
@stop

@section('content')
    <a href="{{ route('faq.create') }}" class="btn btn-outline-success mb-2">Add New</a>

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
                <form action="{{ route('faq') }}" method="GET" class="form-inline">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="search" class="form-control float-right" value="{{ $search }}"
                            placeholder="Search">
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
                        <th>Title</th>
                        <th>Active</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($faqs as $faq)
                        <tr>
                            <td>{{ $faq->faq_title }}</td>
                            <td>
                                @if ($faq->faq_active)
                                    <div type="button" class="badge badge-primary">Active</div>
                                @else
                                    <div type="button" class="badge badge-secondary">Deactive</div>
                                @endif
                            </td>
                            <td>
                                <a class="btn btn-xs btn-warning" id="btnEdit"
                                    href="{{ route('faq.edit', $faq->faq_id) }}"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('faq.destroy', $faq->faq_id) }}" method="POST"
                                    style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-outline-danger"
                                        onclick="return confirm('Are you sure you want to delete this FAQ?')"><i
                                            class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            {{ $faqs->links('pagination::bootstrap-5') }}
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
