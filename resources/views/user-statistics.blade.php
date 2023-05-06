@extends('layouts.master-layouts')
@section('title')
    @lang('translation.Statistics')
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') Home @endslot
        @slot('title') @lang('translation.Statistics') @endslot
        @slot('sub_title')  @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
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
                                        <div class="px-2 py-2  col-xl-3 col-lg-4 col-md-6 col-sm-12">
                                            <div class="audio-card px-2 py-2">
                                                <a href="{{route('media-detail', $media->id)}}" class="d-flex justify-content-center">
                                                    <img src="{{ URL::asset('public/assets/medias'). '/640_'. $media->path }}" class="img-fluid grid-image" alt="Responsive image">
                                                </a>

                                                @if($media->approved == 1 && $media->status == 'active')
                                                    <p class="text-center font-size-16 mt-2 mb-0"><i class="fas fa-award me-2" style="color: gray"> </i>Featured</p>
                                                @elseif($media->approved == 0 && $media->status == 'active')
                                                    <p class="text-center font-size-16 mt-2 mb-0">Published</p>
                                                @elseif($media->status == 'deactive')
                                                    <p class="text-center font-size-16 mt-2 mb-0">Declined</p>
                                                @endif

                                                <div class="py-2">
                                                    <span class="font-size-16"><i class="fas fa-eye static-fa-icon"> {{$media->views}}</i></span>
                                                    <span class="font-size-16"><i class="fas fa-download static-fa-icon"> {{$media->downloads}}</i></span>
                                                    <span class="font-size-16"><i class="fas fa-thumbs-up static-fa-icon"> {{$media->liked}}</i></span>
                                                    <span class="font-size-16"><i class="fas fa-comment static-fa-icon"> {{$media->commented}}</i></span>
                                                    <span class="font-size-16"><i class="fas fa-share-alt static-fa-icon"> {{$media->shares}}</i></span>

                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                <?php } else if($category->mediaType == "Video") { ?>
                                    <div class="row m-0">
                                    @foreach($category->my_media as $media)
                                    <div class="px-2 py-2  col-xl-3 col-lg-4 col-md-6 col-sm-12">
                                        <div class="audio-card px-2 py-2">
                                            <h4>{{$media->title}}</h4>
                                            <video controls preload="metadata" class="d-block w-100">
                                                <source src="{{ $media->video_640 }}" type="video/mp4">
                                            </video>
                                            @if($media->approved == 1 && $media->status == 'active')
                                                <p class="text-center font-size-16 mt-2 mb-0"><i class="fas fa-award me-2" style="color: gray"> </i>Featured</p>
                                            @elseif($media->approved == 0 && $media->status == 'active')
                                                <p class="text-center font-size-16 mt-2 mb-0">Published</p>
                                            @elseif($media->status == 'deactive')
                                                <p class="text-center font-size-16 mt-2 mb-0">Declined</p>
                                            @endif

                                            <div class="py-2">
                                                <span class="font-size-16"><i class="fas fa-eye static-fa-icon"> {{$media->views}}</i></span>
                                                <span class="font-size-16"><i class="fas fa-download static-fa-icon"> {{$media->downloads}}</i></span>
                                                <span class="font-size-16"><i class="fas fa-thumbs-up static-fa-icon"> {{$media->liked}}</i></span>
                                                <span class="font-size-16"><i class="fas fa-comment static-fa-icon"> {{$media->commented}}</i></span>
                                                <span class="font-size-16"><i class="fas fa-share-alt static-fa-icon"> {{$media->shares}}</i></span>

                                            </div>
                                        </div>
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
                                            @if($media->approved == 1 && $media->status == 'active')
                                                <p class="text-center font-size-16 mt-2 mb-0"><i class="fas fa-award me-2" style="color: gray"> </i>Featured</p>
                                            @elseif($media->approved == 0 && $media->status == 'active')
                                                <p class="text-center font-size-16 mt-2 mb-0">Published</p>
                                            @elseif($media->status == 'deactive')
                                                <p class="text-center font-size-16 mt-2 mb-0">Declined</p>
                                            @endif
                                            <div class="py-2">
                                                <span class="font-size-16"><i class="fas fa-eye static-fa-icon"> {{$media->views}}</i></span>
                                                <span class="font-size-16"><i class="fas fa-download static-fa-icon"> {{$media->downloads}}</i></span>
                                                <span class="font-size-16"><i class="fas fa-thumbs-up static-fa-icon"> {{$media->liked}}</i></span>
                                                <span class="font-size-16"><i class="fas fa-comment static-fa-icon"> {{$media->commented}}</i></span>
                                                <span class="font-size-16"><i class="fas fa-share-alt static-fa-icon"> {{$media->shares}}</i></span>
                                            </div>
                                        </div>
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
