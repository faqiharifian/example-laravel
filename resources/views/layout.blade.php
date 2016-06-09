<!DOCTYPE html>
<html lang="en">

	<!--======================================================
	==			///////		    ///////	   ///////			==
	==			///  ///	  ////		  ////				==
	==			///  ////	////		  ////////			==
	==			///  ///	 ////		      ////			==
	==			///////		  ////////	  ///////			==
	=======================================================-->

	<head>
		<title>@yield('title')</title>

		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="keywords" content="Custom woodworking 880 low 16.588, Furniture company 1000 low 31.197">

		<meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
		<!-- Bootstrap -->
		<link rel="stylesheet" href="/{{ Config::get('path.css') }}/bootstrap.min.css">
		<link rel="stylesheet" href="/{{ Config::get('path.css') }}/amartha.css">
		<link rel="stylesheet" media="screen and (max-device-width: 1200px)" href="/{{ Config::get('path.css') }}/responsive.css">
		@yield('head')
	</head>

	<body>
		<div class="roof-top">
			<div class="container" style="padding-top: 3px;">
				@if(Auth::check())
					{{ Auth::user()->getName() }} <a href="{{ action('CustomerAuthController@logout') }}">LOGOUT</a>
				@else
					<a href="{{ action('CustomerAuthController@login') }}">LOGIN</a>
				@endif
			</div>
		</div>
		<header>
			<div class="header-top container">
				<div class="row">
					<a href="{{ action('HomeController@index') }}">
						<div class="logo">
							<img class="vertical-center" src="/{{ Config::get('path.images') }}/amartha-logo.png">
						</div>
					</a>
					<div class="dropdown submit_490">
					  <button id="submit_490" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					    <div id="ic_search" class="vertical-center sprite-icon"></div>
					  </button>
					  <ul class="dropdown-menu" aria-labelledby="submit_490">
					  	<div class="form-wrapper vertical-center">
					    	<form id="search-form" action="{{ action('ProductController@search') }}" method="get">
								<input id="search" type="search" name="q"/>
								<button id="submit" type="submit">
									<div id="ic_search" class="vertical-center sprite-icon"></div>
								</button>
							</form>
						</div>
					  </ul>
					</div>
					<div class="vertical-center hidden-490">
						<div class="search-wrapper vertical-center">
							<form action="{{ action('ProductController@search') }}" method="get">
								<input id="search" type="search" name="q"/>
								<button id="submit" type="submit">
									<div id="ic_search" class="vertical-center sprite-icon"></div>
								</button>
							</form>
						</div>
						<div class="phone hidden-xs">
							<a href="tel:+62243351234">
								<div id="ic_phone" class="vertical-center sprite-icon"></div>
								<div id="no_phone" class="vertical-center">024-335-1234</div>
							</a>
						</div>
					</div>
				</div>
			</div>
			<div class="header-bottom container">
				<div class="row">
					<div class="dropdown col-xs-12 {{ isset($productPage) ? ($productPage ? " open" : "") : "" }}">
						<div id="dLabel" class="col-sm-3 col-xs-4" type="button" data-toggle="{{ isset($productPage) ? ($productPage ? "" : 'dropdown') : "dropdown" }}" aria-haspopup="true" aria-expanded="false">
					    <span class="category-title vertical-center">Categories</span><span class="glyphicon glyphicon-menu-hamburger vertical-center hidden-xs"></span>
						</div>
						<ul class="dropdown-menu">
							<form id="header_category_form" method="get" action="{{ action('ProductController@index') }}">
							    <div class="category col-sm-3 col-xs-4">
							    	<ul class="nav">
							    		<li id="outdoor_menu" class="radio{{ Request::get('type') == 'outdoor' ? " active" : "" }}">
											<label>
												<input type="radio" name="type" value="outdoor"{{ Request::get('type') == 'outdoor' ? " checked" : "" }}>
												OUTDOOR
											</label>
										</li>
							    		<li id="indoor_menu" class="radio{{ Request::get('type') == 'indoor' ? " active" : "" }}">
											<label>
												<input type="radio" name="type" value="indoor"{{ Request::get('type') == 'indoor' ? " checked" : "" }}>
												INDOOR
											</label>
										</li>
							    	</ul>
							    </div>
							    <div class="sub-category col-sm-9 col-xs-4">
							    	<ul class="nav">
										<li class="col-sm-2 {{ Request::get('category') =="tables"  ? " active" : "" }}">
											<label>
												<input type="radio" name="category" value="tables" {{ Request::get('category') =="tables"  ? " checked" : "" }}>
												<div class="vertical-center"><div id="ic_table" class="sprite-icon hidden-xs"></div><div>Tables</div></div>
											</label>
										</li>
										<li class="col-sm-2 {{ Request::get('category') =="chairs"  ? " active" : "" }}">
											<label>
												<input type="radio" name="category" value="chairs" {{ Request::get('category') =="chairs"  ? " checked" : "" }}>
												<div class="vertical-center"><div id="ic_chair" class="sprite-icon hidden-xs"></div><div>Chairs</div></div>
											</label>
										</li>
										<li class="col-sm-2 {{ Request::get('category') =="armchairs"  ? " active" : "" }}">
											<label>
												<input type="radio" name="category" value="armchairs" {{ Request::get('category') =="armchairs"  ? " checked" : "" }}>
												<div class="vertical-center"><div id="ic_arm_chair" class="sprite-icon hidden-xs"></div><div>Armchairs</div></div>
											</label>
										</li>
										<li class="col-sm-2 {{ Request::get('category') =="sofas"  ? " active" : "" }}">
											<label>
												<input type="radio" name="category" value="sofas" {{ Request::get('category') =="sofas"  ? " checked" : "" }}>
												<div class="vertical-center"><div id="ic_sofa" class="sprite-icon hidden-xs"></div><div>Sofas</div></div>
											</label>
										</li>
										<li class="col-sm-2 {{ Request::get('category') =="longers"  ? " active" : "" }}">
											<label>
												<input type="radio" name="category" value="longers" {{ Request::get('category') =="longers"  ? " checked" : "" }}>
												<div class="vertical-center"><div id="ic_longer" class="sprite-icon hidden-xs"></div><div>Longers</div></div
											></label>
										</li>
										<li class="col-sm-2 {{ Request::get('category') =="sidetables"  ? " active"  : ""}}">
											<label>
												<input type="radio" name="category" value="sidetables" {{ Request::get('category') =="sidetables"  ? " checked"  : ""}}>
												<div class="vertical-center"><div id="ic_side_table" class="sprite-icon hidden-xs"></div><div>Sidetables</div></div>
											</label>
										</li>
									</ul>
							    </div>
							</form>
						</ul>
					</div>
					<div class="menu">
						<div class="navbar-header">
					        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					          <span class="sr-only">Toggle navigation</span>
					          <span class="icon-bar"></span>
					          <span class="icon-bar"></span>
					          <span class="icon-bar"></span>
					        </button>
					    </div>
					    <div id="navbar" class="navbar-collapse collapse">
							<ul class="nav navbar-nav">
								<li id="menu_home" {{ isset($home) ? "class=active" : "" }}><a href="{{ url('/') }}">Home</a></li>
								<li {{ isset($productPage) ? "class=active" : "" }}><a href="{{ action('ProductController@index') }}">Product</a></li>
								<li id="menu_contact" {{ isset($contactUs) ? "class=active" : "" }}><a href="{{ action('CompanyInfoController@contactUs') }}">Contact Us</a></li>
								<li id="menu_about" {{ isset($aboutUs) ? "class=active" : "" }}><a href="{{ action('CompanyInfoController@aboutUs') }}">About Us</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
	    </header>

	    @yield('content')

		@if((isset($products) || isset($product) || isset($contactUs) || isset($login) || isset($policies)) && !isset($custom) && !isset($home))
	    <div class="get-started">
		    <div class="container">
		    	<div class="get-started-wrapper">
					<div class="col-xs-9">
						<h2>PERSONALIZED CUSTOM FURNITURE FOR ALL YOUR NEEDS</h2>
						<p>We are ready to make your custom furniture design</p>
					</div>
					<div class="col-xs-3">
						<a class="get-started-btn" href="{{ action('ProductController@custom') }}"><b>Get Started</b></a>
					</div>
		    	</div>
		    </div>
	    </div>
		@endif

		@if(isset($home) || isset($aboutUs))
		<!-- Icon -->
		<div class="legal-wood">
			<div class="container">
				<div class="vertical-center">
					<img src="/{{ Config::get('path.images') }}/icon/ilw.jpg" style="margin-right: 160px;">
					<img src="/{{ Config::get('path.images') }}/icon/asmindo.jpg">
				</div>
		    </div>
		</div>
		@endif

	    <footer>
	    	<div class="footer-top">
		    	<div class="container">
		    		<div class="col-sm-3 hidden-xs about">
		    			<h4>About Amartha Furniture</h4>
		    			<p>
							Amartha furniture is a furniture company located at Jepara, the home to various furniture manufacturers in Indonesia. The company is a part of Cv. Jatindo Ukir Jepara and is managed by CEO Sutrimo Yusuf. With more than 20 years of hands on experience, Amartha is one of the top 5 furniture company in Jepara.
		    			</p>
		    			<a href="{{ action('CompanyInfoController@aboutUs') }}"><b><i>read more...</i></b></a>
		    		</div>
		    		<div class="col-sm-3 w-22 company">
		    			<h4>Company Info</h4>
		    			<ul class="nav">
		    				<li><a href="{{ action('CompanyInfoController@aboutUs') }}">About Us</a></li>
		    				<li><a href="{{ action('ProductController@index') }}">Catalog Product</a></li>
		    				<li><a href="{{ action('CompanyInfoController@policies') }}">Privacy and Terms of Use</a></li>
		    				<li><a href="{{ action('CompanyInfoController@contactUs') }}">Contact Us</a></li>
		    			</ul>
		    		</div>
		    		<div class="col-sm-3 w-22">
		    			<h4>Product</h4>
		    			<ul class="nav">
		    				<li><a href="{{ action('ProductController@index', ['category' => 'tables']) }}">Tables</a></li>
		    				<li><a href="{{ action('ProductController@index', ['category' => 'chairs']) }}">Chairs</a></li>
		    				<li><a href="{{ action('ProductController@index', ['category' => 'armchairs']) }}">Armchairs</a></li>
		    				<li><a href="{{ action('ProductController@index', ['category' => 'sofas']) }}">Sofas</a></li>
		    				<li><a href="{{ action('ProductController@index', ['category' => 'longers']) }}">Longers</a></li>
		    				<li><a href="{{ action('ProductController@index', ['category' => 'sidetables']) }}">Sidetables</a></li>
		    			</ul>
		    		</div>
		    		<div class="col-sm-3 customer-service">
		    			<h4>Customer Service</h4>
		    			<ul class="nav">
		    				<li>
				    			<div id="ic_footer_phone" class="sprite-icon"></div>
				    			<span><a href="tel:+6280989999">0809 8 9999</a></span>
			    			</li>
			    			<li>
				    			<div id="ic_email" class="sprite-icon"></div>
                                <span><a href="mailto:cs@amarthafurniture.com">cs@amarthafurniture.com</a></span>
			    			</li>
			    		</ul>
		    		</div>
	    		</div>
	    	</div>
	    	<div class="footer-bottom">
	    		<div class="container">
	    			<hr>
	    		</div>
	    		<div class="container vertical-center">
	    			<div class="col-sm-9 col-xs-12">
	    				Copyright &copy; 2016 <b><a href="https://durenworks.com">Durenworks</a></b>
	    			</div>
	    			<div class="col-sm-3 hidden-xs">
	    				Designed by <a href="https://durenworks.com"><b>Durenworks</b></a>
	    			</div>
	    		</div>
	    	</div>
	    </footer>

		<script src="/{{ Config::get('path.js') }}/jquery-1.12.2.min.js"></script>
		<script src="/{{ Config::get('path.js') }}/bootstrap.min.js"></script>
		<script type="text/javascript">
	        /* Submit category form on header */
			$('header input[name=type]').on('change', function(){
				$('header input[name=type]').parent().parent().removeClass('active');
				$(this).parent().parent().addClass('active');
//				if($('header input[name=category]').is(':checked')){
					$('#header_category_form').submit();
//				}
			});
			$('header input[name=category]').on('change', function(){
				$('header input[name=category]').parent().parent().removeClass('active');
				$(this).parent().parent().addClass('active');
//				if($('header input[name=type]').is(':checked')){
					$('#header_category_form').submit();
//				}
			});
			$(document).on('submit', '#search-form', function(e){
				if($(this).find('input').val() == ""){
					e.preventDefault();
				}
			});
	    </script>
		@yield('content_js')

	</body>
</html>
