@extends('layouts.master-layouts-landing')
@section('title')
    @lang('translation.Home')
@endsection
@section('content')
    <div>
        <div class="search-section d-flex justify-content-center align-items-center" style="background-image: url('public/assets/images/background/landing.jpg'); background-size: cover; background-repeat: no-repeat">
            <div>
                <div class="d-flex justify-content-center align-items-center text-center">
                    <h1 class="search-header" >Stunning free images & royalty free stock</h1>
                </div>
                <!-- <div class="d-flex justify-content-center align-items-center text-center">
                    <h4 class="search-subheader d-sm-hide">Over 2.5 million+ high quality stock images, videos and music shared by our talented community</h4>
                </div> -->
                <div class="d-flex justify-content-center align-items-center">
                    <div class="position-relative" id="searchbox">
                        
                        <input type="text" class="search-form-input" placeholder="Search Images, vectors, videos and music" >
                        <i class="fas fa-search font-size-18 inner-icon-search"></i>
                        <div class="inner-select-type">
                            <a class="dropdown-toggle text-reset" href="#" id="dropdownMenuButton5"
                                data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <span class="text-muted">
                                    <span class="filter-category" data-id="{{$categories[0]['id']}}">image</span>
                                    <i class="mdi mdi-chevron-down ms-1"></i>
                                </span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton5">
                                @foreach($categories as $category)
                                    <a class="dropdown-item select-category" data-id="{{$category->id}}">{{$category->name}}</a>
                                @endforeach
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="d-flex justify-content-center align-items-center text-center">
                    <p class="search-description d-sm-hide">Popular searches: background, wallpaper, nature, love, flowers, sky, flower, cat, dog, heart, money, food, cronovirus</p>
                </div>
            </div>
        </div>

        <div class="pd-top-10">
            <div class="">
                <ul class="image-gallery">
                    @foreach($medias as $media)
                        <li>
                            <div class="gallery-content">
                                <a href="{{route('media-detail', $media->id)}}">
                                    <div class="content-overlay"></div>
                                    
                                    <!-- This is for featured tag on the left top corner but we don't use it for now. -->
                                    <!-- <div class="position-absolute d-flex justify-content-center align-items-center" style="top:10px; left: 10px; width: 35px; height: 35px; background:#e9e8e89c; border-radius:50%;">
                                        <i class="fas fa-award font-size-20 text-white"></i>
                                    </div>   -->
                                    
                                    @if($media->category->mediaType == "Video")
                                    <i class="fas fa-play-circle text-white video-play-icon"></i>
                                    @endif
                                    @if($media->category->mediaType == "Image")
                                        <img class="content-image" src="{{ URL::asset('public/assets/medias'). '/640_'. $media->path }}">
                                    @elseif($media->category->mediaType == "Video")
                                        <video>
                                            <source src="{{ $media->video_640 }}" type="video/mp4">
                                        </video>
                                    @endif

                                    <div class="content-details fadeIn-bottom">
                                        <div class="" style="float:right;">
                                            <p class="content-text"><i class="fas fa-heart"></i> {{$media->liked}} &nbsp; <i class="fas fa-comment"></i> {{$media->commented}} &nbsp; <i class="fas fa-bookmark"></i> </p>
                                        </div>
                                        <div class="" style="float:left;">
                                            <h2 class="content-title ">
                                                @foreach(json_decode($media->taglist) as $tag)
                                                    <a type='button' href="" class="overlay-text">{{$tag}}</a>
                                                @endforeach
                                            </h2>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="text-center container" style="padding-top: 30px; padding-bottom: 180px;">
            <button type="button" class="btn btn-success btn-rounded waves-effect waves-light px-4">Discover more</button>

            <h1 class="search-header" style="margin-top: 100px;">Free Images, videos and music you can use anywhere</h1>
            <p class="search-description font-size-16">Polymesa is a vibrant community of creatives, sharing copyright fee images, videos and music. All contents are rleased under the Polymesa License, which makes them safe to use without asking for permission or giving crediet to the artist-even for commericial purposes.</p>
            <p class="text-success font-size-16">Learn more...</p>


            <h1 class="search-header" style="margin-top: 100px;">Join Polymesa</h1>
            <p class="search-description font-size-16">Download royalty free photos, videos and music. Share your own pictures as public domain with people all over the world.</p>
            @Guest
            <a href="{{url('register')}}"><button type="button" class="btn btn-success btn-rounded waves-effect waves-light px-4">Sign up, It's free!</button></a>
            @endGuest
        </div>

    </div>
@endsection

@section('script')
<script>
    $('.search-form-input').keypress(function(){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
            var category_id = $('.filter-category').attr('data-id');
            window.location.href = "{{URL::to('/media-search')}}" + "/" + category_id + '?key=' + $(this).val();
        }
    });

    $('.select-category').click(function(){
        // console.log($(this).html());
        // console.log($(this).attr('data-id'));

        $('.filter-category').html($(this).html());
        $('.filter-category').attr('data-id', $(this).attr('data-id'));
    });
</script>
@endsection