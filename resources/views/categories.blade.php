@extends('layouts.master-layouts')
@section('title')
    @lang('translation.Categories')
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') Home @endslot
        @slot('title') @lang('translation.Categories') @endslot
        @slot('sub_title')  @endslot
    @endcomponent
    <div class="d-flex justify-content-end">
        <button type="button" class="btn btn-success waves-effect waves-light mb-3" id="add_cateogry">
            <i class="mdi mdi-plus me-1"></i> Add Category
        </button>
    </div>

    <div class="row">
        @foreach($categories_fetch as $category)
        <div class="col-xl-3 col-sm-6">
            <div class="card text-center">
                <div class="card-body">
                    <div class="dropdown float-end">
                        <a class="text-body dropdown-toggle font-size-16" href="#" role="button" data-bs-toggle="dropdown"
                            aria-haspopup="true">
                            <i class="uil uil-ellipsis-h"></i>
                        </a>

                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item edit_category" data-id="{{$category->id}}">Edit</a>
                            <a class="dropdown-item remove_category" data-id="{{$category->id}}">Remove</a>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="mb-4">
                        <i class="{{$category->className}} rounded-circle img-thumbnail p-3" style="font-size: 40px;"></i>
                    </div>
                    <h5 class="font-size-16 mb-1"><a href="#" class="text-dark">{{$category->name}} ({{$category->mediaType}})</a></h5>
                    <p class="text-muted mb-2">{{$category->description}}</p>

                </div>

                <div class="btn-group" role="group">
                <a class="w-100" href="{{route('subcategories', $category->id)}}">
                    <button type="button" class="btn btn-outline-light text-truncate  py-3 w-100">
                        
                            <i class="far fa-eye me-1"></i>
                            View Subcategories
                        
                    </button>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <!-- end row -->

    <!-- Modal Dialog For Add or Edit Category -->

    <div id="category_edit_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="categoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{route('categories/add')}}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="category_modal_title">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <input class="form-control" type="text" value="" id="editMode" name="editMode" hidden>
                    <input class="form-control" type="text" value="" id="category_id" name="category_id" hidden>

                    <div class="mb-2 row">
                        <label for="icon_classname" class="col-md-3 col-form-label">Name</label>
                        <div class="col-md-9">
                            <input class="form-control" type="text" value="" id="name" name="name" placeholder="Sound Effect" required>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="icon_classname" class="col-md-3 col-form-label">Icon Class</label>
                        <div class="col-md-9">
                            <input class="form-control" type="text" value="" id="icon_classname" name="icon_classname" placeholder="fas fa-image" required>
                        </div>
                        <p class="m-1 text-info text-end small">Note: You can find class name in <a target="_blank" href="{{url('admin-fonts')}}"  class="text-danger" style="cursor:pointer;">Admin fonts</a> page.</p>
                    </div>
                    <div class="mb-2 row">
                        <label for="mediaType" class="col-md-3 col-form-label">Media Type</label>
                        <div class="col-md-9">
                            <select class="form-select" id="mediaType" name="mediaType">
                                <option selected>Video</option>
                                <option>Image</option>
                                <option>Audio</option>
                            </select>
                        </div>
                    </div>
                    <div id="resolution_section" class="mb-2 row" style="display:none">
                        <label for="icon_classname" class="col-md-3 col-form-label">Resolution</label>
                        <div class="col-md-4">
                            <input class="form-control" type="text" value="" id="resolution_width" name="resolution_width" placeholder="3000" required>
                        </div>
                        <label for="resolution" class="col-md-1 col-form-label"> X </label>
                        <div class="col-md-4">
                            <input class="form-control" type="text" value="" id="resolution_height" name="resolution_height" placeholder="3000" required>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="description" class="col-md-3 col-form-label">Description</label>
                        <div class="col-md-9">
                            <input class="form-control" type="text" value="" id="description" name="description" placeholder="Short Description for Category.">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
                </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    
    <div class="modal fade" id="removeCategoryModal" tabindex="-1" role="dialog" aria-labelledby="deleteCategoryLabel" aria-hidden="true">
        <form action="{{route('categories/destroy')}}" method="POST">
        @csrf
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content p-4">
                <div class="modal-body text-center">
                    <input id="remove_category_id" name="remove_category_id" hidden>
                    <h3 class="mb-3">{{ __('translation.Please_Confirm') }}</h3>
                    <p class="mb-5 font-size-18">{{__('translation.Delete_Category_Confirm')}}</p>
                    <button type="button" class="btn btn-secondary me-2 col-md-5 pull-left" data-bs-dismiss="modal">{{__('translation.Close')}}</button>
                    <button type="submit" class="btn btn-danger col-md-5 pull-right">{{__('translation.Delete')}}</button>
                </div>
            </div>
        </div>
        </form>
    </div>
    
@endsection

@section('script')
    <script>
        $(".edit_category").click(function(){
            $("#category_modal_title").html('Edit Category');
            var id = $(this).attr('data-id');
            // Get Content from Ajax
            var param = {
                id : id,
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
                    console.log('Result:', result);
                    $("#category_id").val(id);
                    $("#icon_classname").val(result['className']);
                    $("#mediaType").val(result['mediaType']);
                    $("#name").val(result['name']);
                    $("#resolution_width").val(result['width'] == 0 ? '' : result['width']);
                    $("#resolution_height").val(result['height'] == 0 ? '' : result['height']);

                    if(result['mediaType'] == "Image")
                    {
                        $("#resolution_section").show();
                        $("#resolution_width").prop("required", true);
                        $("#resolution_height").prop("required", true);
                    }
                    else{
                        $("#resolution_section").hide();
                        $("#resolution_width").prop("required", false);
                        $("#resolution_height").prop("required", false);
                    }

                    $("#name").prop("disabled", true);
                    $("#description").val(result['description']);
                },
            });
            // ====================
            $("#editMode").val('edit');
            $("#category_edit_modal").modal('show');
            console.log('Edit Category');
        })
        $(".remove_category").click(function(){
            console.log('Remove Category');
            var category_id = $(this).attr('data-id');
            $("#remove_category_id").val(category_id);
            $("#removeCategoryModal").modal('show');
        })

        $("#add_cateogry").click(function(){
            $("#category_modal_title").html('Add Category');
            $("#editMode").val('add');
            $("#icon_classname").val('');
            $("#name").val('');
            $("#name").prop("disabled", false);

            $("#description").val('');

            if($("#mediaType").val() == "Image")
            {
                $("#resolution_section").show();
                $("#resolution_width").prop("required", true);
                $("#resolution_height").prop("required", true);
            }
            else{
                $("#resolution_section").hide();
                $("#resolution_width").prop("required", false);
                $("#resolution_height").prop("required", false);
            }

            $("#category_edit_modal").modal('show');
            console.log('Edit Category');
        })
        
        $("#mediaType").click(function(){
            if($(this).val() == "Image") {
                $("#resolution_section").show();
                $("#resolution_width").prop("required", true);
                $("#resolution_height").prop("required", true);
            } else {
                $("#resolution_section").hide();
                $("#resolution_width").prop("required", false);
                $("#resolution_height").prop("required", false);
            }
        })
    </script>
@endsection
