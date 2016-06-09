@extends('layout')

@section('title', 'Login - Amartha Furniture')

@section('head')
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endsection
@section('content')
    <div class="login">
        <div class="container">
            <div class="title">
                <p>You've got a Wooden Street account, please login to continue.<br>
                Don't have one? <a href="#!" onclick="toggle('signup')">Create an account</a></p>
                <h1><b id="login-text">Login to Your Account</b></h1>
            </div>

            <div class="row login-form">
                <form action="{{ action('CustomerAuthController@authenticate') }}" method="post">
                <div class="col-sm-6">
                    <div class="form-wrapper">
                        <!-- Login -->
                        <div class="login-elmt">
                            @if(session('error'))
                                <p class="text-danger">{{ session('error') }}</p>
                            @endif
                            @if(session('success'))
                                <p class="text-success">{{ session('success') }}</p>
                            @endif
                            <div class="form-group">
                                <input type="email" class="form-control" name="email_login" placeholder="Email Address*" value="{{ old('email_login') }}" required>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="password_login" placeholder="Password*" required>
                            </div>
                        </div>

                        <!-- Sign up -->
                        <div class="sign-up-elmt">
                            @if(session('error'))
                                <p class="text-danger">{{ session('error') }}</p>
                            @endif
                            <div class="form-group">
                                <input id="name" type="text" class="form-control" name="name" placeholder="Full Name*" value="{{ old('name') }}" required>
                                {!! $errors->first('name', '<p class="text-danger">:message</p>') !!}
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" name="email_register" placeholder="Email Address*" value="{{ old('email_register') }}" required>
                                {!! $errors->first('email_register', '<p class="text-danger">:message</p>') !!}
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="password" placeholder="Password*" required>
                                {!! $errors->first('password', '<p class="text-danger">:message</p>') !!}
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password*" required>
                            </div>

                        </div>
                        {!! csrf_field() !!}
                        <div class="g-recaptcha" data-sitekey="{{ Config::get('recaptcha.site_key') }}"></div>
                        <div class="sign-up-elmt">
                            <input class="sign-in-btn" type="submit" name="submit" value="SIGN UP">
                            <a href="#!" onclick="toggle('login')">LOGIN</a>
                        </div>
                        <div class="login-elmt">
                            <input class="sign-in-btn" type="submit" name="submit" value="SIGN IN">
                            <a href="">FORGOT YOUR PASSWORD?</a>
                            <p class="sign-up">Don't have account? <a href="#!" onclick="toggle('signup')">SIGN UP</a></p>
                        </div>
                    </div>
                </div>
                </form>

                <div class="or">
                    <div class="vertical-line"></div>
                    <div>OR</div>
                    <div class="vertical-line"></div>
                </div>

                <div class="col-sm-6" style="text-align: center;">
                    <div class="login-social-media">
                        <a href="{{ action('CustomerAuthController@redirect', ['provider' => 'facebook']) }}">
                            <div id="ic_fb_login"></div>
                            <div class="login_fb">LOG-IN USING FACEBOOK</div>
                        </a>
                    </div>
                    <br><br><br>
                    <div class="login-social-media" style="margin-top: 6px;">
                        <a href="{{ action('CustomerAuthController@redirect', ['provider' => 'google']) }}">
                            <div id="ic_gplus_login"></div>
                            <div class="login_gplus">LOG-IN USING GOOGLE</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content_js')
    <script type="text/javascript">


        $(function(){
            @if(old('name') != "")
                $('#login-text').text("Create an Account");
                $('.login-elmt').hide();
                $('.login-elmt input').removeAttr('required');
                $('.sign-up-elmt').show();
                $('.sign-up-elmt input').attr('required', 'required');
            @else
                $('#login-text').text("Login to Your Account");
                $('.login-elmt').show();
                $('.login-elmt input').attr('required', 'required');
                $('.sign-up-elmt').hide();
                $('.sign-up-elmt input').removeAttr('required');
            @endif
        });
        function toggle(target) {
            if(target == 'signup') {
                $('#login-text').text("Create an Account");
                $('.login-elmt').hide();
                $('.login-elmt input').removeAttr('required');
                $('.sign-up-elmt').show();
                $('.sign-up-elmt input').attr('required', 'required');
            }else if(target == 'login'){
                $('#login-text').text("Login to Your Account");
                $('.login-elmt').show();
                $('.login-elmt input').attr('required', 'required');
                $('.sign-up-elmt').hide();
                $('.sign-up-elmt input').removeAttr('required');
            }
        }
    </script>
@stop