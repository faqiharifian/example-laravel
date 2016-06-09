@extends('admin.layout')

@section('title', $product->name)

@section('content')
    <div class="container-fluid">
        <div class="product">
            <div class="col-sm-6">
                <div id="slider" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        @foreach($product->images()->orderBy('order', 'asc')->get() as $key => $image)
                            <li data-target="#slider" data-slide-to="{{ $key }}" {{ $key == 0 ? 'class=active' : '' }}>
                                <div class="div-img" style="background-image: url('/{{ Config::get('path.uploads') }}/products/{{ $product->id }}/{{ $image->image }}">
                                    <img class="vertical-center" src="/{{ Config::get('path.placeholder-1x1') }}" alt="">
                                </div>
                            </li>
                        @endforeach
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                        @foreach($product->images()->orderBy('order', 'asc')->get() as $key => $image)
                            <div class="item{{ $key == 0 ? ' active' : '' }}">
                                <div class="div-img" style="background-image: url('/{{ Config::get('path.uploads') }}/products/{{ $product->id }}/{{ $image->image }}')">
                                    <img src="/{{ Config::get('path.placeholder-1x1') }}" alt="">
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
            <div class="col-sm-6 description">
                @if($product->status == 'draft')
                    <p class="text-primary">Draft</p>
                @else
                    <p class="text-success">Published</p>
                @endif
                <div class="title">
                    <p>{{ $product->subtitle }}</p>
                    <h3>{{ $product->name }}</h3>
                </div>
                <p>{!! htmlspecialchars_decode($product->detail_html) !!}</p>
                <br>
                {{--<p><b>MATERIALS :</b></p>
                <P>{{ $product->material }}</P>--}}
                <br>
                <div class="specification">
                    <ul class="nav">
                        <li class="col-xs-3">
                            <div class="vertical-center">
                                <span>WIDTH</span>
                                <h4>{{ $product->width }}</h4>
                                <span>cm</span>
                            </div>
                        </li>
                        <li class="col-xs-3 move">
                            <div class="vertical-center">
                                <span>HEIGHT</span>
                                <h4>{{ $product->height }}</h4>
                                <span>cm</span>
                            </div>
                        </li>
                        <li class="col-xs-3 move">
                            <div class="vertical-center">
                                <span>DEPTH</span>
                                <h4>{{ $product->depth }}</h4>
                                <span>cm</span>
                            </div>
                        </li>
                        <li class="col-xs-3 move">
                            <div class="vertical-center">
                                <span>WEIGHT</span>
                                <h4>{{ $product->weight }}</h4>
                                <span>kg</span>
                            </div>
                        </li>
                    </ul>
                </div>
                <div style="margin-top: 25px;">
                    <a href="{{ action('Admin\ProductController@destroy', ['product' => $product->id]) }}" class="btn btn-danger btn-fill delete pull-right"><span class="glyphicon glyphicon-floppy-remove"></span><span class="hidden-xs action">  Delete</span></a>
                    <a href="{{ action('Admin\ProductController@edit', ['product' => $product->id]) }}" class="btn btn-primary btn-fill"><span class="glyphicon glyphicon-edit"></span><span class="hidden-xs action"> Edit</span></a>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('content_js')
    <script>
        $(function(){
            $('.delete').on('click', function(e){
                if(confirm("Are you sure want to delete this?") == false){
                    return false;
                }
            });
        });
    </script>
@endsection