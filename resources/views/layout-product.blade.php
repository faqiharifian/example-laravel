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
		
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
		<!-- Bootstrap -->
		<link rel="stylesheet" href="/{{ Config::get('path.css') }}/bootstrap.min.css">
		<link rel="stylesheet" href="/{{ Config::get('path.css') }}/amartha.css">
		<link rel="stylesheet" media="screen and (max-device-width: 1200px)" href="/{{ Config::get('path.css') }}/responsive.css">
	</head>

	<body>
		<hr class="roof-top">
		<header>
			<div class="header-top container">
				<div class="row">
					<div class="logo">
						<img class="vertical-center" src="/assets/images/amartha-logo.png">
					</div>
					<div class="search-wrapper vertical-center">
						<form action="" method="POST">
							<input id="search" type="search" name="search"/>
							<button id="submit" type="submit" value="">
								<div id="ic_search" class="vertical-center sprite-icon"></div>
							</button>
						</form>
					</div>
					<div class="phone">
						<div id="ic_phone" class="vertical-center sprite-icon"></div>
						<div id="no_phone" class="vertical-center">024-335-1234</div>
					</div>
				</div>
			</div>
			<div class="header-bottom container">
				<div class="row">
					<div class="dropdown open col-md-3">
						<div id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					    <span class="category-title vertical-center">Categories</span><span class="glyphicon glyphicon-menu-hamburger vertical-center"></span>
						</div>
						<ul class="dropdown-menu">
						    <form id="header_category_form" method="POST" action="/tes">
							    <div class="category col-md-3">
							    	<ul class="nav">
							    		<li id="outdoor_menu" class="radio"><label><input type="radio" name="category" value="outdoor">OUTDOOR</label></li>
							    		<li id="indoor_menu" class="radio"><label><input type="radio" name="category" value="indoor">INDOOR</label></li>
							    	</ul>
							    </div>
							    <div class="sub-category col-md-9">
							    	<ul class="nav">
										<li class="col-md-2">
											<label>
												<input type="radio" name="sub_category" value="Tables">
												<div class="vertical-center"><div id="ic_table" class="sprite-icon"></div><div>Tables</div></div>
											</label>
										</li>
										<li class="col-md-2">
											<label>
												<input type="radio" name="sub_category" value="Chairs">
												<div class="vertical-center"><div id="ic_chair" class="sprite-icon"></div><div>Chairs</div></div>
											</label>
										</li>
										<li class="col-md-2">
											<label>
												<input type="radio" name="sub_category" value="Armchairs">
												<div class="vertical-center"><div id="ic_arm_chair" class="sprite-icon"></div><div>Armchairs</div></div>
											</label>
										</li>
										<li class="col-md-2">
											<label>
												<input type="radio" name="sub_category" value="Sofas">
												<div class="vertical-center"><div id="ic_sofa" class="sprite-icon"></div><div>Sofas</div></div>
											</label>
										</li>
										<li class="col-md-2">
											<label>
												<input type="radio" name="sub_category" value="Longers">
												<div class="vertical-center"><div id="ic_longer" class="sprite-icon"></div><div>Longers</div></div
											></label>
										</li>
										<li class="col-md-2">
											<label>
												<input type="radio" name="sub_category" value="Sidetables">
												<div class="vertical-center"><div id="ic_side_table" class="sprite-icon"></div><div>Sidetables</div></div>
											</label>
										</li>
									</ul>
							    </div>
							</form>
						</ul>
					</div>
					<div class="menu">
						<ul class="nav navbar-nav">
							<li><a href="{{ url('/') }}">Home</a></li>
							<li id="menu_product"><a href="{{ url('/product') }}">Product</a></li>
							<li><a href="{{ url('/contact-us') }}">Contact Us</a></li>
							<li><a href="{{ url('/about-us') }}">About Us</a></li>
						</ul>
					</div>
				</div>
			</div>
	    </header>

	    @yield('content')

	    <div class="download container">
	    	<div class="download-wrapper">
		    	<a href="">
		    		<div id="ic_pdf" class="sprite-icon"></div>
		    		<h4>DOWNLOAD FULL CATALOG IN PDF FILE</h4>
		    	</a>
	    	</div>
	    </div>
	    <footer>
	    	<div class="footer-top">
		    	<div class="container">
		    		<div class="col-sm-3 about">
		    			<h4>About Amartha Furniture</h4>
		    			<p>
		    				Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
		    				tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
		    				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
		    				consequat. Duis aute irure dolor in reprehenderit.
		    			</p>
		    			<a href=""><b><i>read more...</i></b></a>
		    		</div>
		    		<div class="col-sm-3 w-22">
		    			<h4>Information</h4>
		    			<ul class="nav">
		    				<li><a href="">About Us</a></li>
		    				<li><a href="">Catalog Product</a></li>
		    				<li><a href="">Privacy and Terms of Use</a></li>
		    				<li><a href="">Contact Us</a></li>
		    			</ul>
		    		</div>
		    		<div class="col-sm-3 w-22">
		    			<h4>Product</h4>
		    			<ul class="nav">
		    				<li><a href="">Living Room</a></li>
		    				<li><a href="">Dining Room</a></li>
		    				<li><a href="">Sofas</a></li>
		    				<li><a href="">Collections</a></li>
		    			</ul>
		    		</div>
		    		<div class="col-sm-3 customer-service">
		    			<h4>Customer Service</h4>
		    			<ul class="nav">
		    				<li>
				    			<div id="ic_footer_phone" class="sprite-icon"></div>
				    			<span>0809 8 9999</span>
			    			</li>
			    			<li>
				    			<div id="ic_email" class="sprite-icon"></div>
                                <span><a href="mailto:cs@amarthafurniture.com">cs@amarthafurniture.com</a></span>
			    			</li>
			    			<div class="social-media">
				    			<a href=""><div id="ic_facebook" class="sprite-icon"></div></a>
				    			<a href=""><div id="ic_twitter" class="sprite-icon"></div></a>
				    			<a href=""><div id="ic_instagram" class="sprite-icon"></div></a>
				    			<a href=""><div id="ic_google_plus" class="sprite-icon"></div></a>
			    			</div>
			    		</ul>
		    		</div>
	    		</div>
	    	</div>
	    	<div class="footer-bottom">
	    		<hr class="container">
	    		<div class="container vertical-center">
	    			<div class="col-sm-9">
	    				Copyright &copy; 2016 <b>Durenworks</b> | <a href="">Privacy Policy</a> | <a href="">About Amartha Furniture</a> | <a href="">FAQ</a> | <a href="">Contact Support</a>
	    			</div>
	    			<div class="col-sm-3">
	    				Designed by <a href=""><b>Durenworks</b></a>
	    			</div>
	    		</div>
	    	</div>
	    </footer>

		<script src="/{{ Config::get('path.js') }}/jquery-1.12.2.min.js"></script>
		<script src="/{{ Config::get('path.js') }}/bootstrap.min.js"></script>
		<script type="text/javascript">
			/* Activate product menu */
	        $(document).ready(function(){
	        	$('header #menu_product').addClass('active');
	        });

			// Prevent dropdown to collapse
			$('.dropdown').on('hide.bs.dropdown', function () {
			    return false;
			});
			$('#dLabel').on('click', function(){
				$(this).next().find('input:radio').prop('checked', false);
				$('.category .nav li').removeClass('active');
			});
			$('#outdoor_menu input:radio').on('change', function(){
	            $('#indoor_menu').removeClass('active');
	            $('#outdoor_menu').addClass('active');
	        });
	        $('#indoor_menu input:radio').on('change', function(){
	            $('#outdoor_menu').removeClass('active');
	            $('#indoor_menu').addClass('active');
	        });

	        /* Submit category form on header */
	        $('.header-bottom .sub-category label').on('click', function(){
	        	$('#header_category_form').submit();
	        });
		</script>
		@yield('content_js')

	</body>
</html>
