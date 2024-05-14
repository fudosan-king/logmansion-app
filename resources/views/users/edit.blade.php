@extends('adminlte::page')

@section('title', 'ユーザーの編集 | Dashboard')

@section('content_header')
    <h1>ユーザー</h1>
@stop

@section('content')
   <div class="container-fluid">
    {{-- <div class="card card-primary"> --}}
        <div id="errorBox"></div>
        <div class="card card-primary">
            <form method="POST" action="{{route('users.update', $user->id)}}">
                @method('patch')
                @csrf
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h5>ユーザーの編集</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name" class="form-label">{{__('messages.name')}} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" placeholder="フルネームを入力してください。" value="{{$user->name}}">
                            @if($errors->has('name'))
                                <span class="text-danger">{{$errors->first('name')}}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="department" class="form-label">{{__('messages.department')}}<span class="text-danger">*</span></label>
                            <select class="form-control select2"  id="select3" data-placeholder="Select Department" name="department">
                            @foreach (config('const.department') as $k=>$v)
                                <option value="{{$k}}" {{ ($user->department == $k) ? "selected" : ""}} >{{ucfirst($v)}}</option>
                            @endforeach
                            </select>
                            @if($errors->has('department'))
                            <span class="text-danger">{{$errors->first('department')}}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="email" class="form-label">{{__('messages.mail')}} <span class="text-danger">*</span></label>
                            <input readonly ="email" class="form-control" name="email" placeholder="ユーザーのメールアドレスを入力してください。" value="{{$user->email}}">
                            @if($errors->has('email'))
                                <span class="text-danger">{{$errors->first('email')}}</span>
                            @endif
                        </div>
                        {{-- <div class="form-group">
                            <label for="password" class="form-label">{{__('messages.password')}}</label>
                            <input type="password" class="form-control" name="password" placeholder="ユーザーパスワードを入力してください。" value="{{$user->password}}">
                            @if($errors->has('password'))
                                <span class="text-danger">{{$errors->first('password')}}</span>
                            @endif
                        </div> --}}
                        <div class="form-group">
                            <label for="roles" class="form-label">{{__('messages.role')}}</label>
                            <select class="form-control select2" 
                            {{-- multiple="multiple"  --}}
                            id="select2" data-placeholder="Select Roles" name="roles[]">
                            @foreach ($roles as $role)
                                <option value="{{$role->id}}" {{$user->id ? (in_array($role->name, $userRole)? 'selected': ''):''}}>{{ucfirst($role->name)}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">{{ __("messages.save") }}</button>
                        <a href="{{url()->previous()}}"  class="btn btn-default float" style="margin-left:10px">@lang('messages.cancel')</a>
                    </div>
                </div>
            </form>
        </div>
    {{-- </div> --}}
   </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script>
    $(function (){
        $('#select2').select2();
    });
</script>
@stop
@section('plugins.Select2', true)