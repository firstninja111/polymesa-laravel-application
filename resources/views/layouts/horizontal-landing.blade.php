<header id="page-topbar" style="background: #f5f6f8">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box pe-0">
                <a href="{{url('')}}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ URL::asset('public/assets/images/logo-sm.png') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ URL::asset('public/assets/images/logo-light.png') }}" alt="" height="25">
                    </span>
                </a>

                <a href="{{url('')}}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ URL::asset('public/assets/images/logo-sm.png') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ URL::asset('public/assets/images/logo-dark.png') }}" alt="" height="25">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm ps-3 pe-1 font-size-16 d-lg-none header-item waves-effect waves-light" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content" style="color:#555b6d;">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <!-- App Search-->
            @if(isset($search) && $search == true)
            <form class="app-search d-none d-lg-block ps-4">
                <div class="position-relative">
                    <input type="text" class="form-control" name="key" value="{{$key}}" placeholder="@lang('translation.Search')...">
                    <span class="uil-search"></span>
                </div>
            </form>

            <div class="dropdown d-inline-block d-lg-none ms-2">
                <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="uil-search" style="color: #555b6d"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
                    aria-labelledby="page-header-search-dropdown">
                    
                    <form class="p-3">
                        <div class="form-group m-0">
                            <div class="input-group">
                                <input type="text" class="form-control" name="key" value="{{$key}}" placeholder="@lang('translation.Search')..." aria-label="Recipient's username">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @endif
        </div>

        <div class="d-flex">
            <div class="dropdown d-none d-lg-inline-block language-switch">
                <button type="button" class="btn header-item waves-effect"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:black;">
                    @switch(Session::get('lang'))
                        @case('ru')
                            <img src="{{ URL::asset('public/assets/images/flags/russia.jpg')}}" alt="Header Language" height="16"> <span class="align-middle">Russian</span>
                        @break
                        @case('it')
                            <img src="{{ URL::asset('public/assets/images/flags/italy.jpg')}}" alt="Header Language" height="16"> <span class="align-middle">Italian</span>
                        @break
                        @case('de')
                            <img src="{{ URL::asset('public/assets/images/flags/germany.jpg')}}" alt="Header Language" height="16"> <span class="align-middle">German</span>
                        @break
                        @case('es')
                            <img src="{{ URL::asset('public/assets/images/flags/spain.jpg')}}" alt="Header Language" height="16"> <span class="align-middle">Spanish</span>
                        @break
                        @default
                            <img src="{{ URL::asset('public/assets/images/flags/us.jpg')}}" alt="Header Language" height="16"> <span class="align-middle">English</span>
                    @endswitch
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    
                    <!-- item-->
                    <a href="{{ url('index/en') }}" class="dropdown-item notify-item">
                        <img src="{{ URL::asset('public/assets/images/flags/us.jpg')}}" alt="user-image" class="me-1" height="12"> <span class="align-middle">English</span>
                    </a>

                    <!-- item-->
                    <a href="{{ url('index/es') }}" class="dropdown-item notify-item">
                        <img src="{{ URL::asset('public/assets/images/flags/spain.jpg')}}" alt="user-image" class="me-1" height="12"> <span class="align-middle">Spanish</span>
                    </a>

                    <!-- item-->
                    <a href="{{ url('index/de') }}" class="dropdown-item notify-item">
                        <img src="{{ URL::asset('public/assets/images/flags/germany.jpg')}}" alt="user-image" class="me-1" height="12"> <span class="align-middle">German</span>
                    </a>

                    <!-- item-->
                    <a href="{{ url('index/it') }}" class="dropdown-item notify-item">
                        <img src="{{ URL::asset('public/assets/images/flags/italy.jpg')}}" alt="user-image" class="me-1" height="12"> <span class="align-middle">Italian</span>
                    </a>

                    <!-- item-->
                    <a href="{{ url('index/ru') }}" class="dropdown-item notify-item">
                        <img src="{{ URL::asset('public/assets/images/flags/russia.jpg')}}" alt="user-image" class="me-1" height="12"> <span class="align-middle">Russian</span>
                    </a>
                </div>
            </div>
            
            <a class="d-flex align-items-center" href="{{url('donate')}}" style="color:#495057"><span class="d-inline-block mx-2 fw-bold font-size-16"> Donate </span></a>
            
            
            <div class="d-flex align-items-center">
                <a href="{{url('upload')}}" <button type="button" class="d-inline-block btn btn-success btn-rounded waves-effect waves-light px-4 mx-2"><i class="d-none d-lg-inline-block fas fa-upload me-2"></i>Upload</button> </a>
            </div>

            @Auth            
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{ URL::asset(Auth::user()->avatar) }}"                    
                        alt="Header Avatar">
                        <span class="d-none d-xl-inline-block ms-1 fw-medium font-size-15 text-dark">{{Str::ucfirst(Auth::user()->lastname). ' '. Str::ucfirst(Auth::user()->firstname)}}</span>

                    <i class="uil-angle-down d-none d-xl-inline-block font-size-15 text-dark"></i>
                    
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    @if ( Auth::user()->role == 'admin') 
                        <a class="dropdown-item" href="{{ url('users') }}"><i class="fas fa-home font-size-18 align-middle text-muted me-1"></i> <span class="align-middle">@lang('translation.Dashboard')</span></a>
                    @elseif(Auth::user()->role == 'customer')
                        <a class="dropdown-item" href="{{ url('user-dashboard') }}"><i class="fas fa-home font-size-18 align-middle text-muted me-1"></i> <span class="align-middle">@lang('translation.Dashboard')</span></a>
                    @endif
                    
                    <a class="dropdown-item" href="{{ route('contacts-profile') }}"><i class="uil uil-user-circle font-size-18 align-middle text-muted me-1"></i> <span class="align-middle">@lang('translation.View_Profile')</span></a>
                    <a class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="uil uil-sign-out-alt font-size-18 align-middle me-1 text-muted"></i> <span class="align-middle">@lang('translation.Sign_out')</span></a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
            @endAuth
            @Guest
            <div class="d-flex align-items-center">
                <a href="{{url('login')}}" style="color:#495057"><span class="d-lg-inline-block ms-1 fw-normal font-size-16"> Log in </span></a>
                <span class="d-xl-inline-block border border-1 border-secondary mx-2 py-2"></span>
                <a href="{{url('register')}}" style="color:#495057"><span class="d-lg-inline-block ms-1 fw-normal font-size-16"> Join </span></a>
            </div>
            @endGuest
            
            

            <!-- <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                    <i class="uil-cog"></i>
                </button>
            </div> -->
            
        </div>
    </div>
    <div class="container-fluid">
        <div class="topnav" style="margin: 0px; border-radius: unset">

            <nav class="navbar navbar-light navbar-expand-lg topnav-menu">
    
                <div class="collapse navbar-collapse" id="topnav-menu-content">
                    <ul class="navbar-nav">
                        @foreach($categories as $category)
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('media-search', $category->id)}}">
                                <i class="{{$category->className}} me-2"></i> {{$category->name}}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</header>