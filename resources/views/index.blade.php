@extends('layout')

@section('title', 'Home - Amartha Furniture')

@section('content')
    <div class="container">
        @if($sliders->count() != 0)
            <div id="slider" class="carousel slide main" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    @foreach($sliders as $key => $slider)
                        <li data-target="#slider" data-slide-to="{{ $key }}"{{ $key == 0 ? " class=active" : "" }}></li>
                    @endforeach
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                    @foreach($sliders as $key => $slider)
                        <div class="item{{ $key == 0 ? " active" : "" }}">
                            <a {{ $slider->url != '' ? 'href='.$slider->url : '' }} target="_blank">
                                <div class="div-img" style="background-image: url('/{{ Config::get('path.uploads') }}/sliders/{{ $slider->image }}')">
                                    <img src="/{{ Config::get('path.placeholder-16x4') }}" alt="">
                                </div>
                            </a>
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
        @endif


        <div class="row categories">
            <div class="col-sm-4">
                <a href="{{ action('ProductController@index', ['category' => 'tables']) }}">
                    <div class="item">
                        <img src="/{{ Config::get('path.images') }}/index/categories/table.jpg" alt="">
                        <div class="title">
                            <h5>TABLES</h5>
                            <div class="view-all">
                                <button type="button" class="btn btn-default hover">VIEW ALL</button>
                                <p>VIEW ALL PRODUCT</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-4">
                <a href="{{ action('ProductController@index', ['category' => 'chairs']) }}">
                    <div class="item">
                        <img src="/{{ Config::get('path.images') }}/index/categories/chair.jpg" alt="">
                        <div class="title">
                            <h5>CHAIRS</h5>
                            <div class="view-all">
                                <button type="button" class="btn btn-default hover">VIEW ALL</button>
                                <p>VIEW ALL PRODUCT</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-4">
                <a href="{{ action('ProductController@index', ['category' => 'armchairs']) }}">
                    <div class="item">
                        <img src="/{{ Config::get('path.images') }}/index/categories/armchair.jpg" alt="">
                        <div class="title">
                            <h5>ARMCHAIRS</h5>
                            <div class="view-all">
                                <button type="button" class="btn btn-default hover">VIEW ALL</button>
                                <p>VIEW ALL PRODUCT</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-4">
                <a href="{{ action('ProductController@index', ['category' => 'sidetables']) }}">
                    <div class="item">
                        <img src="/{{ Config::get('path.images') }}/index/categories/side-table.jpg" alt="">
                        <div class="title">
                            <h5>SIDE TABLES</h5>
                            <div class="view-all">
                                <button type="button" class="btn btn-default hover">VIEW ALL</button>
                                <p>VIEW ALL PRODUCT</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-4">
                <a href="{{ action('ProductController@index', ['category' => 'longers']) }}">
                    <div class="item">
                        <img src="/{{ Config::get('path.images') }}/index/categories/lounger.jpg" alt="">
                        <div class="title">
                            <h5>LOUNGERS</h5>
                            <div class="view-all">
                                <button type="button" class="btn btn-default hover">VIEW ALL</button>
                                <p>VIEW ALL PRODUCT</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-4">
                <a href="{{ action('ProductController@index', ['category' => 'sofas']) }}">
                    <div class="item">
                        <img src="/{{ Config::get('path.images') }}/index/categories/sofa.jpg" alt="">
                        <div class="title">
                            <h5>SOFAS</h5>
                            <div class="view-all">
                                <button type="button" class="btn btn-default hover">VIEW ALL</button>
                                <p>VIEW ALL PRODUCT</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="row new-products">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title"><b>New Products</b></h4>
                </div>
                <div class="custom-panel-body">
                    @foreach($products as $product)
                        <a href="{{ action('ProductController@show', ['product' => $product->id]) }}">
                            <div class="col-custom-5">
                                <div class="item">
                                    <div class="div-img" style="background-image: url('/{{ Config::get('path.uploads') }}/products/{{ $product->id }}/{{ $product->images()->orderBy('order', 'asc')->first()->image }}')">
                                        <img src="/{{ Config::get('path.placeholder-1x1') }}">
                                    </div>
                                </div>
                                <div class="title"><b>{{ $product->name }}</b></div>
                                <div class="detail">
                                    <figcaption>{{ $product->subtitle }}</figcaption>
                                </div>
                                <div class="view-btn"><a class="btn btn-default" href="{{ action('ProductController@show', ['product' => $product->id]) }}">View Detail</a></div>
                            </div>
                        </a>
                        @endforeach
                </div>
            </div>
        </div>
        <br>
        <br>
    </div>
@endsection

@section('content_js')
@stop