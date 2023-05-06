@extends('layouts.master-layouts-static')
@section('title')
    {{$user->username}}
@endsection
@section('content')
    <div style="position:relative">
        <svg style="position:absolute;top:0;left:0;width:100%;height: 100%; z-index:-1" viewBox="0 0 640 426" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid slice"><filter id="blur"><feGaussianBlur stdDeviation="3"></feGaussianBlur></filter>
            <image xlink:href="{{url('/public/assets/images/background/about.jpg')}}" width="640" height="426" filter="url(#blur)"></image>
        </svg>
        <div style="position:absolute;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,.1);"></div>
        <div class="position-realtive">
            <div class="p-3 text-white">
                <center>
                    <h1 class="text-white">{{$user->username}}</h1>
                    <p class="font-size-18">
                        <span>{{$user->lastname. ' '. $user->firstname}}</span>
                        @if($user->birthdate != NULL && $user->birthdate != "0000-00-00")
                            <span> · Age {{date_diff(date_create($user->birthdate), date_create(date('Y-m-d')))->format('%y')}}</span>
                        @endif
                        @if($user->country != NULL)
                            <span> · {{$user->country}} </span>
                        @endif
                        @if($user->country != NULL && $user->city != NULL)
                            <span> / {{$user->city}} </span>
                        @elseif($user->country == NULL && $user->city != NULL)
                            <span> · {{$user->city}} </span>
                        @endif
                        · Member since {{date('M d, Y', strtotime($user->created_at))}}
                    </p>
                    <img class="img-thumbnail rounded-circle avatar-xl" alt="200x200" src="{{ asset($user->avatar) }}" data-holder-rendered="true" data-xblocker="passed" style="visibility: visible;">
                    <div class="py-2">
                        <span class="font-size-16"><i class="text-white far fa-check-square static-fa-icon"> {{$count_all}}</i></span>
                        <span class="font-size-16"><i class="text-white fas fa-download static-fa-icon"> {{$downloads}}</i></span>
                        <span class="font-size-16"><i class="text-white fas fa-thumbs-up static-fa-icon"> {{$likes}}</i></span>
                        <span class="font-size-16"><i class="text-white fas fa-comment static-fa-icon"> {{$comments}}</i></span>
                        <span class="font-size-16"><i class="text-white fas fa-share-alt static-fa-icon"> {{$shares}}</i></span>
                    </div>        
                    <div class="hero-action mt-4">
                    <button class="btn btn-info btn-rounded me-2 myTooltip" onclick="copyClipboard(this)" onmouseout="outButton()">
                        Share My Profile
                        <span class="tooltiptext">Copy profile link</span>
                    </button>
                    <a href="{{route('donation', $user->id)}}"><button class="btn btn-success btn-rounded">Coffee</button></a>
                </div>           
                </center>
                
            </div>
        </div>
    </div>
    <ul class="nav nav-tabs nav-tabs-custom nav-justified static-page-tab" role="tablist">
        <li class="nav-item">
            <a class="pt-4 nav-link active" data-bs-toggle="tab" href="#popular" role="tab">
                <span class="d-block d-sm-none"><i class="fas fa-thumbs-up"></i></span>
                <span class="d-none d-sm-block font-size-18">POPULAR</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="pt-4 nav-link" data-bs-toggle="tab" href="#latest" role="tab">
                <span class="d-block d-sm-none"><i class="fas fa-bookmark"></i></span>
                <span class="d-none d-sm-block font-size-18">LATEST</span>
            </a>
        </li>
        @foreach($categories as $category)
        <li class="nav-item">
            <a class="pt-4 px-0 nav-link" data-bs-toggle="tab" href="#accordiontab_{{$category->id}}" role="tab">
                <span class="d-block d-sm-none"><i class="{{$category->className}}"></i></span>
                <span class="d-none d-sm-block font-size-18">{{strtoupper($category->name)}}</span>
            </a>
        </li>
        @endforeach
        <li class="nav-item">
            <a class="pt-4 px-0 nav-link" data-bs-toggle="tab" href="#about_me" role="tab">
                <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                <span class="d-none d-sm-block font-size-18">ABOUT ME</span>
            </a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content py-3 text-muted">
        <div class="tab-pane active" id="popular" role="tabpanel">
            <div class="row m-0">
                @foreach($popular as $media)
                    @if($media->category->mediaType == "Image")
                    <div class="px-2 py-2  col-xl-3 col-lg-4 col-md-6 col-sm-12">
                        <div class="audio-card px-2 py-2 h-100 d-flex flex-column justify-content-between">
                            <a href="{{route('media-detail', $media->id)}}" class="d-flex justify-content-center">
                                <img src="{{ URL::asset('public/assets/medias'). '/640_'. $media->path }}" class="img-fluid grid-image" alt="Responsive image">
                            </a>
                        </div>
                    </div>
                    @elseif($media->category->mediaType == "Audio")
                    <div class="px-2 py-2  col-xl-3 col-lg-4 col-md-6 col-sm-12">
                        <div class="audio-card px-2 py-2 h-100 d-flex flex-column justify-content-between">
                            <div>
                                <h4>{{$media->title}}</h4>
                                <audio controls preload="metadata" class="d-block w-100">
                                    <source src="{{asset('public/assets/medias'. '/'. $media->path) }}" type="audio/ogg">
                                </audio>
                            </div>
                        </div>
                    </div>
                    @elseif($media->category->mediaType == "Video")
                    <div class="px-2 py-2  col-xl-3 col-lg-4 col-md-6 col-sm-12">
                        <div class="audio-card px-2 py-2 h-100 d-flex flex-column justify-content-between">
                            <video controls preload="metadata" class="d-block w-100">
                                <source src="{{ $media->video_1280 }}" type="video/mp4">
                            </video>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="tab-pane" id="latest" role="tabpanel">
            <div class="row m-0">
                @foreach($latest as $media)
                    @if($media->category->mediaType == "Image")
                    <div class="px-2 py-2  col-xl-3 col-lg-4 col-md-6 col-sm-12">
                        <div class="audio-card px-2 py-2 h-100 d-flex flex-column justify-content-between">
                            <a href="{{route('media-detail', $media->id)}}" class="d-flex justify-content-center">
                                <img src="{{ URL::asset('public/assets/medias'). '/640_'. $media->path }}" class="img-fluid grid-image" alt="Responsive image">
                            </a>
                        </div>
                    </div>
                    @elseif($media->category->mediaType == "Audio")
                    <div class="px-2 py-2  col-xl-3 col-lg-4 col-md-6 col-sm-12">
                        <div class="audio-card px-2 py-2 h-100 d-flex flex-column justify-content-between">
                            <div>
                                <h4>{{$media->title}}</h4>
                                <audio controls preload="metadata" class="d-block w-100">
                                    <source src="{{asset('public/assets/medias'. '/'. $media->path) }}" type="audio/ogg">
                                </audio>
                            </div>
                        </div>
                    </div>
                    @elseif($media->category->mediaType == "Video")
                    <div class="px-2 py-2  col-xl-3 col-lg-4 col-md-6 col-sm-12">
                        <div class="audio-card px-2 py-2 h-100 d-flex flex-column justify-content-between">
                            <video controls preload="metadata" class="d-block w-100">
                                <source src="{{ $media->video_1280 }}" type="video/mp4">
                            </video>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
        @foreach($categories as $category)
        <div class="tab-pane" id="accordiontab_{{$category->id}}" role="tabpanel">
            @if($category->mediaType == "Image")
                <div class="row m-0">
                    @foreach($category->user_medias as $media)
                    <div class="px-2 py-2  col-xl-3 col-lg-4 col-md-6 col-sm-12">
                        <div class="audio-card px-2 py-2">
                            <a href="{{route('media-detail', $media->id)}}" class="d-flex justify-content-center">
                                <img src="{{ URL::asset('public/assets/medias'). '/640_'. $media->path }}" class="img-fluid grid-image" alt="Responsive image">
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                @elseif($category->mediaType == "Video")
                <div class="row m-0">
                    @foreach($category->user_medias as $media)
                    <div class="px-2 py-2  col-xl-3 col-lg-4 col-md-6 col-sm-12">
                        <div class="audio-card px-2 py-2">
                            <video controls preload="metadata" class="d-block w-100">
                                <source src="{{ $media->video_1280 }}" type="video/mp4">
                            </video>
                        </div>
                    </div>
                    @endforeach
                </div>
            @elseif($category->mediaType == "Audio")
                <div class="row m-0">
                    @foreach($category->user_medias as $media)
                    <div class="px-2 py-2  col-xl-3 col-lg-4 col-md-6 col-sm-12">
                        <div class="audio-card px-2 py-2">
                            <h4>{{$media->title}}</h4>
                            <audio controls preload="metadata" class="d-block w-100">
                                <source src="{{asset('public/assets/medias'. '/'. $media->path) }}" type="audio/ogg">
                            </audio>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
        @endforeach
        <div class="tab-pane" id="about_me" role="tabpanel">
            <p class="mb-0">
                <textarea class="bio-area text-muted text-center font-size-18" placeholder="In a few words, tell us about yourself" rows="5" id="bio" name="bio" disabled>{{$user->bio}}</textarea>
            </p>
        </div>
    </div>
    <!-- <div class="position-relative">
        <span style="height: 100%;"><div class="p-3" style="background-image: url('../public/assets/images/background/about.jpg'); background-size: cover; background-repeat: no-repeat; filter: brightness(0.6);"></div></span>
        <div class="position-absolute top-0">
            <div class="p-3">
                <center>
                    <h1 class="text-white">{{$user->username}}</h1>
                    <p>{{$user->lastname. ' '. $user->firstname}} · Age {{date_diff(date_create($user->birthdate), date_create(date('Y-m-d')))->format('%y')}} · {{$user->city}}/{{$user->country}} · Member since {{date('d/M/Y', strtotime($user->birthdate))}}</p>
                    <img class="img-thumbnail rounded-circle avatar-xl" alt="200x200" src="{{ asset($user->avatar) }}" data-holder-rendered="true" data-xblocker="passed" style="visibility: visible;">
                </center>
            </div>
        </div>
    </div> -->
