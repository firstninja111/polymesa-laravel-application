@extends('layouts.master-layouts')
@section('title')
    @lang('translation.Dashboard')
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') Home @endslot
        @slot('title') @lang('translation.Dashboard') @endslot
        @slot('sub_title')  @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body user-dashboard">
                    <!-- Category types -->
                    <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                        <?php $index = 0; foreach($categories as $category) { $index++;?>
                        <li class="nav-item">
                            <a class="nav-link {{$index == 1 ? 'active' : '' }}" data-bs-toggle="tab" href="#accordiontab_{{$category->id}}" role="tab">
                                <i class="{{$category->className}} font-size-20"></i>
                                <span class="d-none d-sm-block">{{$category->name}}</span>
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                    <!-- Tab content -->
                    <div class="tab-content py-3">
                        <?php $index = 0; foreach($categories as $category) { $index++; ?>
                            <div class="tab-pane {{$index == 1 ? 'active' : '' }}" id="accordiontab_{{$category->id}}" role="tabpanel">
                                <?php if($category->mediaType == "Image") {?>
                                    <div class="row m-0">
                                        @foreach($category->my_media as $media)
                                            
                                            <div class="px-2 py-2 col-xl-3 col-lg-4 col-md-6 col-sm-12 d-flex justify-content-center">
                                                <!-- This is for featured tag on the left top corner but we don't use it for now. -->
                                                <!-- <div class="position-absolute d-flex justify-content-center align-items-center" style="top:10px; left: 10px; width: 35px; height: 35px; background:#e9e8e89c; border-radius:50%;">
                                                    <i class="fas fa-award font-size-20 text-white"></i>
                                                </div>-->
                                                <!--  -->
                                                <div class="audio-card px-2 py-2">
                                                    <a href="{{route('media-detail', $media->id)}}" class="d-flex justify-content-center">
                                                        <img src="{{ URL::asset('public/assets/medias'). '/640_'. $media->path }}" class="img-fluid grid-image" alt="Responsive image">
                                                    </a>
                                                    <div class="px-2 py-2">
                                                        @foreach(json_decode($media->taglist) as $tag)
                                                        <span class="font-size-16 mx-2">{{$tag}}</span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                @if($media->day_difference <= 7)
                                                    <i class="fas fa-trash ms-2 text-danger font-size-20 position-absolute media-remove" style="top:5px; right: 5px; cursor:pointer;" data-id="{{$media->id}}"></i>
                                                @endif
                                            </div>
                                            
                                        @endforeach
                                    </div>
                                <?php } else if($category->mediaType == "Video") { ?>
                                    <div class="row m-0">
                                        @foreach($category->my_media as $media)
                                            <div class="px-2 py-2 col-xl-3 col-lg-4 col-md-6 col-sm-12">
                                                <div class="audio-card px-2 py-2">
                                                    <h4>{{$media->title}}</h4>                                            
                                                    <video controls preload="metadata" class="d-block w-100">
                                                        <source src="{{ $media->video_640 }}" type="video/mp4">
                                                    </video>
                                                    <div class="px-2 py-2">
                                                    @foreach(json_decode($media->taglist) as $tag)
                                                    <span class="font-size-16 mx-2">{{$tag}}</span>
                                                    @endforeach
                                                    </div>
                                                </div>
                                                @if($media->day_difference <= 7)
                                                    <i class="fas fa-trash ms-2 text-danger font-size-20 position-absolute media-remove" style="top:5px; right: 5px; cursor:pointer;" data-id="{{$media->id}}"></i>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                <?php } else if($category->mediaType == "Audio") { ?>
                                    <div class="row m-0">
                                        @foreach($category->my_media as $media)
                                            <div class="px-2 py-2  col-xl-3 col-lg-4 col-md-6 col-sm-12">
                                                <div class="audio-card px-2 py-2">
                                                    <h4>{{$media->title}}</h4>
                                                    <audio controls preload="metadata" class="d-block w-100">
                                                        <source src="{{asset('public/assets/medias'. '/'. $media->path) }}" type="audio/ogg">
                                                    </audio>
                                                    <div class="px-2 py-2">
                                                    @foreach(json_decode($media->taglist) as $tag)
                                                    <span class="font-size-16 mx-2">{{$tag}}</span>
                                                    @endforeach
                                                    </div>
                                                </div>
                                                @if($media->day_difference <= 7)
                                                    <i class="fas fa-trash ms-2 text-danger font-size-20 position-absolute media-remove" style="top:5px; right: 5px; cursor:pointer;" data-id="{{$media->id}}"></i>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                <?php }?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

@endsection

@section('script')
    <script>
        $('.media-remove').click(function(){
            var id = $(this).attr('data-id');
            var grid = $(this).parent();
            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to delete selected media?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#34c38f",
                cancelButtonColor: "#f46a6a",
                confirmButtonText: "Yes, delete it!"
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: '{{ url("media/remove") }}',
                        data: {id: id},
                        success: function (data){
                            let status = JSON.parse(data);
                            if(status == "success")
                            {
                                grid.remove();
                                Swal.fire("Deleted!", "The media has been successfully removed!", "success");
                            }
                        },
                        error: function(e) {
                            console.log(e);
                        }});
                }
            });
        })
    </script>        
@endsection
