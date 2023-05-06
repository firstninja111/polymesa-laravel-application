@extends('layouts.master-layouts-landing')
@section('title')
    @lang('translation.FAQs')
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row justify-content-center mt-4">
                        <div class="col-lg-5">
                            <div class="text-center">
                                <h5>Can't find what you are looking for?</h5>
                                <p class="text-muted">If several languages coalesce, the grammar of the resulting language
                                    is more simple and regular than that of the individual</p>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-xl-3 col-sm-5 mx-auto">
                            <div>
                            <p><a href="{{url('faqs')}}" class="my-2 font-size-16 inactive-sidebar">FAQ</a></p>
                                <p><a href="{{url('license')}}" class="my-2 font-size-16 inactive-sidebar">License</a></p>
                                <p><a href="{{url('termsOfService')}}" class="my-2 font-size-16 inactive-sidebar">Terms of Service</a></p>
                                <p><a href="{{url('privacyPolicy')}}" class="my-2 font-size-16 inactive-sidebar">Privacy Policy</a></p>
                                <p><a href="{{url('cookiesPolicy')}}" class="my-2 font-size-16 inactive-sidebar">Cookies Policy</a></p>
                                <p><a href="{{url('aboutUs')}}" class="my-2 font-size-16">About Us</a></p>
                                <p><a href="{{url('forum')}}" class="my-2 font-size-16 inactive-sidebar">Forum</a></p>
                            </div>
                        </div>

                        <div class="col-xl-8">
                            This is About US page.
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

@endsection
