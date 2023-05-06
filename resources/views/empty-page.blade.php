@extends('layouts.master-layouts')
@section('title')
    @lang('translation.Dashboard')
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') Home @endslot
        @slot('title') @lang('translation.Dashboard') @endslot
        @slot('sub_title')  @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

@endsection
