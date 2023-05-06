@extends('layouts.master-layouts')
@section('title')
    @lang('translation.Medias')
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') Home @endslot
        @slot('title') @lang('translation.Medias') @endslot
        @slot('sub_title')  @endslot
    @endcomponent
    <form class="">
    <div class="d-md-flex d-block mb-4">        
        <label class="col-form-label me-4 font-size-16 mt-2"> Enter Range </label>
        
        <div class="d-flex mt-2">
            <label class="col-form-label me-2 font-size-16"> From: </label>
            <input type="date" class="form-control" name="start_date" value="{{$start_date}}" required/>
        </div>
        
        <div class="d-flex mt-2">
            <label class="col-form-label ms-3 me-2 font-size-16"> To: </label>
            <input type="date" class="form-control" name="end_date" value="{{$end_date}}" required/>
        </div>
        <button type="submit" class="btn btn-info mt-2 ms-3"><i class="fas fa-search me-2"></i>Filter</button>
    </div>
    </form>

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
                                        @foreach($category->filtered_medias as $media)
                                            <div class="px-2 py-2 col-xl-3 col-lg-4 col-md-6 col-sm-12 d-flex justify-content-center">
                                                <!-- This is for featured tag on the left top corner but we don't use it for now. -->
                                                <!-- <div class="position-absolute d-flex justify-content-center align-items-center" style="top:10px; left: 10px; width: 35px; height: 35px; background:#e9e8e89c; border-radius:50%;">
                                                    <i class="fas fa-award font-size-20 text-white"></i>
                                                </div>-->
                                                <!--  -->
                                                <div class="audio-card py-2 pe-4 ps-2">
                                                    <a href="{{route('media-detail', $media->id)}}" class="d-flex justify-content-center">
                                                        <img src="{{ URL::asset('public/assets/medias'). '/640_'. $media->path }}" class="img-fluid grid-image" alt="Responsive image">
                                                    </a>
                                                    <div class="px-2 py-2">
                                                        @foreach(json_decode($media->taglist) as $tag)
                                                        <span class="font-size-16 mx-2">{{$tag}}</span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <i class="fas fa-trash ms-2 text-danger font-size-18 position-absolute media-remove" style="top:20px; right: 10px; cursor:pointer;" data-id="{{$media->id}}"></i>
                                                <i class="fas ms-2 {{$media->status == 'active' ? 'text-danger fa-eye-slash' : 'text-success fa-eye'}} font-size-16 position-absolute media-active" style="top:55px; right: 10px; cursor:pointer;" data-id="{{$media->id}}"></i>
                                            </div>
                                            
                                        @endforeach
                                    </div>
                                <?php } else if($category->mediaType == "Video") { ?>
                                    <div class="row m-0">
                                        @foreach($category->filtered_medias as $media)
                                            <div class="px-2 py-2 col-xl-3 col-lg-4 col-md-6 col-sm-12">
                                                <div class="audio-card py-2 pe-4 ps-2">
                                                    <h4>{{$media->title}}</h4>                                            
                                                    <video controls preload="metadata" class="d-block w-100">
                                                        <source src="{{ $media->video_1280 }}" type="video/mp4">
                                                    </video>
                                                    <div class="px-2 py-2">
                                                    @foreach(json_decode($media->taglist) as $tag)
                                                    <span class="font-size-16 mx-2">{{$tag}}</span>
                                                    @endforeach
                                                    </div>
                                                </div>
                                                <i class="fas fa-trash ms-2 text-danger font-size-18 position-absolute media-remove" style="top:20px; right: 10px; cursor:pointer;" data-id="{{$media->id}}"></i>
                                                <i class="fas ms-2 {{$media->status == 'active' ? 'text-danger fa-eye-slash' : 'text-success fa-eye'}} font-size-16 position-absolute media-active" style="top:55px; right: 10px; cursor:pointer;" data-id="{{$media->id}}"></i>
                                            </div>
                                        @endforeach
                                    </div>
                                <?php } else if($category->mediaType == "Audio") { ?>
                                    <div class="row m-0">
                                        @foreach($category->filtered_medias as $media)
                                            <div class="px-2 py-2  col-xl-3 col-lg-4 col-md-6 col-sm-12">
                                                <div class="audio-card py-2 pe-4 ps-2">
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
                                                <i class="fas fa-trash ms-2 text-danger font-size-18 position-absolute media-remove" style="top:20px; right: 10px; cursor:pointer;" data-id="{{$media->id}}"></i>
                                                <i class="fas ms-2 {{$media->status == 'active' ? 'text-danger fa-eye-slash' : 'text-success fa-eye'}} font-size-16 position-absolute media-active" style="top:55px; right: 10px; cursor:pointer;" data-id="{{$media->id}}"></i>
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

        $('.media-active').click(function(){
            var status = $(this).hasClass('fa-eye-slash') ? 'active' : 'deactive';
            var id = $(this).attr('data-id');
            if(status == 'active')
            {
                $(this).removeClass('fa-eye-slash');
                $(this).removeClass('text-danger');

                $(this).addClass('fa-eye');
                $(this).addClass('text-success');
            } else {
                $(this).removeClass('fa-eye');
                $(this).removeClass('text-success');

                $(this).addClass('fa-eye-slash');
                $(this).addClass('text-danger');
            }
            var param = {
                    id : id,
                    status : (status == 'active' ? 'deactive' : 'active'),
                };

            console.log(param);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                dataType: 'json',
                contentType: 'application/json',
                url: '{{ url("media/changeStatus") }}',
                data: JSON.stringify(param),
                success: function (data){
                    let status = JSON.parse(data);
                },
                error: function(e) {
                    console.log(e);
                }});
        })
    </script>        
@endsection
