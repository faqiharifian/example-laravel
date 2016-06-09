@extends('admin.layout')

@section('title', 'New User')

@section('content')
    <div class="col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8 col-xs-12">
        <div class="well">
                <form class="form-signin" action="{{ action('Admin\UserController@store') }}" method="post">
                    <div class="form-group{{ $errors->first('email') != "" ? " has-error" : "" }}">
                        <label for="inputEmail" class="sr-only">Email address</label>
                        <input type="email" class="form-control" placeholder="Email address" name="email" value="{{ old('email') }}" required autofocus>
                        {!! $errors->first('email', '<p class="text-danger">:message</p>') !!}
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