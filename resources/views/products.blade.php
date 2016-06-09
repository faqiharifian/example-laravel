@extends('layout')

@section('title', 'Products - Amartha Furniture')

@section('content')
	<div id="product">
		<div class="container">
			<div class="title">
				<p>NOW VIEWING</p>
				<h1><b>{{ Request::get('category') != "" ? App\Models\Category::whereSlug(Request::get('category'))->first()->name : "Products" }}</b></h1>
			</div>
			<div class="gallery">
				@forelse($products as $product)
					<a href="{{ action('ProductController@show', ['product' => $product->id]) }}">
						<figure class="col-sm-4">
							<div class="box">
								<div class="div-img vertical-center" style="background-image: url('/{{ Config::get('path.uploads') }}/products/{{ $product->id }}/{{ $product->images()->orderBy('order', 'asc')->first()->image }}')">
									<img class="" src="/{{ Config::get('path.placeholder-1x1') }}">
								</div>
								<figcaption class="item-name">{{ $product->name }}</figcaption>
								<div class="item-detail">
									<figcaption class="detail">{{ $product->subtitle }}</figcaption>
									<figcaption class="detail">{{ round($product->width) }} x {{ round($product->height) }} x {{ round($product->depth) }}</figcaption>
									<a class="btn btn-default hover" href="{{ action('ProductController@show', ['product' => $product->id]) }}">View Detail</a>
								</div>
							</div>
						</figure>
					</a>
				@empty
					<p style="text-align: center">Product Not Found</p>
				@endforelse
				@if($products->count() > 0)
					<div class="pagination">
						<a href="{{ $products->previousPageUrl() }}">&lt;</a>
						@if($products->currentPage() > 2 && $products->lastPage() > 3)
							<a href="{{ $products->url(1) }}">1</a>
							@if($products->lastPage() > 5)
								<span>...</span>
							@endif
						@endif
						@if($products->currentPage() == $products->lastPage() && $products->lastPage() > 2)
							<a href="{{ $products->url($products->currentPage()-2) }}">{{ $products->currentPage()-2 }}</a>
						@endif
						@if($products->currentPage() != 1)
							<a href="{{ $products->previousPageUrl() }}">{{ $products->currentPage()-1 }}</a>
						@endif
						<a class="active"><b>{{ $products->currentPage() }}</b></a>
						@if($products->currentPage() != $products->lastPage())
							<a href="{{ $products->nextPageUrl() }}">{{ $products->currentPage()+1 }}</a>
						@endif
						@if($products->currentPage() == 1 && $products->lastPage() > 2)
							<a href="{{ $products->url($products->currentPage()+2) }}">{{ $products->currentPage()+2 }}</a>
						@endif
						@if($products->currentPage() < ($products->lastPage()-1) && $products->lastPage() > 3)
							@if($products->lastPage() > 5)
								<span>...</span>
							@endif
							<a href="{{ $products->url($products->lastPage()) }}">{{ $products->lastPage() }}</a>
						@endif
						<a href="{{ $products->nextPageUrl() }}">&gt;</a>
					</div>
				@endif

				<div class="clear"></div>
			</div>
		</div>
	</div>
@endsection

@section('content_js')
	<script type="text/javascript">
		var screen_size = $(window).width();
		if (screen_size < 768) {
			$('#dLabel').attr('data-toggle', 'dropdown');
			$('.dropdown').removeClass('open');
		}
	</script>
@stop