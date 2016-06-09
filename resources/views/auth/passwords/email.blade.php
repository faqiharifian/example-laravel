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
    <link href="/{{ Config::get('path.css') }}/bootstrap.min.css" rel="stylesheet">
    <link href="/{{ Config::get('path.css') }}/auth.css" rel="stylesheet">

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
        <form class="form-signin" action="{{ url('/admin/reset') }}" method="post">

            <h2 class="form-signin-heading">Reset Password</h2>
            @if(session('error') != null)
                <p class="bg-danger"><b>{!! session('error') !!}</b></p>
            @endif
            <div class="form-group {{ $errors->first('email') != null ? "has-error" : "" }}">
                <label for="inputEmail" class="sr-only">Email address</label>
                <input type="email" id="inputEmail" class="form-control" placeholder="Email address" name="email" value="{{ old('email') }}" required autofocus>
                {!! $errors->first('email', '<p class="text-danger">:message</p>') !!}
            </div>

            {!! csrf_field() !!}
            <button class="btn btn-lg btn-primary btn-block" type="submit">Send Password Reset Link</button>

        </form>
    </div>
</div>
</div>
<!-- Bootstrap core JavaScript
       ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<!--<script src="../../assets/js/docs.min.js"></script>-->
@if(session('status') != null)
    <script src="/{{ Config::get('path.js') }}/jquery-1.12.2.min.js"></script>
    <script src="/{{ Config::get('path.js') }}/bootstrap-notify.js"></script>

    <script>
        $.notify({
            icon: 'glyphicon glyphicon-ok',
            message: '\n{{ session('status') }}\n'

        },{
            type: 'success',
            timer: 4000
        });
    </script>
@endif
</body>
</html>
