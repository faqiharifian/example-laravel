@extends('admin.layout')

@section('title', 'Slider')

@section('content_css')
    <link href="/{{ Config::get('path.css') }}/dropzone.css" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <div id="slider" class="carousel slide main" data-ride="carousel" style="margin-bottom: 25px">
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

    <form action="{{ action('Admin\SliderController@store')}}" class="dropzone" id="my-awesome-dropzone">
        {!! csrf_field() !!}
    </form>


@endsection

@section('content_js')
    <script type="text/javascript" src="/{{ Config::get('path.js') }}/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/{{ Config::get('path.js') }}/dropzone.js"></script>
    <script>
        var actionDelete = '<button type="button" class="action-delete close"><span class="tool">&times;</span></button>';
        var order = 0;
        $(function(){
            $('#slider').height($('#slider').width()/16*4);

            Dropzone.autoDiscover = false;

            var postDefault = '{{ action('Admin\SliderController@update') }}';
            var toggleLink = '{{ action('Admin\SliderController@toggle') }}';

            $(".dropzone").dropzone({
                acceptedFiles: 'image/*',
                thumbnailWidth: $('.dz-preview').css('width'),
                init: function(){
                    init(this);
                    this.on('addedfile', function(file){
                        if (!file.type.match(/image.*/)) {
                            this.removeFile(file);
                            alert('Please select image files');
                        }
                    });
                    this.on('success', function(file, response){
                        $(file.previewElement).attr('id', response.id);
                        $(file.previewElement).attr('data-url', '');
                        $(file.previewElement).attr('data-post', postDefault+"?slider="+response.id);
                        $(file.previewElement).find('.dz-image').addClass('div-img').css('background-image', 'url(\''+response.image+'\')');
                        $(file.previewElement).find('.dz-image img').attr('data-src', response.image);
                        $(file.previewElement).find('.dz-image img').attr('src', '/{{ Config::get('path.placeholder-16x4') }}');
                        $(file.previewElement).append('<a class="dz-toggle" href="'+toggleLink+'?slider='+response.id+'">Show</a>')
                        addSlider(response.id, response.image);
                        openModalURL($(file.previewElement));
                    });
                },
            });

            $('.dropzone').sortable({
                update: function(event, ui) {
                    var image_order = $(this).sortable('toArray').toString();
                    $.post("{{ action('Admin\SliderController@update') }}", {order: $(this).sortable('toArray').toString(), _token: $('meta[name="csrf-token"]').attr('content')});

                    updateSlider();
                }
            }).on('click', '.dz-preview', function(e){
                if(!$(e.target).hasClass('dz-toggle') && !$(e.target).hasClass('dz-remove'))
                    openModalURL($(this));
            });
            $(document).on('submit', 'form#edit-slider', function (e) {
                e.preventDefault();
                var $btn = $(this).find('.save-url').button('loading');
                var modal = $(this).parent().parent();
                $(modal).on('hidden.bs.modal', function(){
                    $(this).remove();
                });
                var url = $(modal).find('input');
                $(url).parent().removeClass('has-error');
                $(url).parent().find('.text-danger').remove();
                var data = {
                    url: $(url).val(),
                    _token: $('meta[name="csrf-token"]').attr('content')
                };
                var action = $(modal).find('form').attr('action');
                $.post(action, data)
                        .done(function(data){
                            if(data.success == true){
                                $('.dz-preview[id="'+$(modal).data('id')+'"]').attr('data-url', $(url).val());
                                if($(url).val() != '')
                                    $('.carousel-inner .item.'+$(modal).data('id')+' a').attr('href', $(url).val());
                                else
                                    $('.carousel-inner .item.'+$(modal).data('id')+' a').removeAttr('href');
                                $(modal).modal('hide');
                            }else{
                                $(url).parent().addClass('has-error');
                                $(url).parent().append('<p class="text-danger">'+data.url[0]+'</p>');
                            }
                            $btn.button('reset');
                        }).fail(function(data){
                            alert('Failed saving, please try again');
                            $btn.button('reset');
                });
            });
        });

        function init(dropzone){
            @foreach($sliders as $slider)
                var file = { name: "{{ $slider->image }}", size: {{ filesize(public_path('/'.Config::get('path.uploads').'/sliders/'.$slider->image)) }} };
                dropzone.emit("addedfile", file);
                dropzone.emit("thumbnail", file, "/{{ Config::get('path.uploads') }}/sliders/{{ $slider->image }}");
                dropzone.emit("complete", file);
                dropzone.createThumbnailFromUrl(this, '/{{ Config::get('path.uploads') }}/sliders/{{ $slider->image }}');
                $(file.previewElement).attr('id', '{{ $slider->id }}');
                $(file.previewElement).attr('data-url', '{{ $slider->url }}');
                $(file.previewElement).attr('data-post', '{{ action('Admin\SliderController@update', ['slider' => $slider->id]) }}');
                $(file.previewElement).append('<a class="dz-toggle" href="{{ action('Admin\SliderController@toggle', ['slider' => $slider->id]) }}"> {{ $slider->show ? 'Hide' : 'Show' }} </a>');
                $(file.previewElement).find('.dz-image').addClass('div-img').css('background-image', "url('/{{ Config::get('path.uploads') }}/sliders/{{ $slider->image }}')");
                $(file.previewElement).find('.dz-image img').attr('data-src', "/{{ Config::get('path.uploads') }}/sliders/{{ $slider->image }}");
                $(file.previewElement).find('.dz-image img').attr('src', '/{{ Config::get('path.placeholder-16x4') }}');
            @endforeach
        }

        function addSlider(id, image){
            var parentIndicators = $('.carousel-indicators');
            var length = $(parentIndicators).children().length;
            $(parentIndicators).append('<li data-target="#slider" data-slide-to="'+length+'" class="'+(length == 0 ? 'active' : '')+'"></li>');

            var parentInners = $('.carousel-inner');
            $(parentInners).append('<div class="'+id+' item '+(length == 0 ? 'active' : '')+'">\
                    <a>\
                        <div class="div-img" style="background-image: url(\''+image+'\')">\
                            <img src="/{{ Config::get('path.placeholder-16x4') }}" alt="">\
                        </div>\
                    </a>\
                    </div>');
        }

        function updateSlider(){
            var sliders = $('.dropzone .dz-image img');
            $('.carousel-indicators').html('');
            $('.carousel-inner').html('');
            $(sliders).each(function(key, data){
                $('.carousel-indicators').append('<li data-target="#slider" data-slide-to="'+key+'" class="'+(key == 0 ? 'active' : '')+'"></li>');
                $('.carousel-inner').append('<div class="'+($(data).parent().parent().attr('id'))+' item '+(key == 0 ? 'active' : '')+'">\
                    <a '+($(data).parent().parent().data('url') != '' ? 'href="'+$(data).parent().parent().data('url')+'"' : '')+' target="_blank">\
                        <div class="div-img" style="background-image: url(\''+$(data).attr('data-src')+'\')">\
                            <img src="/{{ Config::get('path.placeholder-16x4') }}" alt="">\
                        </div>\
                    </a>\
                    </div>');
            });
        }

        function deleteSlider(id){
            var deleteThis = $('.carousel-inner .item.'+id);
            var index = $(deleteThis).index();
            if($(deleteThis).hasClass('active')){
                if(index == ($('.carousel-inner .item').length-1)){
                    $('.carousel-inner .item:eq(0)').addClass('active');
                }else{
                    $('.carousel-inner .item:eq('+($(deleteThis).index()+1)+')').addClass('active');
                }
            }
            $(deleteThis).remove();

            deleteThis = $('.carousel-indicators li:eq('+index+')');
            if($(deleteThis).hasClass('active')){
                if(index == ($('.carousel-indicators li').length-1)){
                    $('.carousel-indicators li:eq(0)').addClass('active');
                }else{
                    $('.carousel-indicators li:eq('+($(deleteThis).index()+1)+')').addClass('active');
                }
            }
            $(deleteThis).remove();
        }

        function openModalURL(dzPreview){
            var modalClone = $('#slider-modal').clone();
            $(modalClone).modal('show');
            $(modalClone).attr('data-id', $(dzPreview).attr('id'));
            $(modalClone).find('form').attr('action', $(dzPreview).data('post'));
            $(modalClone).find('form input').val($(dzPreview).attr('data-url'));
            $(modalClone).find('.div-img').css('background-image', "url('"+$(dzPreview).find('.dz-image img').attr('data-src')+"')");
            var deleteTarget = $(modalClone).find('button.delete').attr('data-target');
            $(modalClone).find('button.delete').attr('data-target', deleteTarget+$(dzPreview).attr('id'));
            $(modalClone).find('button.delete').on('click', function(){
                if(confirm("Are you sure want to delete this item?")){
                    var $btn = $(this).button('loading');
                    window.location = $(this).attr('data-target');
                }
            })
        }
    </script>
    <div id="slider-modal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <form id="edit-slider" action="" class="form-inline" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Edit URL</h4>
                    </div>
                    <div class="modal-body">
                        <div class="div-img">
                            <img src="/{{ Config::get('path.placeholder-16x4') }}" alt="" style="width: 100%">
                        </div>

                        <div class="form-horizontal" style="margin-top: 15px">
                            <label for="">URL</label>
                            <input type="url" class="form-control" name="url" placeholder="http://...">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-loading-text="Deleting..." class="btn btn-danger btn-fill delete" autocomplete="off" data-target="{{ action('Admin\SliderController@destroy', ['id' => '']) }}">Delete</button>
                        <button type="submit" data-loading-text="Saving..." class="btn btn-primary btn-fill save-url">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection