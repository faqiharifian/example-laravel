@extends('admin.layout')

@section('title', 'Edit '.$product->name)

@section('content_css')
    <link href="/{{ Config::get('path.css') }}/bootstrap-tagsinput.css" rel="stylesheet"/>
@endsection
@section('content')
    <div class="container-fluid">
        <form action="{{ action('Admin\ProductController@update', ['product' => $product->id]) }}" method="post" enctype="multipart/form-data">
            <div class="product">
                <div class="col-md-6">
                    <div id="slider" class="carousel slide" data-ride="carousel">
                        <div id="image-preview-text" style="position: absolute;height: 100%;width: 100%;">
                            <h4 class="slider" style="position:absolute;top: 50%;left:50%;transform: translate(-50%, -50%);margin:0;display:none">Images' Preview</h4>
                        </div>
                        <!-- Indicators -->
                        <ol class="carousel-indicators">
                            @foreach($product->images()->orderBy('order', 'asc')->get() as $key => $image)
                                <li data-target="#slider" data-slide-to="{{ $key }}" {{ $key == 0 ? 'class=active' : '' }}>
                                    <div class="div-img" style="background-image: url('/{{ Config::get('path.uploads') }}/products/{{ $product->id }}/{{ $image->image }}')">
                                        <img class="vertical-center" src="/{{ Config::get('path.placeholder-1x1') }}">
                                    </div>
                                </li>
                            @endforeach
                        </ol>

                        <!-- Wrapper for slides -->
                        <div class="carousel-inner" role="listbox">
                            @foreach($product->images()->orderBy('order', 'asc')->get() as $key => $image)
                                <div class="item{{ $key == 0 ? ' active' : '' }}">
                                    <div class="div-img" style="background-image: url('/{{ Config::get('path.uploads') }}/products/{{ $product->id }}/{{ $image->image }}')">
                                        <img class="vertical-center" src="/{{ Config::get('path.placeholder-1x1') }}">
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
                    <div class="form-group{{ $errors->first('images') != "" ? "has-error" : "" }}">
                        <div class="btn btn-primary btn-file">
                            <span class="glyphicon glyphicon-picture"></span> Select Images<input id="upload" type="file" accept="image/*" name="images[]" multiple/>
                        </div>
                        <span id="nb" class="text-muted" style="color:black"><em>Select 1:1 images for best result</em></span>
                        {!! $errors->first('images', '<p class="text-danger">:message</p>') !!}
                    </div>
                </div>

                <div class="col-md-6 description">
                    @if($product->status == 'draft')
                        <p class="text-primary">Draft</p>
                    @else
                        <p class="text-success">Published</p>
                    @endif
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#input" aria-controls="input" role="tab" data-toggle="tab">Input</a></li>
                        <li role="presentation"><a href="#preview" aria-controls="preview" role="tab" data-toggle="tab">Preview</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="input">
                            <div class="title">
                                <div class="form-group{{ $errors->first('subtitle') != "" ? " has-error" : "" }}">
                                    <span id="subtitle-left" class="pull-right">{{ 30 - (strlen(old('subtitle') ? : $product->subtitle)) }}</span>
                                    <label for="subtitle-input">Tagline:</label>
                                    <input type="text" class="form-control input-sm" name="subtitle" placeholder="Subtitle Here" value="{{ old('subtitle') ? : $product->subtitle }}">
                                    {!! $errors->first('subtitle', '<p class="text-danger">:message</p>') !!}
                                </div>
                                <div class="form-group{{ $errors->first('name') != "" ? " has-error" : "" }}">
                                    <span id="name-left" class="pull-right">{{ 20 - (strlen(old('name') ? : $product->name)) }}</span>
                                    <label for="name-input">Product's Name:</label>
                                    <input type="text" class="form-control input-lg" name="name" placeholder="Product's Name Here" value="{{ old('name') ? : $product->name }}">
                                    {!! $errors->first('name', '<p class="text-danger">:message</p>') !!}
                                </div>

                            </div>
                            <div class="form-group{{ $errors->first('detail') != "" ? " has-error" : "" }}">
                                <label for="detail-input">Product's Detail: <small>You can use <a href="http://daringfireball.net/projects/markdown/syntax">Markdown syntax</a></small></label>
                                <textarea class="form-control" name="detail" rows="10" placeholder="About the product...">{{ old('detail') ? : $product->detail }}</textarea>
                                {!! $errors->first('detail', '<p class="text-danger">:message</p>') !!}
                            </div>
                            <br>
                            <div class="form-group{{ $errors->first('material') != "" ? " has-error" : "" }}">
                                <label>MATERIAL TAGS: <small>Use comma (,) if more than 1</small></label>
                                <input class="form-control" name="materials" value="{{ old('materials') ? : $materials }}"/>
                                {!! $errors->first('material', '<p class="text-danger">:message</p>') !!}
                            </div>
                            <br>
                            <div class="specification">
                                <label>Product's Dimensions:</label>
                                <ul class="nav">
                                    <li class="col-xs-3">
                                        <div class="vertical-center">
                                            <span>WIDTH</span>
                                            <div class="form-group{{ $errors->first('width') != "" ? " has-error" : "" }}">
                                                <input class="form-control" type="text" name="width" placeholder="0.0" value="{{ old('width') ? : $product->width }}">
                                            </div>
                                            <span>cm</span>
                                        </div>
                                    </li>
                                    <li class="col-xs-3 move">
                                        <div class="vertical-center">
                                            <span>HEIGHT</span>
                                            <div class="form-group{{ $errors->first('height') != "" ? " has-error" : "" }}">
                                                <input class="form-control" type="text" name="height" placeholder="0.0" value="{{ old('height') ? : $product->height }}">
                                            </div>
                                            <span>cm</span>
                                        </div>
                                    </li>
                                    <li class="col-xs-3 move">
                                        <div class="vertical-center">
                                            <span>DEPTH</span>
                                            <div class="form-group{{ $errors->first('depth') != "" ? " has-error" : "" }}">
                                                <input class="form-control" type="text" name="depth" placeholder="0.0" value="{{ old('depth') ? : $product->depth }}">
                                            </div>
                                            <span>cm</span>
                                        </div>
                                    </li>
                                    <li class="col-xs-3 move">
                                        <div class="vertical-center">
                                            <span>WEIGHT</span>
                                            <div class="form-group{{ $errors->first('weight') != "" ? " has-error" : "" }}">
                                                <input class="form-control" type="text" name="weight" placeholder="0.0" value="{{ old('weight') ? : $product->weight }}">
                                            </div>
                                            <span>kg</span>
                                        </div>
                                    </li>
                                </ul>
                                {!! $errors->first('width', '<p class="text-danger">:message</p>') !!}
                                {!! $errors->first('height', '<p class="text-danger">:message</p>') !!}
                                {!! $errors->first('depth', '<p class="text-danger">:message</p>') !!}
                                {!! $errors->first('weight', '<p class="text-danger">:message</p>') !!}
                            </div>
                            <br>
                            <div class="category form-group">
                                <label>CATEGORY:</label>
                                <div class="form-group{{ $errors->first('type') != "" ? " has-error" : "" }}" style="border-bottom:1px solid white;display: table;width: 100%;">
                                    <div class="col-xs-6">
                                        <label class="radio">
                                            <input class="radio" type="radio" name="type" value="indoor" {{ old('type') == "indoor" ? "checked" : ($product->type == "indoor" ? "checked" : "") }}>
                                            <span class="first-icon icon-radio-unchecked"></span>
                                            <span class="second-icon icon-radio-checked"></span>
                                            INDOOR
                                        </label>
                                    </div>
                                    <div class="col-xs-6">
                                        <label class="radio">
                                            <input class="radio" type="radio" name="type" value="outdoor" {{ old('type') == "outdoor" ? "checked" : ($product->type == "outdoor" ? "checked" : "") }}>
                                            <span class="first-icon icon-radio-unchecked"></span>
                                            <span class="second-icon icon-radio-checked"></span>
                                            OUTDOOR
                                        </label>
                                    </div>
                                    {!! $errors->first('type', '<p class="text-danger">:message</p>') !!}
                                </div>
                                <div class="form-group{{ $errors->first('type') != "" ? " has-error" : "" }}">
                                    <div class="col-sm-4 col-xs-6">
                                        <label class="radio">
                                            <input class="radio" type="radio" name="category" value="tables" {{ old('category') == 'tables' ? 'checked' : ($product->category->slug == "tables" ? "checked" : "") }}>
                                            <span class="first-icon icon-radio-unchecked"></span>
                                            <span class="second-icon icon-radio-checked"></span>
                                            Tables
                                        </label>
                                    </div>
                                    <div class="col-sm-4 col-xs-6">
                                        <label class="radio">
                                            <input class="radio" type="radio" name="category" value="chairs" {{ old('category') == 'chairs' ? 'checked' : ($product->category->slug == "chairs" ? "checked" : "") }}>
                                            <span class="first-icon icon-radio-unchecked"></span>
                                            <span class="second-icon icon-radio-checked"></span>
                                            Chairs
                                        </label>
                                    </div>
                                    <div class="col-sm-4 col-xs-6">
                                        <label class="radio">
                                            <input class="radio" type="radio" name="category" value="armchairs" {{ old('category') == 'armchairs' ? 'checked' : ($product->category->slug == "armchairs" ? "checked" : "") }}>
                                            <span class="first-icon icon-radio-unchecked"></span>
                                            <span class="second-icon icon-radio-checked"></span>
                                            Armchairs
                                        </label>
                                    </div>
                                    <div class="col-sm-4 col-xs-6">
                                        <label class="radio">
                                            <input class="radio" type="radio" name="category" value="sofas" {{ old('category') == 'sofas' ? 'checked' : ($product->category->slug == "sofas" ? "checked" : "") }}>
                                            <span class="first-icon icon-radio-unchecked"></span>
                                            <span class="second-icon icon-radio-checked"></span>
                                            Sofas
                                        </label>
                                    </div>
                                    <div class="col-sm-4 col-xs-6">
                                        <label class="radio">
                                            <input class="radio" type="radio" name="category" value="longers" {{ old('category') == 'longers' ? 'checked' : ($product->category->slug == "longers" ? "checked" : "") }}>
                                            <span class="first-icon icon-radio-unchecked"></span>
                                            <span class="second-icon icon-radio-checked"></span>
                                            Longers
                                        </label>
                                    </div>
                                    <div class="col-sm-4 col-xs-6">
                                        <label class="radio">
                                            <input class="radio" type="radio" name="category" value="sidetables" {{ old('category') == 'sidetables' ? 'checked' : ($product->category->slug == "sidetables" ? "checked" : "") }}>
                                            <span class="first-icon icon-radio-unchecked"></span>
                                            <span class="second-icon icon-radio-checked"></span>
                                            Sidetables
                                        </label>
                                    </div>
                                    {!! $errors->first('category', '<p class="text-danger">:message</p>') !!}
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="preview">
                            <div class="title">
                                <p id="preview-subtitle"></p>
                                <h3 id="preview-name"></h3>
                            </div>
                            <p id="preview-detail"></p>
                            <br>
                            <div class="specification">
                                <ul class="nav">
                                    <li class="col-xs-3">
                                        <div class="vertical-center">
                                            <span>WIDTH</span>
                                            <h4 id="preview-width"></h4>
                                            <span>cm</span>
                                        </div>
                                    </li>
                                    <li class="col-xs-3 move">
                                        <div class="vertical-center">
                                            <span>HEIGHT</span>
                                            <h4 id="preview-height"></h4>
                                            <span>cm</span>
                                        </div>
                                    </li>
                                    <li class="col-xs-3 move">
                                        <div class="vertical-center">
                                            <span>DEPTH</span>
                                            <h4 id="preview-depth"></h4>
                                            <span>cm</span>
                                        </div>
                                    </li>
                                    <li class="col-xs-3 move">
                                        <div class="vertical-center">
                                            <span>WEIGHT</span>
                                            <h4 id="preview-weight"></h4>
                                            <span>kg</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    {!! csrf_field() !!}
                    <button type="submit" class="btn btn-success pull-right" name="status" value="published" style="margin-top: 15px">
                        <span class="glyphicon glyphicon-share"></span>
                        <span class="hidden-xs"> PUBLISH</span>
                    </button>
                    <button type="submit" class="btn btn-primary pull-right" name="status" value="draft" style="margin-top: 15px">
                        <span class="glyphicon glyphicon-floppy-disk"></span>
                        <span class="hidden-xs"> Save as DRAFT</span>
                    </button>

                </div>
            </div>
        </form>
    </div>
