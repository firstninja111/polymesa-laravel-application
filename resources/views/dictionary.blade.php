@extends('layouts.master-layouts')
@section('title')
    {{$title}}
@endsection
@section('css')
    <!-- DataTables -->
    <!-- <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" /> -->
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') Tag @endslot
        @slot('title') {{$title}} @endslot
        @slot('sub_title')  @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead id="thead">
                                    <tr>
                                        <th class="border-0 bg-info bg-gradient">&nbsp;</th>
                                        <th class="border-0 bg-info bg-gradient">&nbsp;</th>
                                        <th class="border-0 bg-info bg-gradient">&nbsp;</th>
                                        <th class="border-0 bg-info bg-gradient">&nbsp;</th>
                                        <th class="border-0 bg-info bg-gradient">&nbsp;</th>
                                        <th class="border-0 bg-info bg-gradient">&nbsp;</th>
                                        <th class="border-0 bg-info bg-gradient">&nbsp;</th>
                                        <th class="border-0 bg-info bg-gradient">&nbsp;</th>
                                        <th class="border-0 bg-info bg-gradient">&nbsp;</th>
                                        <th class="border-0 bg-info bg-gradient">&nbsp;</th>
                                    </tr>
                                </thead>


                                <tbody id="tbody">
                                    @for($i = 0; $i < count($dictionary) / 10 + 1; $i++)
                                    <tr>
                                        @for($j = 0; $j < 10; $j++)
                                            @if($i * 10 + $j >= count($dictionary))    
                                                <td></td>
                                            @else
                                                <td>{{$dictionary[$i * 10 + $j]->key_phrase}}</td>
                                            @endif
                                        @endfor
                                    </tr>
                                    @endfor
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
    <!-- <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script> -->

    <script>
        $(document).ready(function(){
            var table = $('#datatable-buttons').DataTable({
                buttons: ['excel', 'pdf'],
                "columnDefs": [
                    { "orderable": false, "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9] },
                ],
                "aaSorting": []
            });
            table.buttons().container().appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
            $(".dataTables_length select").addClass('form-select form-select-sm');
        });
    </script>
@endsection
