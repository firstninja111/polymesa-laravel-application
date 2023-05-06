@extends('layouts.master-layouts-landing')
@section('title')
    Search
@endsection
@section('content')
    <div>
        <div class="pd-top-10">
            <div>
                @if(count($medias) == 0)
                    <div class="col-md-12">
                        <div class="text-center">
                            <div>
                                <div class="row justify-content-center">
                                    <div class="col-sm-4">
                                        <div class="error-img">
                                            <img src="{{ URL::asset('public/assets/images/404-error.png') }}" alt=""
                                                class="img-fluid mx-auto d-block">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h4 class="text-uppercase mt-4">Sorry, no matching media found</h4>
                            <p class="text-muted">You should try to find with other keyword please.</p>
                            <div class="mt-5">
                                <a class="btn btn-primary waves-effect waves-light" href="{{ url('/') }}">Back to Home</a>
                            </div>
                        </div>

                    </div>
                @else
                    @if($mediaType == "Image")
                    <ul class="image-gallery">
                        @foreach($medias as $media)
                            <li>
                                <div class="gallery-content">
                                    <a href="{{route('media-detail', $media->id)}}">
                                        <div class="content-overlay"></div>
                                        <img class="content-image" src="{{ URL::asset('public/assets/medias'). '/640_'. $media->path }}">
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
                    @elseif($mediaType == "Audio")
                    <div id="mainwrap">
                        <div class="d-flex justify-content-end pt-4 pe-4">
                            
                        </div>
                        <p class="font-size-20 px-2"><span id="npTitle"></span></p>
                        <div id="audiowrap">
                            <div class="audio-card px-2 py-4 mb-4">
                                <div class="d-flex justify-content-between">
                                    <audio id="audio1" preload controls>Your browser does not support HTML5 Audio! 😢</audio>
                                    <button type="button" class="btn btn-info btn-rounded waves-effect waves-light py-2 fw-bold" id="audioDetail" data-id="1"><i class="fas fa-eye"></i><span class="d-md-inline-block d-none ms-2">Detail</span></button>
                                </div>
                                <div id="nowPlay">
                                    <span id="npAction">Paused...</span>
                                </div>
                                <div class="mt-2" id="tracks">
                                    <a id="btnPrev">&larr;</a><a id="btnNext">&rarr;</a>
                                </div>
                            </div>
                        </div>
                        <div id="plwrap">
                            <ul id="plList"></ul>
                        </div>
                    </div>
                    @elseif($mediaType == "Video")
                    <ul class="image-gallery">
                        @foreach($medias as $media)
                            <li>
                                <div class="gallery-content">
                                    <a href="{{route('media-detail', $media->id)}}">
                                        <div class="content-overlay"></div>
                                        <i class="fas fa-play-circle text-white video-play-icon"></i>

                                        <video>
                                            <source src="{{ $media->video_1280 }}" type="video/mp4">
                                        </video>
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
                    @endif

                @endif
            </div>
        </div>
    </div>
@endsection

@section('script')

<script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/html5media/1.1.8/html5media.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/plyr/3.6.8/plyr.min.js'></script>
<script>
    $(document).ready(function(){
    
        var tracks = [];
        var param = {
            category_id : <?php echo $id; ?>,
            key : "<?php echo $key ?>",
        };
        $.ajax({
            url: "{{URL::to('/medias/mediasByCategory')}}",
            type: 'POST',
            dataType: 'json',
            contentType: 'application/json',
            data: JSON.stringify(param),
            async: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (result) {
                console.log(result);
                $("#audioDetail").attr('data-id', result[0]['id']);
                for(i = 0; i < result.length; i++)
                {
                    var track = {
                        "track" : i + 1,
                        "id"    : result[i]['id'],
                        "name" : result[i]['title'],
                        "duration" : result[i]['duration'] == null ? '' : result[i]['duration'],
                        "file" : result[i]['path']
                    };

                    tracks.push(track);

                }
                // console.log(tracks[0]);
            },
        });

        var supportsAudio = !!document.createElement('audio').canPlayType;
        if (supportsAudio) {
            // initialize plyr
            var player = new Plyr('#audio1', {
                controls: [
                    'restart',
                    'play',
                    'progress',
                    'current-time',
                    'duration',
                    'mute',
                    'volume',
                    // 'download'
                ]
            });
            // initialize playlist and controls
            
            var index = 0,
            playing = false,
            mediaPath = "{{URL::asset('public/assets/medias')}}" + "/",
            extension = '',
            buildPlaylist = $.each(tracks, function(key, value) {
                var trackNumber = value.track,
                    trackName = value.name,
                    trackDuration = value.duration;

                if (trackNumber.toString().length === 1) {
                    trackNumber = '0' + trackNumber;
                }
                $('#plList').append('<li> \
                    <div class="plItem"> \
                        <span class="plNum">' + trackNumber + '.</span> \
                        <span class="plTitle">' + trackName + '</span> \
                        <span class="plLength">' + trackDuration + '</span> \
                    </div> \
                </li>');
            }),
            trackCount = tracks.length,
            npAction = $('#npAction'),
            npTitle = $('#npTitle'),
            audio = $('#audio1').on('play', function () {
                playing = true;
                npAction.text('Now Playing...');
            }).on('pause', function () {
                playing = false;
                npAction.text('Paused...');
            }).on('ended', function () {
                npAction.text('Paused...');
                if ((index + 1) < trackCount) {
                    index++;
                    loadTrack(index);
                    audio.play();
                } else {
                    audio.pause();
                    index = 0;
                    loadTrack(index);
                }
            }).get(0),
            btnPrev = $('#btnPrev').on('click', function () {
                if ((index - 1) > -1) {
                    index--;
                    loadTrack(index);
                    if (playing) {
                        audio.play();
                    }
                } else {
                    audio.pause();
                    index = 0;
                    loadTrack(index);
                }
            }),
            btnNext = $('#btnNext').on('click', function () {
                if ((index + 1) < trackCount) {
                    index++;
                    loadTrack(index);
                    if (playing) {
                        audio.play();
                    }
                } else {
                    audio.pause();
                    index = 0;
                    loadTrack(index);
                }
            }),
            li = $('#plList li').on('click', function () {
                var id = parseInt($(this).index());
                if (id !== index) {
                    playTrack(id);
                }
            }),
            loadTrack = function (id) {
                console.log("Tracking Id", tracks[id]);
                $('.plSel').removeClass('plSel');
                $('#plList li:eq(' + id + ')').addClass('plSel');
                npTitle.text(tracks[id].name);
                $("#audioDetail").attr('data-id', tracks[id].id);
                index = id;
                audio.src = mediaPath + tracks[id].file;
                updateDownload(id, audio.src);
            },
            updateDownload = function (id, source) {
                player.on('loadedmetadata', function () {
                    $('a[data-plyr="download"]').attr('href', source);
                });
            },
            playTrack = function (id) {
                loadTrack(id);
                audio.play();
            };
            extension = audio.canPlayType('audio/mpeg') ? '.mp3' : audio.canPlayType('audio/ogg') ? '.ogg' : '';
            loadTrack(index);
        } else {
            // no audio support
            $('.column').addClass('hidden');
            var noSupport = $('#audio1').text();
            $('.container').append('<p class="no-support">' + noSupport + '</p>');
        }
    });

    $("#audioDetail").click(function(){
        var mediaId = $(this).attr('data-id');
        window.location.href = "{{url('media-detail')}}" + '/' + mediaId;
    })
</script>
@endsection
