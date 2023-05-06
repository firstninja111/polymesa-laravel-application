@extends('layouts.master-layouts')
@section('title')
    @lang('translation.Subcategories')
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') Categories @endslot
        @slot('title') Subcategories @endslot
        @slot('sub_title')  @endslot

    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Category Name : {{$parentName}}</h4>
                    <div class="d-flex justify-content-end align-items-center mb-3">
                        <!-- <button type="button" class="btn btn-success waves-effect waves-light me-3" id="add_subcategory">
                            <i class="mdi mdi-plus me-1"></i> Add Subcategory
                        </button> -->

                        <a href="{{url('categories')}}">
                            <button type="button" class="btn btn-danger waves-effect waves-light" id="back_to">
                            <i class="uil-backspace me-1"></i> Back
                            </button>
                        </a>
                    </div>
                    
                    <div class="col-md-6 col-sm-12">
                        <form action="{{route('subcategories/add')}}" method="POST">
                            @csrf
                            <div class="mb-2 row">
                                <div class="col-md-9 mb-2">
                                    <input class="form-control" type="text" value="" id="name" name="name" placeholder="Please input subcategory name to insert." autofocus required>
                                    <input class="form-control" type="text" value="{{$parentID}}" id="parentID" name="parentID" hidden>
                                </div>
                                <div class="col-md-3 mb-2 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-success waves-effect waves-light mb-3" style="width: 100px;">
                                        <i class="mdi mdi-plus me-1"></i> Add
                                    </button>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-editable table-nowrap align-middle table-edits">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($subcategories_fetch as $subcategory)
                                    <tr id="tr_{{$subcategory->id}}">
                                        <td data-field="name">{{$subcategory->name}}</td>
                                        <td style="width: 100px">
                                            <!-- <a class="btn btn-outline-secondary btn-sm edit" title="Edit">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a> -->
                                            <a class="btn btn-outline-danger btn-sm remove" title="Remove" data-id="{{$subcategory->id}}">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

@endsection
@section('script')
    <!-- <script src="{{ URL::asset('public/assets/libs/table-edits/table-edits.min.js') }}"></script> -->
    <!-- <script src="{{ URL::asset('public/assets/js/pages/table-editable.init.js') }}"></script> -->

    <script>
        
        $(document).ready(function() {
            $('.remove').click(function(){
                var id = $(this).attr('data-id');

                Swal.fire({
                    title: "Are you sure?",
                    text: "Do you want to delete selected subcategory?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#34c38f",
                    cancelButtonColor: "#f46a6a",
                    confirmButtonText: "Yes, delete it!"
                }).then(function (result) {
                    if (result.value) {
                        var param = {
                            id : id,
                        };
                        $.ajax({
                            url: "{{URL::to('/subcategories/destroy')}}",
                            type: 'POST',
                            dataType: 'json',
                            contentType: 'application/json',
                            data: JSON.stringify(param),
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (result) {
                                console.log(result);
                                console.log('abc');
                                $("#tr_" + id).remove();
                                Swal.fire("Deleted!", "The subcategory has been deleted.", "success");
                            },
                        });
                        
                    }
                });
            })  

            // $("#add_subcategory").click(function(){
            //     $("#subcategory_add_modal").modal('show');
            // })
        })
        
    </script>
@endsection
