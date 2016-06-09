@extends('admin.layout')

@section('title', 'Request from '.$customProduct->name)

@section('content')
    <div class="container-fluid">
        <div class="product">
            <div class="sender">
                <h4>Request Sender:</h4>
                <table border="0">
                    <tr>
                        <td style="padding-right: 20px;">Name</td>
                        <td>: {{ $customProduct->name }}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>: {{ $customProduct->email }}</td>
                    </tr>
                    <tr>
                        <td>Phone</td>
                        <td>: {{ $customProduct->phone }}</td>
                    </tr>
                </table>
            </div>
            <div class="furniture">
                <h4>Furniture Specification:</h4>
                <div class="col-sm-6">
                    <div id="slider" class="carousel slide" data-ride="carousel">
                        <!-- Indicators -->
                        <ol class="carousel-indicators">
                            @foreach($customProduct->images as $key => $image)
                                <li data-target="#slider" data-slide-to="{{ $key }}" {{ $key == 0 ? 'class=active' : '' }}>
                                    <div class="div-img" style="background-image: url('/{{ Config::get('path.uploads') }}/custom_products/{{ $customProduct->id }}/{{ $customProduct->images()->first()->image }}')">
                                        <img src="/{{ Config::get('path.placeholder-1x1') }}" alt="">
                                    </div>
                                </li>
                            @endforeach
                        </ol>

                        <!-- Wrapper for slides -->
                        <div class="carousel-inner" role="listbox">
                            @foreach($customProduct->images as $key => $image)
                                <div class="item{{ $key == 0 ? ' active' : '' }}">
                                    <div class="div-img" style="background-image: url('/{{ Config::get('path.uploads') }}/custom_products/{{ $customProduct->id }}/{{ $customProduct->images()->first()->image }}')">
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
                    <h5>Dimensions: </h5>
                    <p>{{ $customProduct->specification }}</p>
                    <h5>Details: </h5>
                    <p>{{ $customProduct->detail }}</p>
                </div>
                <div style="margin-top: 25px;">
                    <a href="{{ action('Admin\CustomProductController@destroy', ['customProduct' => $customProduct->id]) }}" class="btn btn-danger btn-fill delete pull-right"><span class="glyphicon glyphicon-floppy-remove"></span><span class="hidden-xs action">  Delete</span></a>
                </div>
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