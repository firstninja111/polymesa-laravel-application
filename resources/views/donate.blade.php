@extends('layouts.master-layouts-landing')
@section('title')
    @lang('translation.Donate')
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') Home @endslot
        @slot('title') @lang('translation.Donate') @endslot
        @slot('sub_title')  @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    This is temporary page.
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

@endsection
