@extends('admin.layout')

@section('title', 'Change Password '.explode("@", $user->email)[0])

@section('content')
    <div class="col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8 col-xs-12">
        <div class="well">
            <form class="form-signin" action="{{ action('Admin\UserController@postPassword', ['user' => $user->id]) }}" method="post">
                <div class="form-group{{ $errors->first('email') != "" ? " has-error" : "" }}">
                    <label for="inputEmail" class="sr-only">Email address</label>
                    <input type="email" class="form-control" placeholder="Email address" name="email" value="{{ old('email') ? : $user->email }}" required autofocus readonly>
                    {!! $errors->first('email', '<p class="text-danger">:message</p>') !!}
                </div>
                <div class="form-group{{ $errors->first('old_password') != "" ? " has-error" : "" }}">
                    <label for="inputPassword" class="sr-only">Old Password</label>
                    <input type="password" id="inputPassword" class="form-control" name="old_password" placeholder="Old Password" required>
                    {!! $errors->first('old_password', '<p class="text-danger">:message</p>') !!}
                </div>
                <div class="form-group{{ $errors->first('password') != "" ? " has-error" : "" }}">
                    <label for="inputPassword" class="sr-only">Password</label>
                    <input type="password" id="inputPassword" class="form-control" name="password" placeholder="Password Min.6 characters" required>
                    {!! $errors->first('password', '<p class="text-danger">:message</p>') !!}
                </div>
                <div class="form-group{{ $errors->first('password_confirmation') != "" ? " has-error" : "" }}">
                    <label for="inputPassword" class="sr-only">Password Confirmation</label>
                    <input type="password" class="form-control" name="password_confirmation" placeholder="Password Confirmation" required>
                    {!! $errors->first('password_confirmation', '<p class="text-danger">:message</p>') !!}
                </div>

                {!! csrf_field() !!}
                <button class="btn btn-lg btn-primary btn-block btn-fill" type="submit">Save</button>
            </form>

        </div>
    </div>
@endsection