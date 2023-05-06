<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<link href="{{ asset('public/assets/css/custom.css') }}" rel="stylesheet">

<head>
    @include('layouts.title-meta')
    @include('layouts.head')
</head>

@section('body')
    <body data-layout="horizontal" data-topbar="colored">
    @include('sweet::alert')
    @show

    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('layouts.horizontal')
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <!-- Start content -->
                <div class="container-fluid">

                    @yield('content')
                </div> <!-- content -->
            </div>
            @include('layouts.footer')
        </div>
        <!-- ============================================================== -->
        <!-- End Right content here -->
        <!-- ============================================================== -->
    </div>
    <!-- END wrapper -->

    <!-- Right Sidebar -->
    
    <!-- END Right Sidebar -->

    @include('layouts.vendor-scripts')
</body>

</html>
