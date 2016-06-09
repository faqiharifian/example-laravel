@extends('layout')

@section('title', 'Upload - Amartha Furniture')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <!-- Check for drag and drop -->
    <script>(function(e,t,n){var r=e.querySelectorAll("html")[0];r.className=r.className.replace(/(^|\s)no-js(\s|$)/,"$1js$2")})(document,window,0);</script>
@stop

@section('content')
    <div class="upload">
        <div class="container">
            <div class="title">
                <p>Share your design idea &amp; our experts will get back with<br>
                the best possible made sugestion</p>
                <h1><b>Your Custom Furniture</b></h1>
            </div>

            <div class="row upload-form">

                <div class="col-sm-6 upload-image">
                    <h4>UPLOAD DESIGN</h4>
                    <form class="box" method="post" action="" enctype="multipart/form-data">
                      <div class="box__input">
                        <input class="box__file" type="file" name="files[]" id="file" data-multiple-caption="{count} files selected" multiple accept="image/*" />
                        <p class="text">
                            <label for="file"><strong>Choose a File</strong></label> <span class="box__dragndrop">or Drop Image Here.</span>
                        </p>
                      </div>
                      <div class="box__uploading">Uploading&hellip;</div>
                      <div class="box__error">Error! <span></span>.</div>
                    </form>
                    <div class="box__success">
                        <div></div>
                        <b class="success-text" style="display: none;">Upload Success!</b>
                        <b class="deleting-text" style="display: none;">Deleting&hellip;</b>
                    </div>
                </div>
                <div class="col-sm-6 information-form">
                    <form action="{{ action('ProductController@postCustom') }}" method="post" enctype="multipart/form-data">
                        @if(session('success') != null)
                            <p class="bg-success"><b>{{ session('success') }}</b></p>
                        @endif
                        <h4>CUSTOM FURNITURE INFORMATION</h4>
                        <hr>
                        <div class="form-group">
                            <label for="specify">Specify the dimensions of your furniture<span class="required">*</span></label>
                            <input id="specify" type="text" class="form-control" name="specification" value="{{ old('specification') }}" placeholder="Dimensions, measurements, size, material info" required>
                            {!! $errors->first('specification', '<p class="text-danger">:message</p>') !!}
                        </div>
                        <div class="form-group">
                            <label for="detail">Tell us any other details (optional)</label>
                            <textarea id="detail" class="form-control" name="detail" placeholder="Ask us any questions or tell us about your inspiration" style="height: 170px;">{{ old('detail') }}</textarea>
                        </div>
                        <br>
                        <h4>PERSONAL INFORMATION</h4>
                        <hr>
                        <div class="form-group">
                            <label for="name">Full Name<span class="required">*</span></label>
                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                            {!! $errors->first('name', '<p class="text-danger">:message</p>') !!}
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address<span class="required">*</span></label>
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                            {!! $errors->first('email', '<p class="text-danger">:message</p>') !!}
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number<span class="required">*</span></label>
                            <input id="phone" type="tel" class="form-control" name="phone" value="{{ old('phone') }}" required>
                            {!! $errors->first('phone', '<p class="text-danger">:message</p>') !!}
                        </div>
                        <div class="g-recaptcha" data-sitekey="{{ Config::get('recaptcha.site_key') }}"></div>
                        {!! csrf_field() !!}
                        <input type="file" name="images[]" style="display: none">
                        <input type="hidden" name="id" value="{{ old('id') }}">
                        <input class="sign-in-btn" type="submit" value="Submit Your Request">
                    </form>
                </div>

            </div>  <!-- Upload form -->

            <div class="row popular-product">
                <div class="col-sm-3 col-xs-12">
                    <h3 class="vertical-center"><b>Popular Product</b></h3>
                </div>
                <div class="col-sm-9 col-xs-12 product-list">
                    @foreach($products as $product)
                    <a class="col-sm-3 col-xs-12" href="{{ action('ProductController@show', ['product' => $product->id]) }}">
                        <div class="div-img vertical-center" style="background-image: url('/{{ Config::get('path.uploads') }}/products/{{ $product->id }}/{{ $product->images()->orderBy('order', 'asc')->first()->image }}')">
                            <img class="" src="/{{ Config::get('path.placeholder-1x1') }}" alt="">
                        </div>
                        <h4>{{ $product->name }}</h4>
                    </a>
                    @endforeach
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <hr class="line">
    </div>
@endsection

