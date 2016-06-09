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
    <title>Login - Admin Amartha Furniture</title>
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body id="login">

<div class="col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8 col-xs-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <img src="/{{ Config::get('path.images') }}/amartha-logo.png">
        </div>
        <div class="panel-body">
            <form class="form-signin" action="{{ url('/admin') }}" method="post">

                <h2 class="form-signin-heading">Please log in</h2>
                @if(session('error') != null)
                    <p class="bg-danger"><b>{!! session('error') !!}</b></p>
                @endif
                @if(session('success') != null)
                    <p class="bg-success"><b>{!! session('success') !!}</b></p>
                @endif
                <div class="form-group">
                    <label for="inputEmail" class="sr-only">Email address</label>
                    <input type="email" id="inputEmail" class="form-control" placeholder="Email address" name="email" value="{{ old('email') }}" required autofocus>
                </div>
                <div class="form-group">
                    <label for="inputPassword" class="sr-only">Password</label>
                    <input type="password" id="inputPassword" class="form-control" name="password" placeholder="Password" required>
                </div>
                <div class="form-inline">
                    <a href="{{ url('/admin/reset') }}" class="pull-right">Forgot Your Password?</a>

                    <div class="checkbox" style="width:50%">
                        <label class="checkbox">
                            <input type="checkbox" id="remember" name="remember">
                            <span class="first-icon glyphicon glyphicon-unchecked"></span>
                            <span class="second-icon glyphicon glyphicon-check"></span>
                            Remember me
                        </label>
                    </div>
                </div>

                <div class="g-recaptcha" data-sitekey="{{ Config::get('recaptcha.site_key') }}"></div>
                <input type="hidden" name="next" value="{{ Request::get('next') }}">
                {!! csrf_field() !!}
                <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
                <a href="{{ url('/') }}" title=""><span class="glyphicon glyphicon-arrow-left"></span>  Go to <strong>amarthafurniture.com</strong></a>
            </form>
        </div>
    </div>
</div>


<!-- Bootstrap core JavaScript
       ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<!--<script src="../../assets/js/docs.min.js"></script>-->
</body>
</html>
