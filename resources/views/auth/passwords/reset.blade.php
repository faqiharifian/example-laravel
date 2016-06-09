<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!--<link rel="icon" href="../../favicon.ico">-->

    <!-- Bootstrap core CSS -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/auth.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <title>Reset Password - Admin Amartha Furniture</title>

</head>

<body id="login">
    <div class="col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8 col-xs-12">
        <div class="panel panel-default">
        <div class="panel-heading">
            <img src="/{{ Config::get('path.images') }}/amartha-logo.png">
        </div>
        <div class="panel-body">
            <form class="form-signin" action="{{ action('Auth\PasswordController@postReset', ['token' => $token]) }}" method="post">

                <h2 class="form-signin-heading">Reset Password</h2>
                @if(session('error') != null)
                    <p class="bg-danger"><b>{!! session('error') !!}</b></p>
                @endif
                @if(session('status') != null)
                    <p class="bg-success"><b>{!! session('status') !!}</b></p>
                @endif
                <div class="form-group {{ $errors->first('email') != "" ? "has-error" : "" }}" style="margin-bottom: 15px">
                    <label for="email" class="sr-only">Email Address</label>
                    <input type="email" id="email" class="form-control" placeholder="Email Address" name="email" value="{{ $email }}" required autofocus readonly>
                    {!! $errors->first('email', '<p class="text-danger">:message</p>') !!}
                </div>


                <div class="form-group {{ $errors->first('password') != "" ? "has-error" : "" }}">
                    <label for="password" class="sr-only">Password</label>
                    <input type="password" id="password" class="form-control" placeholder="Password Min.6 characters" name="password" required>
                    {!! $errors->first('password', '<p class="text-danger">:message</p>') !!}
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="sr-only">Password Confirmation</label>
                    <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" placeholder="Password Confirmation" required>
                    {!! $errors->first('password_confirmation', '<p class="text-danger">:message</p>') !!}
                </div>


                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="token" value="{{ $token }}">
                <button class="btn btn-lg btn-primary btn-block" type="submit">Reset Password</button>

            </form>
        </div>
    </div>
    </div>
</body>
</html>
