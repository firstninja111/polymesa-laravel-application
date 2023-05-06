@extends('layouts.master-layouts')
@section('title')
    @lang('translation.Cryptocoins')
@endsection
@section('css')
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') Home @endslot
        @slot('title')  @lang('translation.Cryptocoins') @endslot
        @slot('sub_title')  @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <form action="{{route('cryptos/add')}}" method="POST">
                            @csrf
                            <h4 class="card-title mb-3">Coins</h4>
                            <div class="row">
                                <div class="col-md-9 mb-2">
                                    <input class="form-control" type="text" value="" id="name" name="name" placeholder="Please input crypto name to insert." autofocus required>
                                </div>
                                <div class="col-md-3 mb-2 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-success waves-effect waves-light mb-3" style="width: 100px;">
                                        <i class="mdi mdi-plus me-1"></i> Add
                                    </button>
                                </div>
                            </div>
                            <p class="text-danger font-size-14 text-cente">Don't put blank while you add crypto. Blank will be ignored automatically.</p>

                            </form>
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Crypto Coin</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>


                                <tbody>
                                    @foreach($cryptos_fetch as $crypto)
                                    <tr>
                                        <td>{{$crypto->name}}</td>
                                        <td>
                                            <form action="{{route('cryptos/destroy', $crypto->id)}}" method="POST">
                                            @csrf
                                                <button type="button" class="btn btn-danger px-1 py-0" data-bs-toggle="modal" data-bs-target="#deleteCrypto{{$crypto->id}}"><i class='uil uil-trash-alt font-size-16'></i></button>
                                                <div class="modal fade" id="deleteCrypto{{$crypto->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteAppointmentLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content p-4">
                                                            <div class="modal-body text-center">
                                                                <h3 class="mb-3">{{ __('translation.Please_Confirm') }}</h3>
                                                                <p class="mb-5 font-size-18">{{__('translation.Delete_Crypto_Confirm')}}</p>
                                                                <button type="button" class="btn btn-secondary me-2 col-md-5 pull-left" data-bs-dismiss="modal">{{__('translation.Close')}}</button>
                                                                <button type="submit" class="btn btn-danger col-md-5 pull-right">{{__('translation.Delete')}}</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
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
    <script>
        var table = $('#datatable-buttons').DataTable({
            "columns": [
                { "width": "90%" },
                { "width": "10%" },
            ]
        });
        // table.buttons().container().appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
        // $(".dataTables_length select").addClass('form-select form-select-sm');
    </script>
@endsection