@endsection

@section('content_js')
    <script type="text/javascript" src="/{{ Config::get('path.js') }}/commonmark.js"></script>
    <script type="text/javascript" src="/{{ Config::get('path.js') }}/bootstrap3-typeahead.min.js"></script>
    <script type="text/javascript" src="/{{ Config::get('path.js') }}/bootstrap-tagsinput.js"></script>
    <script>
        $(function(){
            var oldIndicators = $('.carousel-indicators').html();
            var oldInners = $('.carousel-inner').html();

            $('#slider').height($('#slider').width()).carousel('pause');

            $('#upload').on('change', function() {
                var files = $(this)[0].files;
                var indicators = "";
                var inners = "";

                console.log('change clled');
                if($(this).val() != "") {
                    $.each(files, function (key, file) {
                        var type = file.type.toString();
                        var img = new Image;
                        var isRect = true;
                        img.src = URL.createObjectURL(file);
                        img.onload = function () {
                            if (type.indexOf("image/") != -1 && isRect) {
                                indicators += '<li data-target="#slider" data-slide-to="' + key + '" class="' + (key == 0 ? 'active' : '') + '">\
                                    <div class="div-img" style="background-image: url(\'' + URL.createObjectURL(file) + '\')">\
                                    <img class="vertical-center" src="/{{ Config::get('path.placeholder-1x1') }}" alt="">\
                                    </div>\
                    </li>';
                                inners += '<div class="item ' + (key == 0 ? 'active' : '') + '">\
                                    <div class="div-img" style="background-image: url(\'' + URL.createObjectURL(file) + '\')">\
                                    <img src="/{{ Config::get('path.placeholder-1x1') }}" alt="">\
                                    </div>\
                    </div>';
                                $('.carousel-indicators').html(indicators);
                                $('.carousel-inner').html(inners);
                                $('#image-preview-text').hide();
                            } else if (type.indexOf("image/") == -1) {
                                alert('Please select image file!');
                                $('#upload').val('');
                                $('.carousel-indicators').html(oldIndicators);
                                $('.carousel-inner').html(oldInners);
                            }
                        };
                    });
                }else{
                    $('.carousel-indicators').html(oldIndicators);
                    $('.carousel-inner').html(oldInners);
                }
            });

            $('input[name=name]').on('paste keyup change', function(){
                var length = 20 - $(this).val().length;
                $('#name-left').text(length);

            }).focusout(function(){
                if((20 - $(this).val().length) <= 0) {
                    alert('Max character 20, please check again!');
                }
            });
            $('input[name=subtitle]').on('paste keyup change', function(){
                var length = 30 - $(this).val().length;
                $('#subtitle-left').text(length);
            }).focusout(function(){
                if((30 - $(this).val().length) <= 0) {
                    alert('Max character 30, please check again!');
                }
            });

            $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
                $('input').each(function(key, data){
                    if(key > 0){
                        $('#preview-'+$(data).attr('name')).html($(data).val());
                    }
                });

                var text = $('textarea[name=detail]').val();
                var reader = new commonmark.Parser();
                var writer = new commonmark.HtmlRenderer();
                var parsed = reader.parse(text);
                var result = writer.render(parsed);
                $('#preview-detail').html(result);
            });

            $('input[name=materials]').tagsinput({
                trimValue: true,
                typeahead: {
                    source: [
                        @foreach($tags as $key => $tag)
                                '{{ ucwords($tag->name) }}',
                        @endforeach
                    ]
                },
                freeInput: true
            });

            $('input[name=materials]').on('itemAdded', function(event) {
                setTimeout(function(){
                    console.log($('.bootstrap-tagsinput input').val());
                    $('.bootstrap-tagsinput input').val('');
                }, 0);
            });
        })
    </script>
@endsection