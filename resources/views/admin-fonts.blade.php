@extends('layouts.master-layouts')
@section('title')
    @lang('translation.Admin_Fonts')
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') Icons @endslot
        @slot('title') Admin Font Classes @endslot
        @slot('sub_title')  @endslot

    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Solid</h4>
                    <div class="row icon-demo-content" id="solid">
                    </div>
                </div> <!-- end card-body -->
            </div> <!-- end card -->
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Regular</h4>
                    <div class="row icon-demo-content" id="regular">
                    </div>
                </div> <!-- end card-body -->
            </div> <!-- end card -->
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Brands</h4>
                    <div class="row icon-demo-content" id="brand">
                    </div>
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
    </div> <!-- end row -->

@endsection
@section('script')
    <script src="{{ URL::asset('public/assets/js/pages/fontawesome.init.js') }}"></script>
@endsection
