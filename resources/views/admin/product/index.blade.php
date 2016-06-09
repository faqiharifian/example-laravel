@extends('admin.layout')

@section('title', 'Products')

@section('content_css')
    <link href="/{{ Config::get('path.css') }}/fresh-bootstrap-table.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="row">
        <div class="fresh-table" style="padding:25px">

            <div class="toolbar" style="padding-bottom: 25px;">
                <div class="pull-right search">
                    <input class="form-control" type="text" placeholder="Search" name="q" value="{{ Request::get('q') }}">
                </div>
                <a class="btn btn-primary btn-fill" href="{{ action('Admin\ProductController@create') }}">
                    <span class="glyphicon glyphicon-plus"></span>
                    <span class="hidden-xs"> New Product</span>
                </a>
            </div>

            <div class="filter">
                <form action="{{ action('Admin\ProductController@index') }}" method="get">
                    <input type="hidden" name="q" value="{{ Request::get('q') }}">
                    <input type="hidden" name="type" value="{{ Request::get('type') }}">
                    <input type="hidden" name="category" value="{{ Request::get('category') }}">
                    <input type="hidden" name="materials" value="{{ Request::get('materials') }}">
                    <div class="filter-dropdown">
                        <label>Filter: </label>
                        <span class="btn-group dropdown type">
                            <button type="button" class="btn btn-default  dropdown-toggle" data-toggle="dropdown">
                                <span class="page-size">Type{{ Request::get('type') != '' ? ": ".ucwords(Request::get('type')) : "" }}</span>
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li {{ Request::get('type') == 'indoor' ? "class=active" : "" }}>
                                    <a href="javascript:void(0)">Indoor</a>
                                </li>
                                <li {{ Request::get('type') == 'outdoor' ? "class=active" : "" }}>
                                    <a href="javascript:void(0)">Outdoor</a>
                                </li>
                            </ul>
                        </span>
                        <span class="btn-group dropdown category">
                            <button type="button" class="btn btn-default  dropdown-toggle" data-toggle="dropdown">
                                <span class="page-size">Category{{ Request::get('category') != '' ? ": ".ucwords(Request::get('category')) : "" }}</span>
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                @foreach($categories as $category)
                                    <li {{ Request::get('category') == $category->slug ? "class=active" : "" }}>
                                        <a href="javascript:void(0)">{{ $category->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </span>
                        <span class="btn-group dropdown materials">
                            <button type="button" class="btn btn-default" role="button" data-toggle="collapse" href="#materials-collapse" aria-expanded="false" aria-controls="materials-collapse">
                                <span class="page-size">Materials</span>
                                <span class="caret"></span>
                            </button>

                        </span>
                        @if(Request::get('type') != "" || Request::get('category') != "" || Request::get('materials'))
                            <button type="button" class="btn btn-danger clear-filter">Clear Filter</button>
                        @endif
                    </div>
                </form>
            </div>

            {{--*/ $reqMaterials = explode(",", Request::get('materials')) /*--}}
            <div id="materials-collapse" class="collapse" style="margin-top: 10px">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Materials
                    </div>
                    <div class="panel-body">
                        <div data-toggle="buttons">
                            @foreach($materials as $material)
                                <label class="col-sm-3 col-xs-4 btn btn-default {{ in_array($material->name, $reqMaterials) ? "active" : "" }}" style="margin-bottom: 5px; margin-top: 5px">
                                    <input type="checkbox" name="materials" value="{{ $material->name }}" {{ in_array($material->name, $reqMaterials) ? "checked" : "" }}>{{ ucwords($material->name) }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button type="button" class="apply-button btn btn-primary">Apply</button>
                    </div>
                </div>
            </div>

            <table id="fresh-table" class="table table-hover">
                <thead>
                    <th data-field="number" data-sortable="true">#</th>
                    <th data-field="image">Image</th>
                    <th data-field="product" data-sortable="true">Product</th>
                    <th data-field="category" data-sortable="true">Category</th>
                    <th data-field="actions">Actions</th>
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
                            <p>{{ $product->subtitle }}</p>
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
                        <td>
                            <a href="{{ action('Admin\ProductController@edit', ['product' => $product->id]) }}" class="btn btn-primary btn-fill"><span class="glyphicon glyphicon-edit"></span><span class="hidden-xs action"> Edit</span></a>

                            <a href="{{ action('Admin\ProductController@destroy', ['product' => $product->id]) }}" class="btn btn-danger btn-fill delete"><span class="glyphicon glyphicon-floppy-remove"></span><span class="hidden-xs action">  Delete</span></a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center">
                            No record found
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <div class="fixed-table-pagination">
                <div class="pull-left pagination-detail">
                    <span class="pagination-info"></span>
                    <span class="page-list">
                        <span class="btn-group dropup">
                            <button type="button" class="btn btn-default  dropdown-toggle" data-toggle="dropdown">
                                <span class="page-size">{{ session('pageSize') }}</span>
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li {{ session('pageSize') == 10 ? "class=active" : "" }}>
                                    <a href="javascript:void(0)">10</a>
                                </li>
                                <li {{ session('pageSize') == 25 ? "class=active" : "" }}>
                                    <a href="javascript:void(0)">25</a>
                                </li>
                                <li {{ session('pageSize') == 50 ? "class=active" : "" }}>
                                    <a href="javascript:void(0)">50</a>
                                </li>
                                <li {{ session('pageSize') == 100 ? "class=active" : "" }}>
                                    <a href="javascript:void(0)">100</a>
                                </li>
                            </ul>
                        </span> rows visible
                    </span>
                </div>
                @if($products->lastPage() > 1)
                <div class="pull-right pagination">
                    <ul class="pagination">
                        <li class="page-first{{ $products->currentPage() == 1 ? " disabled" : "" }}">
                            <a href="{{ $products->url(1) }}">«</a>
                        </li>
                        <li class="page-pre{{ $products->currentPage() == 1 ? " disabled" : "" }}">
                            <a href="{{ $products->previousPageUrl() }}">‹</a>
                        </li>
                        @if($products->currentPage() == $products->lastPage() && $products->lastPage() > 4)
                            <li class="page-number">
                                <a href="{{ $products->url($products->currentPage()-4) }}">{{ $products->currentPage()-4 }}</a>
                            </li>
                        @endif
                        @if($products->currentPage() >= $products->lastPage()-1 && $products->lastPage() > 3)
                            <li class="page-number">
                                <a href="{{ $products->url($products->currentPage()-3) }}">{{ $products->currentPage()-3 }}</a>
                            </li>
                        @endif

                        @if($products->currentPage() > 1)
                            @if($products->currentPage() > 2)
                                <li class="page-number">
                                    <a href="{{ $products->url($products->currentPage()-2) }}">{{ $products->currentPage()-2 }}</a>
                                </li>
                            @endif
                            <li class="page-number">
                                <a href="{{ $products->url($products->currentPage()-1) }}">{{ $products->currentPage()-1 }}</a>
                            </li>
                        @endif

                        <li class="page-number active">
                            <a>{{ $products->currentPage() }}</a>
                        </li>

                        @if($products->currentPage() <= $products->lastPage() - 1)
                            <li class="page-number">
                                <a href="{{ $products->url($products->currentPage()+1) }}">{{ $products->currentPage()+1 }}</a>
                            </li>
                            @if($products->currentPage() <= $products->lastPage() - 2)
                                <li class="page-number">
                                    <a href="{{ $products->url($products->currentPage()+2) }}">{{ $products->currentPage()+2 }}</a>
                                </li>
                            @endif
                        @endif

                        @if($products->currentPage() <= 2 && $products->lastPage() > 3)
                            <li class="page-number">
                                <a href="{{ $products->url($products->currentPage()+3) }}">{{ $products->currentPage()+3 }}</a>
                            </li>
                        @endif
                        @if($products->currentPage() == 1 && $products->lastPage() > 4)
                            <li class="page-number">
                                <a href="{{ $products->url($products->currentPage()+4) }}">{{ $products->currentPage()+4 }}</a>
                            </li>
                        @endif

                        <li class="page-next{{ $products->currentPage() == $products->lastPage() ? " disabled" : "" }}">
                            <a href="{{ $products->nextPageUrl() }}">›</a>
                        </li>
                        <li class="page-last{{ $products->currentPage() == $products->lastPage() ? " disabled" : "" }}">
                            <a href="{{ $products->url($products->lastPage()) }}">»</a>
                        </li>
                    </ul>
                </div>
                @endif
            </div>
        </div>

    </div>
@endsection

@section('content_js')
    <script type="text/javascript">
        $(function(){
            $('tr[data-href]').on('click', function(e){

                if(!$(e.target).hasClass('btn') && !$(e.target).hasClass('glyphicon') && !$(e.target).hasClass('action')){
                    window.location = $(this).attr('data-href');
                }
            });
            $('.delete').on('click', function(e){
                if(confirm("Are you sure want to delete this?") == false){
                    return false;
                }
            });

            $('.page-list li a').on('click', function(){
                window.location = '{{ action('Admin\ProductController@setPageSize') }}?pageSize='+$(this).html()+'&redirect='+window.location.href;
            });

            $('.dropdown.type li a').on('click', function(){
                var form = $('.filter form');
                $(form).find('input[name=type]').val($(this).html().toLowerCase());
                if($(form).find('input[name=q]').val() == "") $(form).find('input[name=q]').remove();
                if($(form).find('input[name=category]').val() == "") $(form).find('input[name=category]').remove();
                if($(form).find('input[name=materials]').val() == "") $(form).find('input[name=materials]').remove();
                $(form).submit();
            });
            $('.dropdown.category li a').on('click', function(){
                var form = $('.filter form');
                $(form).find('input[name=category]').val($(this).html().toLowerCase());
                if($(form).find('input[name=q]').val() == "") $(form).find('input[name=q]').remove();
                if($(form).find('input[name=type]').val() == "") $(form).find('input[name=type]').remove();
                if($(form).find('input[name=materials]').val() == "") $(form).find('input[name=materials]').remove();
                $(form).submit();
            });
            $('#materials-collapse .apply-button').on('click', function(){
                var form = $('.filter form');
                var temp = [];
                $('#materials-collapse input[name=materials]:checked').each(function (key, data) {
                    temp[key] = $(data).val();
                });

                $(form).find('input[name=materials]').val(temp.join());
                if($(form).find('input[name=q]').val() == "") $(form).find('input[name=q]').remove();
                if($(form).find('input[name=category]').val() == "") $(form).find('input[name=category]').remove();
                if($(form).find('input[name=type]').val() == "") $(form).find('input[name=type]').remove();
                $(form).submit();
            });
            $('.toolbar input[name=q]').on('keypress', function(e){
                var keycode = (e.keyCode ? e.keyCode : e.which);
                if(keycode == '13'){
                    var form = $('.filter form');
                    $(form).find('input[name=q]').val($(this).val());
                    if($(form).find('input[name=category]').val() == "") $(form).find('input[name=category]').remove();
                    if($(form).find('input[name=type]').val() == "") $(form).find('input[name=type]').remove();
                    if($(form).find('input[name=materials]').val() == "") $(form).find('input[name=materials]').remove();
                    $(form).submit();
                }
            });
            $('.clear-filter').on('click', function(){
                var form = $('.filter form');
                $(form).find('input[name=category]').remove();
                $(form).find('input[name=type]').remove();
                $(form).find('input[name=materials]').remove();
                $(form).submit();
            });
        });

    </script>

    @if(session('success') != null)
        <script src="/{{ Config::get('path.js') }}/bootstrap-notify.js"></script>

        <script>
            $.notify({
                icon: 'glyphicon glyphicon-ok',
                message: '\n{{ session('success') }}\n'

            },{
                type: 'success',
                timer: 4000
            });
        </script>
    @endif
@endsection