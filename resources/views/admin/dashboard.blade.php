@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')

    <div class="col-sm-12">
        <div class="card">
            <div class="content">
                <a href="{{ action('Admin\SliderController@index') }}">
                    <div class="header">
                        <h4>Slider</h4>
                        <hr />
                    </div>
                </a>
                <div class="row">
                    @if($sliders->count() > 0)
                        <div id="slider" class="carousel slide main" data-ride="carousel" style="margin-bottom: 25px; margin: 25px;">
                            <!-- Indicators -->
                            <ol class="carousel-indicators">
                                @foreach($sliders as $key => $slider)
                                    <li data-target="#slider" data-slide-to="{{ $key }}" {{ $key == 0 ? 'class=active' : '' }}></li>
                                @endforeach
                            </ol>

                            <!-- Wrapper for slides -->
                            <div class="carousel-inner" role="listbox">
                                @foreach($sliders as $key => $slider)
                                    <div class="{{ $slider->id }} item{{ $key == 0 ? ' active' : '' }}">
                                        <a {{ $slider->url != "" ? "href=".$slider->url : "" }} target="_blank">
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
                    @else
                        <p style="text-align: center">No record found.</p>
                    @endif
                </div>
                <div class="footer">
                    <hr />
                    <a href="{{ action('Admin\SliderController@index') }}">
                        <div class="stats">
                            <i class="glyphicon glyphicon-folder-open"></i> View
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card">
            <div class="content">
                <a href="{{ action('Admin\ProductController@index') }}">
                    <div class="header">
                        <h4>Products</h4>
                        <hr />
                    </div>
                </a>
                <div class="row">
                    <table class="table table-hover">
                        <thead>
                            <th data-field="number" data-sortable="true">#</th>
                            <th data-field="image">Image</th>
                            <th data-field="product" data-sortable="true">Product</th>
                            <th data-field="category" data-sortable="true">Category</th>
                        </thead>
                        <tbody>
                        @forelse($products as $key => $product)
                            <tr data-href="{{ action('Admin\ProductController@show', ['product' => $product->id]) }}">
                                <td>{{ $key+1 }}</td>
                                <td>
                                    <div class="div-img" style="background-image: url('/{{ Config::get('path.uploads') }}/products/{{ $product->id }}/{{ $product->images()->orderBy('order', 'asc')->first()->image }}')">
                                        <img src="/{{ Config::get('path.placeholder-1x1') }}" alt="">
                                    </div>
                                </td>
                                <td>
                                    <h5><b><a href="{{ action('Admin\ProductController@show', ['product' => $product->id]) }}">{{ $product->name }}</a></b></h5>
                                    @if($product->status == 'draft')
                                        <p class="text-primary">Draft</p>
                                    @else
                                        <p class="text-success">Published</p>
                                    @endif
                                </td>
                                <td>
                                    <h5><b>{{ $product->category->name }}</b></h5>
                                    <p>{{ ucwords($product->type) }}</p>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center">
                                    No record found
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="footer">
                    <hr />
                    <a href="{{ action('Admin\ProductController@index') }}">
                        <div class="stats">
                            <span class="count">{{ $count['products'] }}</span>
                            <i class="glyphicon glyphicon-folder-open"></i> View
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card">
            <div class="content">
                <a href="{{ action('Admin\CustomProductController@index') }}">
                    <div class="header">
                        {{--*/ $newCustomProduct = \App\Models\CustomProduct::whereNew(true)->count() /*--}}
                        @if($newCustomProduct > 0)
                            <span class="badge pull-right">{{ $newCustomProduct }}</span>
                        @endif
                        <h4>Custom Furniture</h4>
                        <hr />
                    </div>
                </a>
                <div class="row">
                    <table class="table table-hover">
                        <thead>
                            <th data-field="number" data-sortable="true">#</th>
                            <th data-field="image">Image</th>
                            <th data-field="product" data-sortable="true">Sender</th>
                            <th data-field="category" data-sortable="true">Detail</th>
                        </thead>
                        <tbody>
                        @forelse($customProducts as $key => $customProduct)
                            <tr data-new="{{ $customProduct->new }}" data-href="{{ action('Admin\CustomProductController@show', ['customProduct' => $customProduct->id]) }}">
                                <td>{{ $key+1 }}</td>
                                <td>
                                    <div class="div-img" style="background-image: url('/{{ Config::get('path.uploads') }}/custom_products/{{ $customProduct->id }}/{{ $customProduct->images()->first()->image }}')">
                                        <img src="/{{ Config::get('path.placeholder-1x1') }}" alt="">
                                    </div>
                                </td>
                                <td>
                                    <h5><b>{{ $customProduct->name }}</b></h5>
                                    <p>{{ $customProduct->email }}</p>
                                </td>
                                <td>
                                    <h5>{{ str_limit($customProduct->specification, 10) }}</h5>
                                    <p>{{ str_limit($customProduct->detail, 10) }}</p>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center">
                                    No record found
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="footer">
                    <hr />
                    <a href="{{ action('Admin\CustomProductController@index') }}">
                        <div class="stats">
                            <span class="count">{{ $count['customProducts'] }}</span>
                            <i class="glyphicon glyphicon-folder-open"></i> View
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content_js')
    <script>
        $(function(){
            $(function() {
                $('tr[data-href]').on('click', function (e) {

                    if (!$(e.target).hasClass('btn') && !$(e.target).hasClass('glyphicon') && !$(e.target).hasClass('action')) {
                        window.location = $(this).attr('data-href');
                    }
                });
            });
        })
    </script>

    @if(session('status') != null)
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
@endsection