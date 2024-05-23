@extends('adminlte::page')

@section('title', '{{__("messages.profile")}} | Dashboard')

@section('content_header')
    <h1>{{__('messages.profile')}}</h1>
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
                            <h5>{{__('messages.edit')}}</h5>
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
                            <label for="department" class="form-label">{{__('messages.department')}}</label>
                            <span style="padding-left:100px">{{ config('const.department')[$user->department] }}</span> 
                        </div>
                        <div class="form-group">
                            <label for="email" class="form-label">{{__('messages.mail')}} </label>
                                <span style="padding-left:20px">{{$user->email}}</span>
                        </div>
                     
                        <div class="form-group">
                            <label for="roles" class="form-label">{{__('messages.role')}}</label>
                            @foreach ($roles as $role)
                                <span style="padding-left:100px">{{$user->id ? (in_array($role->name, $userRole)? ucfirst($role->name): ''):''}}</span>
                            @endforeach
                        </div>
                        {{-- <div class="form-group">
                            <label for="current_password" class="form-label">{{__('messages.current_password')}}</label>
                            <input type="password" class="form-control" name="current_password" placeholder="ユーザーパスワードを入力してください。" value="">
                            @if($errors->has('current_password'))
                                <span class="text-danger">{{$errors->first('current_password')}}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="password" class="form-label">{{__('messages.password')}}</label>
                            <input type="password" class="form-control" name="password" placeholder="ユーザーパスワードを入力してください。" value="">
                            @if($errors->has('password'))
                                <span class="text-danger">{{$errors->first('password')}}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation" class="form-label">{{__('messages.password_confirmation')}}</label>
                            <input type="password" class="form-control" name="password_confirmation" placeholder="ユーザーパスワードを入力してください。" value="">
                            @if($errors->has('password_confirmation'))
                                <span class="text-danger">{{$errors->first('password_confirmation')}}</span>
                            @endif
                        </div> --}}


                         {{-- <div class="form-group">
                            <label for="password" class="form-label">{{__('messages.password')}}</label>
                            <input type="password" class="form-control" name="password" placeholder="Enter Users Password" value="{{old('password')}}">
                            @if($errors->has('password'))
                                <span class="text-danger">{{$errors->first('password')}}</span>
                            @endif
                        </div> --}}

                          {{-- Password field --}}
                        <label for="current_password" class="form-label">{{__('messages.current_password')}}</label>
                        <div class="input-group mb-3">
                            <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" 
                                placeholder="現在のパスワード">
    
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                </div>
                            </div>
    
                            @error('current_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    <label for="password" class="form-label">{{__('messages.new_password')}}</label>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                            placeholder="{{ __('adminlte::adminlte.password') }}">

                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                            </div>
                        </div>

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    {{-- Password confirmation field --}}
                    <label for="password_confirmation" class="form-label">{{__('messages.confirm_password')}}</label>
                    <div class="input-group mb-3">
                        <input type="password" name="password_confirmation"
                            class="form-control @error('password_confirmation') is-invalid @enderror"
                            placeholder="{{ trans('adminlte::adminlte.retype_password') }}">

                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                            </div>
                        </div>

                        @error('password_confirmation')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">{{ __("messages.save") }}</button>
                        <a href="{{ route('estate.index') }}" class="btn btn-default float" style="margin-left:10px">@lang('messages.cancel')</a>
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