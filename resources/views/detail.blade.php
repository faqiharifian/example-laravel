@extends('layout')

@section('title', 'Products - Amartha Furniture')

@section('content')
	<div id="detail">
		<div class="container">
			<div class="product">
				<div class="col-md-6 col-sm-12">
					<div id="slider" class="carousel slide" data-ride="carousel">
			            <!-- Indicators -->
			            <ol class="carousel-indicators">
							@foreach($product->images()->orderBy('order', 'asc')->get() as $key => $image)
								<li data-target="#slider" data-slide-to="{{ $key }}" {{ $key == 0 ? 'class=active' : '' }}>
									<div class="div-img" style="background-image: url('/{{ Config::get('path.uploads') }}/products/{{ $product->id }}/{{ $image->image }}')">
										<img src="/{{ Config::get('path.placeholder-1x1') }}">
									</div>
								</li>
							@endforeach
			            </ol>

			            <!-- Wrapper for slides -->
			            <div class="carousel-inner" role="listbox">
							@foreach($product->images()->orderBy('order', 'asc')->get() as $key => $image)
								<div class="item{{ $key == 0 ? ' active' : '' }}">
									<div class="div-img" style="background-image: url('/{{ Config::get('path.uploads') }}/products/{{ $product->id }}/{{ $image->image }}')">
										<img src="/{{ Config::get('path.placeholder-1x1') }}">
									</div>
								</div>
							@endforeach
			            </div>

			            <!-- Controls -->
			            <a class="left carousel-control" href="#slider" role="button" data-slide="prev">
			                <span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>
			                <span class="sr-only">Previous</span>
			            </a>
			            <a class="right carousel-control" href="#slider" role="button" data-slide="next">
			                <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
			                <span class="sr-only">Next</span>
			            </a>
			        </div>
				</div>
				<div class="col-md-6 col-sm-12 description">
					<a href="{{ action('ProductController@index', ['category' => $product->category->slug]) }}"><h4><span class="glyphicon glyphicon-menu-left"></span> Back to <b>{{ $product->category->name }}</b></h4></a>
					<br>
					<h5><b>{{ $product->subtitle }}</b></h5>
					<h2><b>{{ $product->name }}</b></h2>
					<p>{!! htmlspecialchars_decode($product->detail_html) !!}</p>
					<br>
					{{--<p><b>MATERIALS :</b></p>
					<P>{{ $product->material }}</P>--}}
					<br>
					<div class="specification">
						<ul class="nav">
							<li class="col-sm-2 col-xs-3">
								<div class="vertical-center">
									<span>WIDTH</span>
									<h4><b>{{ $product->width }}</b></h4>
									<span>cm</span>
								</div>
							</li>
							<li class="col-sm-2 col-xs-3 move">
								<div class="vertical-center">
									<span>HEIGHT</span>
									<h4><b>{{ $product->height }}</b></h4>
									<span>cm</span>
								</div>
							</li>
							<li class="col-sm-2 col-xs-3 move">
								<div class="vertical-center">
									<span>DEPTH</span>
									<h4><b>{{ $product->depth }}</b></h4>
									<span>cm</span>
								</div>
							</li>
							<li class="col-sm-2 col-xs-3 move">
								<div class="vertical-center">
									<span>WEIGHT</span>
									<h4><b>{{ $product->weight }}</b></h4>
									<span>kg</span>
								</div>
							</li>
						</ul>
					</div>
				</div>

				<div class="clear"></div>
			</div>

			<div class="similar-product">
				<div class="col-sm-3 col-xs-12">
					<h3 class="vertical-center"><b>Similar Product</b></h3>
				</div>
				<div class="col-sm-9 col-xs-12 product-list">
					@forelse($similars as $similar)
						<a class="col-sm-3 col-xs-12" href="{{ action('ProductController@show', ['product' => $similar->id]) }}">
							<div class="div-img" style="background-image: url('/{{ Config::get('path.uploads') }}/products/{{ $product->id }}/{{ $image->image }}')">
								<img src="/{{ Config::get('path.placeholder-1x1') }}">
							</div>
							<h4>{{ $similar->name }}</h4>
						</a>
					@empty
						<a class="col-xs-12">
							<p class="vertical-center">Similar Products Not Found</p>
						</a>
					@endforelse

				</div>

				<div class="clear"></div>
			</div>
		</div>
	</div>
@stop