@section('content_js')
    <script type="text/javascript">
        /* Drag and Drop Upload - css-tricks.com/drag-and-drop-file-uploading/ */
        // Function to check weather browser support drag and drop or not
        var droppedFiles;
        var imageCount = 0;
        var isAdvancedUpload = function() {
          var div = document.createElement('div');
          return (('draggable' in div) || ('ondragstart' in div && 'ondrop' in div)) && 'FormData' in window && 'FileReader' in window;
        }();

        var $form = $('.box');
        if (isAdvancedUpload) {
          $form.addClass('has-advanced-upload');

          droppedFiles = false;
          $form.on('drag dragstart dragend dragover dragenter dragleave drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
          })
          .on('dragover dragenter', function() {
            $form.addClass('is-dragover');
          })
          .on('dragleave dragend drop', function() {
            $form.removeClass('is-dragover');
          })
          .on('drop', function(e) {
            droppedFiles = e.originalEvent.dataTransfer.files;
//              console.log(droppedFiles);
//              $('input[name="images[]"]')[0].files = droppedFiles;
//              $('input[name="files[]"]')[0].files = droppedFiles;
            $form.trigger('submit');
          });
        }

        $('.box__file').on('change', function(e) { // when drag & drop is NOT supported
          $form.trigger('submit');
        });

        $form.on('submit', function(e) {
          if ($form.hasClass('is-uploading')) return false;
            $('.success-text').hide();

//          $form.addClass('is-uploading').removeClass('is-error');
            e.preventDefault();

            var files;
            if(droppedFiles){
//                $('input[name="images[]"]')[0].files = droppedFiles;
                files = droppedFiles;
            }else{
//                $('input[name="images[]"]')[0].files = $('input[name="files[]"]')[0].files;
                files = $('input[name="files[]"]')[0].files;
            }
            $('.box__success div').html('');
            var isImage = [];
            $.each(files, function(key,file){
//                isFinish[key] = false;
                var type = file.type.toString();
                if(type.indexOf("image/") == -1){
                    isImage[key] = false;
                    alert("Please select image files.")
                }else{
                    isImage[key] = true;
//                    tempImages.append((count+key+1), file);
//                    $('input[name="images[]"]')[0].files;
//                    $('input[name="images[]"]')[0].files[imageCount++] = file;

//                    data.append('file', file);
//                    data.append('key', key);
//                    $.ajax({
//                        url: '{{ action('ProductController@postCustomImage') }}',
//                        headers: {
//                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//                        },
//                        type: 'POST',
//                        data: data,
//                        cache: false,
//                        dataType: 'json',
//                        processData: false, // Don't process the files
//                        contentType: false, // Set content type to false as jQuery will tell the server its a query string request
//                        success: function(data, textStatus, jqXHR)
//                        {
//                            if(data.success){
//                                $('.box__success div').append('<p data-id="'+data.id+'"><b>File Name: <span id="file-name">'+data.filename+'</span></b></p>');
//                                isFinish[data.key] = true;
//                                $('input[name=id]').val(data.custom_product_id);
//                                if($.inArray(false, isFinish) == -1){
//                                    $('.success-text').show();
//                                    $form.removeClass('is-uploading');
//                                    $('input[name="files[]"]').val('');
//                                    droppedFiles = false;
//                                }
//                            }
//
//                        },
//                        error: function(jqXHR, textStatus, errorThrown)
//                        {
//                            alert("Image upload failed");
//                        }
//                    });
                }

            });
//            var images = $('input[name="images[]"]')[0].files;

//            var tempImages = new FormData();
//            var count = 0;
//            $.each(images, function(key, file){
//                tempImages.append(key, file);
//                ++count;
//            });
//            var isFinish = [];
//            $('input[name="images[]"]')[0].files = droppedFiles;
//            $('input[name="files[]"]').val('');
            if($.inArray(false, isImage) == -1){
                $('input[name="images[]"]')[0].files = files;
                $.each(files, function(key,file){
                    $('.box__success div').append('<p><b>File Name: <span id="file-name">'+file.name+'</span></b></p>');
                });

            }
            droppedFiles = false;

//            $('input[name="files[]"]').val('');

            console.log($('input[name="images[]"]')[0].files);

//            $('input[name="images[]"]')[0].files = files;
//            $('input[name="images[]"]')[0].files = tempImages;


          if (isAdvancedUpload) {
            // ajax for modern browsers
          } else {
            // ajax for legacy browsers
          }
        });

        $(function(){
            $('.box__success').on('click', '.remove', function(){
                var _this = $(this);
                $('.deleting-text').show();
                $.post('{{ action('ProductController@removeCustomImage') }}', {id: $(this).parent().data('id')})
                        .done(function(data){
                            if(data.success){
                                $(_this).parent().remove();
                            }else{
                                alert('Delete Failed.');
                            }
                            $('.deleting-text').hide();
                        })
                        .fail(function(data){
                            alert('Delete Failed.');
                            $('.deleting-text').hide();
                        });
            })
        })

    </script>
@stop