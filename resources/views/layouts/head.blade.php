@yield('css')
<!-- Bootstrap Css -->
<link href="{{ URL::asset('public/assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
<!-- Icons Css -->
<link href="{{ URL::asset('public/assets/css/icons.min.css')}}" id="icons-style" rel="stylesheet" type="text/css" />
<!-- App Css-->
<link href="{{ URL::asset('public/assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />


<link href="{{ URL::asset('public/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />

<link href="{{ URL::asset('public/assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('public/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />

<!-- Style for Media Player List -->
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css"> -->
<link rel='stylesheet' href='https://cdn.plyr.io/3.6.2/plyr.css'>
<!-- ------------------------------ -->

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>