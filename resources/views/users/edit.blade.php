@extends('layouts.app')

@section('title', '用户资料编辑')

@section('content')

    <div class="container">
        <div class="panel panel-default col-md-10 col-md-offset-1">
            <div class="panel-heading">
                <h4>
                    <i class="glyphicon glyphicon-edit">编辑个人资料</i>
                </h4>
            </div>

            @include('common.error')

            <div class="panel-body">
                <form action="{{ route('users.update', $user->id) }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label for="name-field">用户名</label>
                        <input class="form-control" type="text" name="name" id="name-field" value="{{ old('name', $user->name) }}">
                    </div>

                    <div class="form-group">
                        <label for="email-field">邮箱</label>
                        <input class="form-control" type="text" name="email" id="email-field" value="{{ old('email', $user->email) }}">
                    </div>

                    <div class="form-group">
                        <label for="introduction-field">个人简介</label>
                        <input class="form-control" type="text" name="introduction" id="introduction-field" value="{{ old('introduction', $user->introduction) }}">
                    </div>

                    <div class="form-group">
                        <label for="avatar-label">用户头像</label>
                        <input type="file" name="avatar">

                        @if($user->avatar)
                            <br>
                            <img class="thumbnail img-responsive" src="{{ $user->avatar }}" width="200" />
                        @endif
                    </div>

                    <div class="well well-sm">
                        <button type="submit" class="btn btn-primary">保存</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection