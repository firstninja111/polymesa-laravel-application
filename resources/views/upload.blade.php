@extends('layouts.master-layouts')
@section('title')
    @lang('translation.Form_File_Upload')
@endsection
@section('css')
    <!-- plugin css -->
    <link href="{{ URL::asset('public/assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.css"> -->
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') Home @endslot
        @slot('title') File Upload @endslot
        @slot('sub_title') @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 col-md-12 px-4  d-none d-md-block">
                            <h4 class="font-size-18 mb-2 fw-bold">Supported file types</h4>

                            <h5 class="font-size-16 mt-4 fw-bold">Photos/Vetors</h5>
                            <p class="border-bottom border-2 mt-2 pb-4">
                                PNG, JPEG, JPG, PSD and AI images up to 20 MB with at least 3000 pixels along one side.
                                <a><span class="text-info" style="cursor: pointer;">Image Quality Guidelines...</span></a>
                            </p>

                            <h5 class="font-size-16 mt-4 fw-bold">Videos</h5>
                            <p class="border-bottom border-2 mt-2 pb-4">
                                MP4, AVI and MK videos up to 20 MB and a minimum resolution of 1920x800 pixels. Clips should but no longer than 60 seconds.
                                <a><span class="text-info" style="cursor: pointer;">Video Quality Guidelines...</span></a>
                            </p>

                            <h5 class="font-size-16 mt-4 fw-bold">Music/Audios</h5>
                            <p class="border-bottom border-2 mt-2 pb-4">
                                MP3, MP4, FLAC, WAV, WMA and AAC music up to 20 MB file size limit. Duration should be no longer than 15 minutes.
                                <a><span class="text-info" style="cursor: pointer;">Music Quality Guidelines...</span></a>
                            </p>
                        </div>
                        <div class="col-lg-8 col-md-12">
                            @if($remaining_week <= 0)
                                <p class="font-size-20 text-danger"> You have exceeded the amount you can upload this week. </p>
                            @elseif(Auth::user()->status == "deactive")
                                <p class="font-size-20 text-danger"> Your account is deactive and unable to upload. </p>
                            @else
                            <form method="post" action="{{url('upload/store')}}" enctype="multipart/form-data" 
                                    class="dropzone" id="dropzone">
                                    @csrf
                                <div class="fallback">
                                    <input name="file" type="file">
                                </div>
                                <div class="dz-message needsclick">
                                    <div class="mb-3">
                                        <i class="display-4 text-muted uil uil-cloud-upload"></i>
                                    </div>

                                    <h4 class="font-size-18">Drag and drop media file anywhere on the form</h4>
                                    <p class="font-size-16">{{$remaining_week}} uploads remaining this week</p>
                                </div>
                            </form>
                            <div class="row border-bottom border-2">
                                <div class="font-size-16 col-12 col-md-6  py-4" id="media_detail">
                                </div>
                                <div class="col-12 col-md-6  py-4 font-size-16" id="media_confirm" style="display:none;">
                                    <p id="media_success"><i class="fas fa-check-circle text-success me-2"></i><span>You are available to upload this media. Resolution will be considered by category.</span></p>
                                    <p id="media_resolution_error"><i class="fas fa-exclamation-circle text-danger me-2"><span></i>The resolution is not enough.</span></p>
                                    <p id="media_size_error"><i class="fas fa-exclamation-circle text-danger me-2"><span></i>The image size is over 20MB.</span></p>

                                    <p id="audio_size_error"><i class="fas fa-exclamation-circle text-danger me-2"><span></i>The audio size is over 20MB.</span></p>
                                    <p id="audio_length_error"><i class="fas fa-exclamation-circle text-danger me-2"><span></i>The audio duration is over 15min.</span></p>
                                </div>
                            </div>
                            @endif
                            
                            <div class="row  mt-4">
                                <div class="col-lg-6 col-md-12">
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Select Category</label>
                                        <div class="col-md-8">
                                            <select class="form-select" id="category">
                                                @foreach($categories as $category)
                                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Select Subcategory</label>
                                        <div class="col-md-8">
                                            <select class="form-select" id="subcategory">
                                                @foreach($subcategories as $subcategory)
                                                    <option value="{{$subcategory->id}}">{{$subcategory->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div>
                                    <div id="title_form" class="col-lg-6 col-md-12" style="{{ $categories[0]['mediaType'] == 'Audio' ? '' : 'display: none' }}">
                                        <div class="mb-3 row">
                                            <label for="audio_title" class="col-md-4 col-form-label">Audio Title</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="key" value="" id="audio_title" aria-label="Recipient's username">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-lg-6 col-md-12">
                                    <div class="mb-3 row">
                                        <label for="tag_filter" class="col-md-4 col-form-label">Enter Tag</label>
                                        <div class="col-md-8">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="key" value="" id="tag_filter" placeholder="Please input over 3 characters" aria-label="Recipient's username">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" id="search_btn" type="button"><i class="mdi mdi-magnify"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="mb-3 row">
                                        <p class="pt-2 text-info">
                                            Once you input the word and hit enter, the app displays word related to it below
                                        </p>
                                    </div>
                                </div>
                                <div id="selected_tags" style="display: none">
                                    <div id="selected_tag_label">
                                        <h5 class="font-size-16 mt-4 fw-bold">Selected Tags</h5>
                                    </div>
                                    <div id="tag_list">
                                    </div>
                                </div>
                                <div id="available_tags" style="display:none;">
                                    <div>
                                        <h5 class="font-size-16 mt-4 fw-bold">Available Tags</h5>
                                    </div>
                                    <div id="available_tags_list" style="max-height: 500px; overflow:auto;">
                                    </div>
                                </div>

                            </div>
                            
                            <div class="text-center mt-4">
                                <button id="upload_submit" type="button" class="btn btn-primary waves-effect waves-light px-4">Upload</button>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 px-2 pt-4 mt-4 d-sm-block d-md-none">
                            <h4 class="font-size-18 mb-2 fw-bold">Supported file types</h4>

                            <h5 class="font-size-16 mt-4 fw-bold">Photos/Vetors</h5>
                            <p class="border-bottom border-2 mt-2 pb-4">
                                PNG, JPEG, JPG, PSD and AI images up to 20 MB with at least 3000 pixels along one side.
                                <a><span class="text-info" style="cursor: pointer;">Image Quality Guidelines...</span></a>
                            </p>

                            <h5 class="font-size-16 mt-4 fw-bold">Videos</h5>
                            <p class="border-bottom border-2 mt-2 pb-4">
                                MP4, AVI and MK videos up to 20 MB and a minimum resolution of 1920x800 pixels. Clips should but no longer than 60 seconds.
                                <a><span class="text-info" style="cursor: pointer;">Video Quality Guidelines...</span></a>
                            </p>

                            <h5 class="font-size-16 mt-4 fw-bold">Music/Audios</h5>
                            <p class="border-bottom border-2 mt-2 pb-4">
                                MP3, MP4, FLAC, WAV, WMA and AAC music up to 20 MB file size limit. Duration should be no longer than 15 minutes.
                                <a><span class="text-info" style="cursor: pointer;">Music Quality Guidelines...</span></a>
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div> <!-- end col -->
        
    </div> <!-- end row -->

    <div class="block-ui clear">
            <div class="loading-info">
                <div class="loading-text loading">
                <div class="text" style="font-size: 16px;"> Processing Media ...</div>
                <div class="loader" role="progressbar">
                    <div class="rect1"></div>
                    <div class="rect2"></div>
                    <div class="rect3"></div>
                    <div class="rect4"></div>
                    <div class="rect5"></div>
                </div>
                </div>
            </div>
        </div>
@endsection
@section('script')
    <!-- Plugins js -->
    <script src="{{ URL::asset('public/assets/libs/dropzone/dropzone.min.js') }}"></script>
    <script>
        var upload_confirm = false;
        var imageExtensions = ['jpg', 'JPG', 'jpeg'];
        var videoExtensions = ['mp4', 'avi', 'mk'];
        var audioExtensions = ['mp3', 'mp4', 'flac', 'wav', 'wma', 'aac', 'ogg', 'oga', 'm4a'];

        var extension = "";
        var fileName = "";
        var video_640 = "";
        var video_1280 = "";
        var video_1920 = "";
        var video_org = "";
        
        var video_height_640 = "";
        var video_height_1280 = "";
        var video_height_1920 = "";
        var video_width_org = "";
        var video_height_org = "";

        var video_bytes_640 = "";
        var video_bytes_1280 = "";
        var video_bytes_1920 = "";
        var video_bytes_org = "";
        
        var audio_duration = "";

        var resolution_width = 0;
        var resolution_height = 0;

        Dropzone.options.dropzone =
         {
            maxFilesize: 200,
            renameFile: function(file) {
                var dt = new Date();
                var time = dt.getTime();
               return time+file.name;
            },
            acceptedFiles: ".jpeg,.jpg,.png,.mp3,.flac,.wav,.wma,.aac,.ogg,.m4a,.mp4,.avi,.mk",
            addRemoveLinks: true,
            timeout: 500000,
            // addedfile: function()
            // {
            //     $('.block-ui').removeClass('clear');
            // },

            removedfile: function(file) 
            {
                $("#media_detail").hide();
                $("#media_confirm").hide();

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    url: '{{ url("upload/delete") }}',
                    data: {
                        fileName: fileName
                    },
                    success: function (data){
                        console.log("File has been successfully removed!!");
                    },
                    error: function(e) {
                        console.log(e);
                    }});
                    var fileRef;
                    return (fileRef = file.previewElement) != null ? 
                    fileRef.parentNode.removeChild(file.previewElement) : void 0;
            },
       
            success: function(file, response) 
            {
                $('.block-ui').addClass('clear');

                initializeMediaConfirm();

                var detail = JSON.parse(response);
                fileType = detail['fileType'];
                extension = detail['extension'];
                resolution_width = detail['width'];
                resolution_height = detail['height'];

                if(fileType == "image") {
                    var html = "";
                    html += (detail['make'] != null ? ("<p class='mb-0 text-info'>Camera Name: " + detail['make'] + "</p>") : "");
                    html += (detail['model'] != null ? ("<p class='mb-0 text-info'>Model: " + detail['model'] + "</p>") : "");
                    html += "<p class='mb-0'>Resolution: " + detail['width'] + " x " + detail['height']  + "</p>";
                    html += (detail['FocalLength'] != null ? ("<p class='mb-0'>FocalLength: " + detail['FocalLength'] + "mm</p>") : "");
                    html += (detail['ApertureFNumber'] != null ? ("<p class='mb-0'>ApertureFNumber: " + detail['ApertureFNumber'] + "</p>") : "");
                    html += (detail['ShutterSpeedValue'] != null ? ("<p class='mb-0'>ShutterSpeedValue: 1/" + detail['ShutterSpeedValue'] + "s</p>") : "");
                    html += (detail['ISO'] != null ? ("<p class='mb-0'>ISO: " + "ISO" + " " + detail['ISO'] + "</p>") : "");
                    html += "<p class='mb-0'>Size: " + detail['mega_size'] + " MB" + "</p>";
                    html += "<p class='mb-0'>File Type: " + detail['extension'] + "</p>";
                    
                    $("#media_detail").html(html);
                    $("#media_detail").show();
                    fileName = detail['fileName'];
                    

                    if(detail['resolution_error'])
                        $("#media_resolution_error").show();
                    else
                        $("#media_resolution_error").hide();

                    if(detail['size_error'])
                        $("#media_size_error").show();
                    else
                        $("#media_size_error").hide();

                    if(!detail['resolution_error'] && !detail['size_error'])
                    {
                        upload_confirm = true;
                        $("#media_success").show();
                    }
                    else{
                        upload_confirm = false;
                        $("#media_success").hide();
                    }

                    $("#media_confirm").show();
                } else if(fileType == "audio" || fileType == "video") {
                    
                    fileName = detail['fileName'];
                    video_640 = detail['video_640'];
                    video_1280 = detail['video_1280'];
                    video_1920 = detail['video_1920'];
                    video_org = detail['video_org'];

                    video_height_640 = detail['video_height_640'];
                    video_height_1280 = detail['video_height_1280'];
                    video_height_1920 = detail['video_height_1920'];
                    video_width_org = detail['video_width_org'];
                    video_height_org = detail['video_height_org'];

                    video_bytes_640 = detail['video_bytes_640'];
                    video_bytes_1280 = detail['video_bytes_1280'];
                    video_bytes_1920 = detail['video_bytes_1920'];
                    video_bytes_org = detail['video_bytes_org'];

                    audio_duration = detail['duration_time_format'];

                    var html = "";
                    html += "<p class='mb-0'>Size: " + detail['size'] + "</p>";
                    html += "<p class='mb-0'>Duration: " + detail['duration'] + "</p>";

                    $("#media_detail").html(html);
                    $("#media_detail").show();

                    
                    if(detail['length_error'])
                        $("#audio_length_error").show();
                    else
                        $("#audio_length_error").hide();

                    if(detail['size_error'])
                        $("#audio_size_error").show();
                    else
                        $("#audio_size_error").hide();

                    if(!detail['length_error'] && !detail['size_error'])
                    {
                        upload_confirm = true;
                        $("#media_success").show();
                    }
                    else{
                        upload_confirm = false;
                        $("#media_success").hide();                        
                    }
                    $("#media_confirm").show();
                }

                
                
            },
            error: function(file, response)
            {
               return false;
            }
        };

        function initializeMediaConfirm() {
        
            $("#media_resolution_error").hide();
            $("#media_size_error").hide();
            $("#media_success").hide();

            $("#audio_size_error").hide();
            $("#audio_length_error").hide();

            $("#media_confirm").hide();
        }

        $("#search_btn").click(function(){
            var keyword = $("#tag_filter").val();
            if(keyword.length < 3)
                return;

            var param = {
                keyword : keyword,
            };
            $.ajax({
                url: "{{URL::to('/tags/search')}}",
                type: 'POST',
                dataType: 'json',
                contentType: 'application/json',
                data: JSON.stringify(param),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (result) {
                    var html = "";
                    for(i = 0; i < result.length; i++)
                        html += '<button type="button" class="btn btn-outline-secondary m-1 select-tag" onclick="selectTag(this)">' + result[i] + '</button>';
                    
                    $("#available_tags_list").html(html);
                },
            });

            $("#available_tags").show();
        })
        $("#tag_filter").change(function(){     // When user type value in filter tag input
            var keyword = $(this).val();
            if(keyword.length < 3)
                return;

            var param = {
                keyword : keyword,
            };
            $.ajax({
                url: "{{URL::to('/tags/search')}}",
                type: 'POST',
                dataType: 'json',
                contentType: 'application/json',
                data: JSON.stringify(param),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (result) {
                    var html = "";
                    for(i = 0; i < result.length; i++)
                        html += '<button type="button" class="btn btn-outline-secondary m-1 select-tag" onclick="selectTag(this)">' + result[i] + '</button>';
                    
                    $("#available_tags_list").html(html);
                },
            });

            $("#available_tags").show();
        })

        function selectTag(obj){    // When user click one of available tag
            $this = $(obj);
            var tag_name = $this.html().trim();
            
            // ======= Check if the tag is already selected ======== //
            var children = $("#tag_list")[0].children;
            for(var i = 0; i < children.length; i++)
            {
                console.log(children[i].children[0].innerHTML);
                if(children[i].children[0].innerHTML == tag_name)
                {
                    Swal.fire("Warning", "You have already selected this tag.", "warning");
                    return;
                }
            }

            $("#selected_tags").show();
            $("#selected_tag_label").show();

            $("#available_tags").hide();
            $("#tag_filter").val('');
            
            var element = '<p class="selected-tag m-1"><span>'+ tag_name +'</span><i class="fas fa-trash-alt text-danger ms-2 deselect-tag" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Deselect Tag" onclick="deSelectTag(this)"></i></p>'
            $("#tag_list").append(element);
        }

        function deSelectTag(obj){      // When user click trash icon of selected tag.
            $(obj).parent().remove();

            console.log('length', $("#tag_list").children().length);
            if($("#tag_list").children().length == 0)
                $("#selected_tag_label").hide();
        }

        $("#category").change(function(){
            console.log('category changed');
            
            var param = {
                id : $(this).val(),
            };
            $.ajax({
                url: "{{URL::to('/categories/getInfo')}}",
                type: 'POST',
                dataType: 'json',
                contentType: 'application/json',
                data: JSON.stringify(param),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (result) {
                    console.log(result);
                    if(result['mediaType'] == "Audio")
                        $("#title_form").show();
                    else
                        $("#title_form").hide();
                },
            });
            
            var param = {
                category_id : $(this).val(),
            };
            $.ajax({
                url: "{{URL::to('/subcategories/getFromCategory')}}",
                type: 'POST',
                dataType: 'json',
                contentType: 'application/json',
                data: JSON.stringify(param),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (result) {
                   console.log(result);
                   var html = "";
                   for(i = 0; i < result.length; i++)
                   {
                        html += "<option value = '" + result[i]['id'] + "'>" + result[i]['name'] + "</option>";
                   }
                   $("#subcategory").html(html);
                },
            });
        });

        $("#upload_submit").click(function(){
            if(upload_confirm == false)
            {
                Swal.fire("Warning", "The selected media is not available to upload.", "warning");
                return;
            }

            var selected_tag_cnt = $("#tag_list").children().length;
            if(selected_tag_cnt < 3 || selected_tag_cnt > 8)
            {
                Swal.fire("Warning", "Please select tag count more than 3 and less than 8 to upload", "warning");
                return;
            }
            
            var param = {
                id : $("#category").val(),
            };
            $.ajax({
                url: "{{URL::to('/categories/getInfo')}}",
                type: 'POST',
                dataType: 'json',
                contentType: 'application/json',
                data: JSON.stringify(param),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (result) {
                    console.log(result);
                    if(result['mediaType'] == "Image" && imageExtensions.includes(extension.toLowerCase()) ||
                       result['mediaType'] == "Video" && videoExtensions.includes(extension.toLowerCase()) ||
                       result['mediaType'] == "Audio" && audioExtensions.includes(extension.toLowerCase())){  // ====== When the category file type and uploaded file type is matched.

                        // Check if the title field is put
                        if(result['mediaType'] == "Audio" && $("#audio_title").val() == "")
                        {
                            Swal.fire("Warning", "Please input audio title", "warning");
                            return;
                        }

                        if(result['mediaType'] == "Image" && (resolution_width < result['width'] || resolution_height < result['height']))
                        {
                            Swal.fire("Warning", "The minimum resolution should be " + result['width'] + ' x ' + result['height'] + ".", "warning");
                            return;
                        }
                        //////////////////////////////

                        var taglist = [];
                        $('#tag_list').children().each(function(){
                            taglist.push($(this).children()[0].innerHTML);
                        })

                        var mediaParam = {
                            categoryId : $("#category").val(),
                            subcategoryId : $("#subcategory").val(),
                            path : fileName,
                            taglist : JSON.stringify(taglist),
                            title: $("#audio_title").val(),
                            mediaType: result['mediaType'],
                            duration: audio_duration,
                            video_640: video_640,
                            video_1280: video_1280,
                            video_1920: video_1920,
                            video_org: video_org,

                            video_height_640: video_height_640,
                            video_height_1280: video_height_1280,
                            video_height_1920: video_height_1920,
                            video_width_org: video_width_org,
                            video_height_org: video_height_org,

                            video_bytes_640: video_bytes_640,
                            video_bytes_1280: video_bytes_1280,
                            video_bytes_1920: video_bytes_1920,
                            video_bytes_org: video_bytes_org,
                        };
                        $.ajax({
                            url: "{{URL::to('/upload/addMedia')}}",
                            type: 'POST',
                            dataType: 'json',
                            contentType: 'application/json',
                            data: JSON.stringify(mediaParam),
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (result) {
                                Swal.fire("Success", "File Uploaded Successfully", "success");
                                window.location.href = "{{URL::to('user-dashboard')}}"
                            },
                        });
                    } else{     // ===== If not
                        Swal.fire("Warning", "Uploaded media type and category file type is not matched.", "warning");
                        return;
                    }
                },
            });
        })
    </script>

@endsection
