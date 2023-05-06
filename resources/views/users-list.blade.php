@extends('layouts.master-layouts')
@section('title')
    @lang('translation.Users')
@endsection
@section('css')
    <!-- DataTables -->

    
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') Home @endslot
        @slot('title') User List @endslot
        @slot('sub_title') @endslot

    @endcomponent

    <div class="d-flex justify-content-end">
        <a href="{{url('users/add')}}">
            <button type="button" class="btn btn-success waves-effect waves-light mb-3">
                <i class="mdi mdi-plus me-1"></i> Add User
            </button>
        </a>
    </div>

    <div class="row">
        <div class="col-lg-12">

            <div class="table-responsive mb-4">
                <table class="table table-centered datatable dt-responsive nowrap table-card-list"
                    style="border-collapse: collapse; border-spacing: 0 12px; width: 100%;">
                    <thead>
                        <tr class="bg-transparent">
                            <th>No.</th>
                            <th>Userame</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Uploaded<br> Media</th>
                            <th>Status</th>
                            <th>Register Date</th>
                            <th style="width: 120px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $index = 0; foreach ($users_fetch as $user) {  $index++;?>
                        <tr>
                            <td>
                                {{ $index }}
                            </td>
                            <td>
                                <a href="javascript: void(0);" class="text-dark fw-bold">
                                    <img src="{{asset($user->avatar)}}" alt="" class="avatar-xs rounded-circle me-2">{{ $user->username }}
                                </a> 
                            </td>
                            <td>
                                {{ $user->lastname. ' '. $user->firstname }}
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                {{ $user->uploaded }}
                            </td>
                            <td>
                                @if($user->status == 'active')
                                    <button type="button" class="btn btn-success btn-rounded waves-effect waves-light" data-status="active" onclick="toogleActive(this)" data-id = "{{$user->id}}">Active</button>
                                @else
                                    <button type="button" class="btn btn-secondary btn-rounded waves-effect waves-light" data-status="deactive" onclick="toogleActive(this)" data-id = "{{$user->id}}">Dective</button>
                                @endif
                            </td>
                            <td>
                                {{ date('m/d/Y', strtotime($user->created_at)) }}
                            </td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{route('users/edit', $user->id)}}" class="px-3 text-primary user-edit"><i
                                            class="uil uil-pen font-size-18"></i></a>
                                    <form action="{{route('users/destroy', $user->id)}}" method="POST">
                                        @csrf
                                        <a class="px-3 text-danger" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#deleteUser{{$user->id}}"><i class="uil uil-trash-alt font-size-18"></i></a>

                                        <!-- <button type="button" class="btn btn-danger px-1 py-0" data-bs-toggle="modal" data-bs-target="#deleteUser{{$user->id}}"><i class='uil uil-trash-alt font-size-16'></i></button> -->
                                        <div class="modal fade" id="deleteUser{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteUser" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content p-4">
                                                    <div class="modal-body text-center">
                                                        <h3 class="mb-3">{{ __('translation.Please_Confirm') }}</h3>
                                                        <p class="mb-5 font-size-18">{{__('translation.Delete_User_Confirm')}}</p>
                                                        <button type="button" class="btn btn-secondary me-2 col-md-5 pull-left" data-bs-dismiss="modal">{{__('translation.Close')}}</button>
                                                        <button type="submit" class="btn btn-danger col-md-5 pull-right">{{__('translation.Delete')}}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- end row -->

@endsection
@section('script')

    <script>
        var table;
        $(document).ready(function() {
            table = $('.datatable').DataTable();
            $(".dataTables_length select").addClass('form-select form-select-sm');
        });
        function toogleActive(obj){
            var jobj = $(obj);
            var status = jobj.attr('data-status');
            var id = jobj.attr('data-id');
            var param = {
                id : id,
                status : (status == 'active' ? 'deactive' : 'active'),
            };
            $.ajax({
                url: "{{URL::to('/users/changeStatus')}}",
                type: 'POST',
                dataType: 'json',
                contentType: 'application/json',
                data: JSON.stringify(param),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (result) {
                    if(status == 'active'){
                        jobj.html('Deactive');
                        jobj.attr('data-status', 'Deactive');
                        jobj.removeClass('btn-success');
                        jobj.addClass('btn-secondary');
                    }
                    else{
                        jobj.html('Active');
                        jobj.attr('data-status', 'active');
                        jobj.removeClass('btn-secondary');
                        jobj.addClass('btn-success');
                    }
                },
            });
        }

        // function removeUser(obj) {
        //     var jBtn = $(obj);
        //     console.log($(obj).parent());
        //     Swal.fire({
        //         title: "Are you sure?",
        //         text: "Do you want to delete selected user?",
        //         icon: "warning",
        //         showCancelButton: true,
        //         confirmButtonColor: "#34c38f",
        //         cancelButtonColor: "#f46a6a",
        //         confirmButtonText: "Yes, delete it!"
        //     }).then(function (result) {
        //         if (result.value) {
                    
        //             // jBtn.parents('tr').remove().draw();
        //             // console.log( jBtn.parents('tr'));
        //             // table
        //             //     .row( jBtn.parents('tr') )
        //             //     .remove()
        //             //     .draw();

        //             // table.rows({ search: 'applied' }).iterator( 'row', function ( context, index ) {
        //             //     $(this.cell(index, 0).nodes()).html(index + 1);
        //             // });
        //             Swal.fire("Deleted!", "The user has been deleted.", "success");
        //         }
        //     });
        // }
    </script>
@endsection
