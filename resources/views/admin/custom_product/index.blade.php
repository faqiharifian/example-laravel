@extends('admin.layout')

@section('title', 'Custom Furniture Request')

@section('content_css')
    <link href="/{{ Config::get('path.css') }}/fresh-bootstrap-table.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="row">
        <div class="fresh-table" style="padding:25px">

            <div class="toolbar" style="padding-bottom: 25px;">
                <div class="pull-right search">
                    <form action="{{ action('Admin\CustomProductController@index') }}" method="get">
                        <input class="form-control" type="text" placeholder="Search" name="q" value="{{ Request::get('q') }}">
                    </form>
                </div>
            </div>

            <table id="fresh-table" class="table table-hover">
                <thead>
                <th data-field="number" data-sortable="true">#</th>
                <th data-field="image">Image</th>
                <th data-field="product" data-sortable="true">Sender</th>
                <th data-field="category" data-sortable="true">Detail</th>
                <th data-field="actions">Actions</th>
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
                            <h5>{{ str_limit($customProduct->specification, 20) }}</h5>
                            <p>{{ str_limit($customProduct->detail, 20) }}</p>
                        </td>
                        <td>
                            <a href="{{ action('Admin\CustomProductController@destroy', ['customProduct' => $customProduct->id]) }}" class="btn btn-danger btn-fill delete"><span class="glyphicon glyphicon-floppy-remove"></span><span class="hidden-xs action">  Delete</span></a>
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
                @if($customProducts->lastPage() > 1)
                    <div class="pull-right pagination">
                        <ul class="pagination">
                            <li class="page-first{{ $customProducts->currentPage() == 1 ? " disabled" : "" }}">
                                <a href="{{ $customProducts->url(1) }}">«</a>
                            </li>
                            <li class="page-pre{{ $customProducts->currentPage() == 1 ? " disabled" : "" }}">
                                <a href="{{ $customProducts->previousPageUrl() }}">‹</a>
                            </li>
                            @if($customProducts->currentPage() == $customProducts->lastPage() && $customProducts->lastPage() > 4)
                                <li class="page-number">
                                    <a href="{{ $customProducts->url($customProducts->currentPage()-4) }}">{{ $customProducts->currentPage()-4 }}</a>
                                </li>
                            @endif
                            @if($customProducts->currentPage() >= $customProducts->lastPage()-1 && $customProducts->lastPage() > 3)
                                <li class="page-number">
                                    <a href="{{ $customProducts->url($customProducts->currentPage()-3) }}">{{ $customProducts->currentPage()-3 }}</a>
                                </li>
                            @endif

                            @if($customProducts->currentPage() > 1)
                                @if($customProducts->currentPage() > 2)
                                    <li class="page-number">
                                        <a href="{{ $customProducts->url($customProducts->currentPage()-2) }}">{{ $customProducts->currentPage()-2 }}</a>
                                    </li>
                                @endif
                                <li class="page-number">
                                    <a href="{{ $customProducts->url($customProducts->currentPage()-1) }}">{{ $customProducts->currentPage()-1 }}</a>
                                </li>
                            @endif

                            <li class="page-number active">
                                <a>{{ $customProducts->currentPage() }}</a>
                            </li>

                            @if($customProducts->currentPage() <= $customProducts->lastPage() - 1)
                                <li class="page-number">
                                    <a href="{{ $customProducts->url($customProducts->currentPage()+1) }}">{{ $customProducts->currentPage()+1 }}</a>
                                </li>
                                @if($customProducts->currentPage() <= $customProducts->lastPage() - 2)
                                    <li class="page-number">
                                        <a href="{{ $customProducts->url($customProducts->currentPage()+2) }}">{{ $customProducts->currentPage()+2 }}</a>
                                    </li>
                                @endif
                            @endif

                            @if($customProducts->currentPage() <= 2 && $customProducts->lastPage() > 3)
                                <li class="page-number">
                                    <a href="{{ $customProducts->url($customProducts->currentPage()+3) }}">{{ $customProducts->currentPage()+3 }}</a>
                                </li>
                            @endif
                            @if($customProducts->currentPage() == 1 && $customProducts->lastPage() > 4)
                                <li class="page-number">
                                    <a href="{{ $customProducts->url($customProducts->currentPage()+4) }}">{{ $customProducts->currentPage()+4 }}</a>
                                </li>
                            @endif

                            <li class="page-next{{ $customProducts->currentPage() == $customProducts->lastPage() ? " disabled" : "" }}">
                                <a href="{{ $customProducts->nextPageUrl() }}">›</a>
                            </li>
                            <li class="page-last{{ $customProducts->currentPage() == $customProducts->lastPage() ? " disabled" : "" }}">
                                <a href="{{ $customProducts->url($customProducts->lastPage()) }}">»</a>
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