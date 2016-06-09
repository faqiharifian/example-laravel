@extends('layout')

@section('title', 'Search - Amartha Furniture')

@section('content')
    <div class="search">
        <div class="container">
            <div class="title">
                <p class="hidden-490">Lorem ipsum dolor sit amet</p>
                <form>
                    <input id="search" type="search" name="q" value="{{ Request::get('q') }}"/>
                    <button id="submit" type="submit">
                        <div id="ic_search" class="vertical-center sprite-icon"></div>
                    </button>
                </form>
            </div>

            <div class="filtering">
                <div class="col-sm-3 col-xs-4"><b>Filtering</b></div>
                <span class="vertical-center"><b>Showing {{ ($products->currentPage()-1)*8 + 1 }}-{{ ($products->currentPage()-1)*8 + $products->count() }} of {{ $products->total() }} Results</b></span>
            </div>
            <div class="content">
                <aside class="col-sm-3 col-xs-4">
                    <form action="{{ action('ProductController@search') }}" method="get">
                        <input type="hidden" name="q" value="{{ Request::get('q') }}">
                        <ul class="nav side-menu">
                        <li id="category">
                            <div id="type-collapse" data-toggle="collapse" data-target="#type-filter" aria-expanded="{{ Request::get('type') != "" ? 'true' : 'false' }}" aria-controls="type-filter">
                                <div class="filter-wrapper">
                                Search by Category<span class="glyphicon glyphicon-triangle-right pull-right{{ Request::get('type') != "" ? ' glyphicon-triangle-bottom' : '' }}"></span>
                                </div>
                            </div>
                            <div id="type-filter" class="collapse{{ Request::get('type') != "" ? ' in' : '' }}">
                                <div id="type-outdoor">
                                    <label class="type filter-wrapper {{ Request::get('type') == 'outdoor' ? "active" : "" }}">
                                        <input type="radio" name="type" value="outdoor" {{ Request::get('type') == 'outdoor' ? "checked" : "" }}>
                                        - OUTDOOR
                                    </label>
                                </div>
                                <div id="type-indoor">
                                    <label class="type filter-wrapper {{ Request::get('type') == 'indoor' ? "active" : "" }}">
                                        <input type="radio" name="type" value="indoor" {{ Request::get('type') == 'indoor' ? "checked" : "" }}>
                                        - INDOOR
                                    </label>
                                </div>
                            </div>

                            <div class="third-level"><div class="glyphicon glyphicon-triangle-left hidden-xs"></div>
                                <ul class="nav">
                                    <li class="col-sm-4">
                                        <label class="{{ Request::get('category') == 'tables' ? "active" : "" }}">
                                            <div class="vertical-center">
                                                <input type="radio" name="category" value="tables" {{ Request::get('category') == 'tables' ? "checked" : "" }}>
                                                <div id="ic_table_2" class="sprite-icon-2 hidden-xs"></div>
                                                <div>Tables</div>
                                            </div>
                                        </label>
                                    </li>
                                    <li class="col-sm-4">
                                        <label class="{{ Request::get('category') == 'chairs' ? "active" : "" }}">
                                            <div class="vertical-center">
                                                <input type="radio" name="category" value="chairs" {{ Request::get('category') == 'chairs' ? "checked" : "" }}>
                                                <div id="ic_chair_2" class="sprite-icon-2 hidden-xs"></div>
                                                <div>Chairs</div>
                                            </div>
                                        </label>
                                    </li>
                                    <li class="col-sm-4">
                                        <label class="{{ Request::get('category') == 'armchairs' ? "active" : "" }}">
                                            <div class="vertical-center">
                                                <input type="radio" name="category" value="armchairs" {{ Request::get('category') == 'armchairs' ? "checked" : "" }}>
                                                <div id="ic_arm_chair_2" class="sprite-icon-2 hidden-xs"></div>
                                                <div>Armchairs</div>
                                            </div>
                                        </label>
                                    </li>
                                    <li class="col-sm-4">
                                        <label class="{{ Request::get('category') == 'sofas' ? "active" : "" }}">
                                            <div class="vertical-center">
                                                <input type="radio" name="category" value="sofas" {{ Request::get('category') == 'sofas' ? "checked" : "" }}>
                                                <div id="ic_sofa_2" class="sprite-icon-2 hidden-xs"></div>
                                                <div>Sofas</div>
                                            </div>
                                        </label>
                                    </li>
                                    <li class="col-sm-4">
                                        <label class="{{ Request::get('category') == 'longers' ? "active" : "" }}">
                                            <div class="vertical-center">
                                                <input type="radio" name="category" value="longers" {{ Request::get('category') == 'longers' ? "checked" : "" }}>
                                                <div id="ic_longer_2" class="sprite-icon-2 hidden-xs"></div>
                                                <div>Longers</div>
                                            </div>
                                        </label>
                                    </li>
                                    <li class="col-sm-4">
                                        <label class="{{ Request::get('category') == 'sidetables' ? "active" : "" }}">
                                            <div class="vertical-center">
                                                <input type="radio" name="category" value="sidetables" {{ Request::get('category') == 'sidetables' ? "checked" : "" }}>
                                                <div id="ic_side_table_2" class="sprite-icon-2 hidden-xs"></div>
                                                <div>Sidetables</div>
                                            </div>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li id="materials">
                            <div id="materials-collapse" data-toggle="collapse" data-target="#materials-filter" aria-expanded="{{ Request::get('materials') != "" ? 'true' : 'false' }}" aria-controls="materials-filter">
                                <div class="filter-wrapper">
                                    Search by Material<span class="glyphicon glyphicon-triangle-right pull-right{{ Request::get('materials') != "" ? ' glyphicon-triangle-bottom' : '' }}"></span>
                                </div>
                                <input type="hidden" name="materials" value="{{ Request::get('materials') }}">
                            </div>
                            <div id="materials-filter" class="collapse{{ Request::get('materials') != "" ? ' in' : '' }}">
                                {{--*/ $reqMaterials = explode(",", Request::get('materials')) /*--}}
                                @foreach($materials as $material)
                                    <div id="materials-{{ str_slug($material->name) }}">
                                        <label class="materials filter-wrapper {{ in_array($material->name, $reqMaterials) ? "active" : "" }}">
                                            <input type="checkbox" name="material" value="{{ $material->name }}" {{ in_array($material->name, $reqMaterials) ? "checked" : "" }}>
                                            - {{ ucwords($material->name) }}
                                        </label>
                                    </div>
                                @endforeach

                            </div>
                        </li>
                        <li id="new-added">
                            <div id="new-adds-collapse" data-toggle="collapse" data-target="#new-adds-filter" aria-expanded="{{ Request::get('new-add') != "" ? 'true' : 'false' }}" aria-controls="new-adds-filter">
                                <div class="filter-wrapper">
                                    Search by New Added<span class="glyphicon glyphicon-triangle-right pull-right{{ Request::get('new-add') != "" ? ' glyphicon-triangle-bottom' : '' }}"></span>
                                </div>
                            </div>
                            <div id="new-adds-filter" class="collapse{{ Request::get('new-add') != "" ? ' in' : '' }}">
                                <div id="new-adds-1">
                                    <label class="new-adds filter-wrapper{{ Request::get('new-add') == "week" ? ' active' : '' }}">
                                        <input type="radio" name="new-add" value="week"{{ Request::get('new-add') == "week" ? ' checked' : '' }}>
                                        - This Week
                                    </label>
                                </div>
                                <div id="new-adds-2">
                                    <label class="new-adds filter-wrapper{{ Request::get('new-add') == "month" ? ' active' : '' }}">
                                        <input type="radio" name="new-add" value="month"{{ Request::get('new-add') == "month" ? ' checked' : '' }}>
                                        - This Month
                                    </label>
                                </div>
                                <div id="new-adds-2">
                                    <label class="new-adds filter-wrapper{{ Request::get('new-add') == "year" ? ' active' : '' }}">
                                        <input type="radio" name="new-add" value="year"{{ Request::get('new-add') == "year" ? ' checked' : '' }}>
                                        - This Year
                                    </label>
                                </div>
                            </div>
                        </li>
                    </ul>
                    </form>
                </aside>
                
                <div class="result col-sm-9 col-xs-12">
                    @forelse($products as $product)
                        <a href="{{ action('ProductController@show', ['product' => $product->id]) }}">
                            <figure class="col-sm-3 col-xs-6">
                                <div class="div-img vertical-center" style="background-image: url('/{{ Config::get('path.uploads') }}/products/{{ $product->id }}/{{ $product->images()->orderBy('order', 'asc')->first()->image }}')">
                                    <img class="" src="/{{ Config::get('path.placeholder-1x1') }}">
                                </div>
                                <div class="item-name">{{ $product->name }}</div>
                                <div class="item-detail"><figcaption>{{ $product->subtitle }}</figcaption>
                                <a class="btn btn-default hover" href="{{ action('ProductController@show', ['product' => $product->id]) }}">View Detail</a></div>
                            </figure>
                        </a>
                    @empty
                        <p style="text-align: center">No product found</p>
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
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
@endsection

@section('content_js')
    <script type="text/javascript">
        $(function(){
            /* second-level on click */
            /* Menampilkan atau menyembunyikan submenu */
            $('.side-menu > li').on('click', function(){
                $(this).find('span').toggleClass('glyphicon-triangle-bottom');

            });

            $('#type-collapse').on('click', function(){
                $('.third-level').hide();
                $('#type-filter label').removeClass('active');
                $('#type-filter label').removeClass('show');
                $('input[name=type]').prop('checked', false);
            });

            var screen_size = $(window).width();
            $('#type-filter input[name=type]').on('change', function(){
                $('#category label.filter-wrapper').removeClass('active').removeClass('show');
                $(this).parent().addClass('active').addClass('show');
                if (screen_size >= 768) {
                    if($(this).val() == 'indoor'){
                        $('.third-level .glyphicon-triangle-left').css('top', '84px');
                    }else{
                        $('.third-level .glyphicon-triangle-left').css('top', '34px');
                    }
                } else{
                    if($(this).val() == 'indoor'){
                        $('.third-level').css('top', '104px');
                    }else{
                        $('.third-level').css('top', '52px');
                    }
                }
                $('.third-level').show();
            });

            $('#type-outdoor label').on('click', function(e){
                if($(e.target).is("label") ) {
                    if($(this).hasClass('show')){
                        $('.third-level').hide();
                        $(this).removeClass('show');
                    }else {
                        $('.third-level').show();
                        if($('label.show').length == 0){
                            $(this).addClass('show');
                        }
                    }
                }
            });
            $('#type-indoor label').on('click', function(e){
                if($(e.target).is("label") ) {
                    if ($(this).hasClass('show')) {
                        $('.third-level').hide();
                        $(this).removeClass('show');
                    } else {
                        $('.third-level').show();
                        if ($('label.show').length == 0) {
                            $(this).addClass('show');
                        }
                    }
                }
            });

            $('.third-level label').on('click', function(){
                $('.third-level label').removeClass('active');
                $(this).addClass('active');
                submitForm();
            });

            $('label.filter-wrapper input[name=material]').on('change', function(){
                $(this).parent().toggleClass('active');
                submitForm();
            });

            $('#new-adds-filter input[name=new-add]').on('change', function(){
                $(this).parent().toggleClass('active');
                submitForm();
            });
        });

        function submitForm(){
            if($('input[name=material]').length > 0) {
                var temp = [];
                $('input[name=material]:checked').each(function (key, data) {
                    temp[key] = $(data).val();
                });

                $('input[name=materials]').val(temp.join());
                $('input[name=material]').remove();
            }

            $('aside form').submit();
        }

    </script>
@stop