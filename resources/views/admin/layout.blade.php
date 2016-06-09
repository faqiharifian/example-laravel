<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>@yield('title') - Admin Amartha Furniture</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="/{{ Config::get('path.css') }}/bootstrap.min.css" rel="stylesheet" />

    <!--  Paper Dashboard core CSS    -->
    <link href="/{{ Config::get('path.css') }}/paper-dashboard.css" rel="stylesheet"/>

    <!--  Fonts and icons     -->
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href="/{{ Config::get('path.css') }}/icomoon.css" rel="stylesheet">
    @yield('content_css')
    <link href="/{{ Config::get('path.css') }}/admin.css" rel="stylesheet"/>
</head>
<body>

<div class="wrapper">
    <div class="sidebar" data-background-color="white" data-active-color="danger">

        <div class="sidebar-wrapper">
            <div class="logo" style="padding: 0;">
                <a href="{{ url('/') }}" class="simple-text">
                    <img src="/{{ Config::get('path.images') }}/amartha-logo.png" alt="" style="max-width: 100%;height: 65px">
                </a>
            </div>

            <ul class="nav">
                <li {{ isset($dashboard) ? "class=active" : "" }}>
                    <a href="{{ action('Admin\HomeController@index') }}">
                        <i class="glyphicon glyphicon-dashboard"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li {{ (isset($products) || isset($product)) && !isset($dashboard) ? "class=active" : "" }}>
                    <a href="{{ action('Admin\ProductController@index') }}">
                        <i class="glyphicon glyphicon-th-list"></i>
                        <p>Products</p>
                    </a>
                </li>
                <li {{ (isset($customProducts) || isset($customProduct)) && !isset($dashboard) ? "class=active" : "" }}>
                    <a href="{{ action('Admin\CustomProductController@index') }}">
                        {{--*/ $newCustomProduct = \App\Models\CustomProduct::whereNew(true)->count() /*--}}
                        @if($newCustomProduct > 0)
                            <span class="badge">{{ $newCustomProduct }}</span>
                        @endif
                        <i class="glyphicon glyphicon-th-list"></i>
                        <p>Custom Furniture</p>
                    </a>
                </li>
                <li {{ isset($sliders) && !isset($dashboard) ? "class=active" : "" }}>
                    <a href="{{ action('Admin\SliderController@index') }}">
                        <i class="glyphicon glyphicon-blackboard"></i>
                        <p>Slider</p>
                    </a>
                </li>
                <li {{ isset($users) || isset($user) ? "class=active" : "" }}>
                    <a href="{{ action('Admin\UserController@index') }}">
                        <i class="glyphicon glyphicon-user"></i>
                        <p>Users</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="main-panel">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar bar1"></span>
                        <span class="icon-bar bar2"></span>
                        <span class="icon-bar bar3"></span>
                    </button>
                    <a class="navbar-brand" href="#">@yield('title')</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <p>{{ explode("@", Auth::user()->email)[0] }}</p>
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ action('Admin\UserController@getPassword', ['user' => Auth::user()->id]) }}">Change Password</a></li>
                                <li><a href="{{ url('/admin/logout') }}">Logout</a></li>
                            </ul>
                        </li>
                    </ul>

                </div>
            </div>
        </nav>


        <div class="content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>

    </div>
</div>


</body>

<!--   Core JS Files   -->
<script src="/{{ Config::get('path.js') }}/jquery-1.12.2.js" type="text/javascript"></script>
<script src="/{{ Config::get('path.js') }}/bootstrap.min.js" type="text/javascript"></script>

<!--  Checkbox, Radio & Switch Plugins -->
{{--<script src="/{{ Config::get('path.js') }}/bootstrap-checkbox-radio.js"></script>--}}


<!-- Paper Dashboard Core javascript and methods for Demo purpose -->
<script src="/{{ Config::get('path.js') }}/paper-dashboard.js"></script>

@yield('content_js')

</html>
