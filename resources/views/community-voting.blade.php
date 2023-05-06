@extends('layouts.master-layouts')
@section('title')
    @lang('translation.Media_Curation')
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') Home @endslot
        @slot('title') @lang('translation.Media_Curation') @endslot
        @slot('sub_title')  @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-4">
                    <div class="pb-2 mb-4 border-bottom border-2 row d-flex align-items-center">
                        <div class="col-md-1 col-sm-12">
                            <h4 class="font-size-18 fw-normal">{{$media_cnt}} medias</h4>
                        </div>
                        <div class="col-md-1 col-sm-12 mb-1">
                            <div class="btn-group">
                                <button type="button" class="btn btn-light dropdown-toggle font-size-18 fw-normal" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: transparent; border: transparent; padding: 0; color: #495057">Statistics <i class="mdi mdi-chevron-down"></i></button>
                                <div class="dropdown-menu mt-2 dropdown-responsive" style="margin: 0px; background:#1e1e1e;">
                                    <a class="dropdown-item hover-none" style="color: #bdbaba;">You've voted on {{$accepted_me + $declined_me}} images. Thanks!</a>
                                    <a class="dropdown-item hover-none" style="color: #bdbaba;">You accepted {{$accepted_me}} out of {{$accepted}} approved images.</a>
                                    <a class="dropdown-item hover-none" style="color: #bdbaba;">You rejected {{$declined_me}} out of {{$declined}} declined images</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item hover-none" style="color: green;">Well done!</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-12">
                            <h4 class="font-size-18 fw-normal" style="cursor: pointer;">Recently declined</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2">
                            @if($media == NULL)
                            <p class="font-size-20">No media to vote more</p>
                            @else
                            <div class="d-flex justify-content-end mb-4">
                                <form action="{{route('media/vote')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input value="{{$media->id}}" name="mediaId" hidden/>
                                <button type="submit" name="action" value = "decline" class="btn btn-danger btn-rounded waves-effect font-size-20 mx-2"><i class="dripicons-cross"></i></button>
                                <button type="submit" name="action" value ="accept" class="btn btn-success btn-rounded waves-effect font-size-20 mx-2"><i class="fas fa-check"></i></button>
                                </form>
                            </div>
                            <div class="d-flex justify-content-end">
                                <p class="font-size-16 hover-danger" style="cursor:pointer;"><i class="fas fa-flag me-2"></i>Report</p>
                            </div>
                            <div class="d-flex justify-content-end">
                                <p class="font-size-16 hover-success" style="cursor:pointer;"><i class="fas fa-bookmark me-2"></i>Add to collection</p>
                            </div>
                            @endif
                        </div>
                        <div class="col-lg-10" style="max-width: 700px;">
                            @if($media != NULL)
                                @if($media->category->mediaType == 'Image')
                                <figure class="zoom img-fluid" onmousemove="zoom(event)" style="background-image: url({{'public/assets/medias'. '/'. $media->path}})">
                                    <img src="{{ URL::asset('public/assets/medias'. '/1280_'. $media->path) }}" />
                                </figure>
                                @elseif($media->category->mediaType == 'Audio')
                                <h4 class="text-center">{{$media->title}}</h4>
                                <audio controls preload="metadata" class="d-block w-100">
                                    <source src="{{asset('public/assets/medias'. '/'. $media->path) }}" type="audio/ogg">
                                </audio>
                                @elseif($media->category->mediaType == 'Video')
                                <video class="w-100" controls>
                                    <source src="{{ URL::asset('public/assets/medias'). '/'. $media->path }}" type="video/mp4">
                                </video>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

@endsection

@section('script-bottom')
<script>
    function zoom(e){
        var zoomer = e.currentTarget;
        e.offsetX ? offsetX = e.offsetX : offsetX = e.touches[0].pageX
        e.offsetY ? offsetY = e.offsetY : offsetX = e.touches[0].pageX
        x = offsetX/zoomer.offsetWidth*100
        y = offsetY/zoomer.offsetHeight*100
        zoomer.style.backgroundPosition = x + '% ' + y + '%';
    }
</script>
@endsection