@endsection

@section('script')

<script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/html5media/1.1.8/html5media.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/plyr/3.6.8/plyr.min.js'></script>
<script>
    // $(document).ready(function(){
    
    //     var tracks = [];
    //     var param = {
    //         category_id : <php echo $id; ?>,
    //         key : "<php echo $key ?>",
    //     };
    //     $.ajax({
    //         url: "{{URL::to('/medias/mediasByCategory')}}",
    //         type: 'POST',
    //         dataType: 'json',
    //         contentType: 'application/json',
    //         data: JSON.stringify(param),
    //         async: false,
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         success: function (result) {
    //             console.log(result);
    //             $("#audioDetail").attr('data-id', result[0]['id']);
    //             for(i = 0; i < result.length; i++)
    //             {
    //                 var track = {
    //                     "track" : i + 1,
    //                     "id"    : result[i]['id'],
    //                     "name" : result[i]['title'],
    //                     "duration" : result[i]['duration'] == null ? '' : result[i]['duration'],
    //                     "file" : result[i]['path']
    //                 };

    //                 tracks.push(track);

    //             }
    //             // console.log(tracks[0]);
    //         },
    //     });

    //     var supportsAudio = !!document.createElement('audio').canPlayType;
    //     if (supportsAudio) {
    //         // initialize plyr
    //         var player = new Plyr('#audio1', {
    //             controls: [
    //                 'restart',
    //                 'play',
    //                 'progress',
    //                 'current-time',
    //                 'duration',
    //                 'mute',
    //                 'volume',
    //                 // 'download'
    //             ]
    //         });
    //         // initialize playlist and controls
            
    //         var index = 0,
    //         playing = false,
    //         mediaPath = "{{URL::asset('public/assets/medias')}}" + "/",
    //         extension = '',
    //         buildPlaylist = $.each(tracks, function(key, value) {
    //             var trackNumber = value.track,
    //                 trackName = value.name,
    //                 trackDuration = value.duration;

    //             if (trackNumber.toString().length === 1) {
    //                 trackNumber = '0' + trackNumber;
    //             }
    //             $('#plList').append('<li> \
    //                 <div class="plItem"> \
    //                     <span class="plNum">' + trackNumber + '.</span> \
    //                     <span class="plTitle">' + trackName + '</span> \
    //                     <span class="plLength">' + trackDuration + '</span> \
    //                 </div> \
    //             </li>');
    //         }),
    //         trackCount = tracks.length,
    //         npAction = $('#npAction'),
    //         npTitle = $('#npTitle'),
    //         audio = $('#audio1').on('play', function () {
    //             playing = true;
    //             npAction.text('Now Playing...');
    //         }).on('pause', function () {
    //             playing = false;
    //             npAction.text('Paused...');
    //         }).on('ended', function () {
    //             npAction.text('Paused...');
    //             if ((index + 1) < trackCount) {
    //                 index++;
    //                 loadTrack(index);
    //                 audio.play();
    //             } else {
    //                 audio.pause();
    //                 index = 0;
    //                 loadTrack(index);
    //             }
    //         }).get(0),
    //         btnPrev = $('#btnPrev').on('click', function () {
    //             if ((index - 1) > -1) {
    //                 index--;
    //                 loadTrack(index);
    //                 if (playing) {
    //                     audio.play();
    //                 }
    //             } else {
    //                 audio.pause();
    //                 index = 0;
    //                 loadTrack(index);
    //             }
    //         }),
    //         btnNext = $('#btnNext').on('click', function () {
    //             if ((index + 1) < trackCount) {
    //                 index++;
    //                 loadTrack(index);
    //                 if (playing) {
    //                     audio.play();
    //                 }
    //             } else {
    //                 audio.pause();
    //                 index = 0;
    //                 loadTrack(index);
    //             }
    //         }),
    //         li = $('#plList li').on('click', function () {
    //             var id = parseInt($(this).index());
    //             if (id !== index) {
    //                 playTrack(id);
    //             }
    //         }),
    //         loadTrack = function (id) {
    //             console.log("Tracking Id", tracks[id]);
    //             $('.plSel').removeClass('plSel');
    //             $('#plList li:eq(' + id + ')').addClass('plSel');
    //             npTitle.text(tracks[id].name);
    //             $("#audioDetail").attr('data-id', tracks[id].id);
    //             index = id;
    //             audio.src = mediaPath + tracks[id].file;
    //             updateDownload(id, audio.src);
    //         },
    //         updateDownload = function (id, source) {
    //             player.on('loadedmetadata', function () {
    //                 $('a[data-plyr="download"]').attr('href', source);
    //             });
    //         },
    //         playTrack = function (id) {
    //             loadTrack(id);
    //             audio.play();
    //         };
    //         extension = audio.canPlayType('audio/mpeg') ? '.mp3' : audio.canPlayType('audio/ogg') ? '.ogg' : '';
    //         loadTrack(index);
    //     } else {
    //         // no audio support
    //         $('.column').addClass('hidden');
    //         var noSupport = $('#audio1').text();
    //         $('.container').append('<p class="no-support">' + noSupport + '</p>');
    //     }
    // });

    // $("#audioDetail").click(function(){
    //     var mediaId = $(this).attr('data-id');
    //     window.location.href = "{{url('media-detail')}}" + '/' + mediaId;
    // })

    function outButton() {
        $('.tooltiptext').html('Copy profile link');
    }

    function copyClipboard(obj) {
        var jObj = $(obj);
        
        var clipText = "{{url('users') . '/'. $user->username}}";
        navigator.clipboard.writeText(clipText);

        $('.tooltiptext').html("Copied!");
    }
</script>
@endsection
