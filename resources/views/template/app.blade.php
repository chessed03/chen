<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <title>{{ ENV('APP_NAME') }} - {{ ENV('APP_LONG_NAME') }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token_UWl0eGVuTg==" content="{{ csrf_token() }}" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        @include('template.appheader')

    </head>

    <body class="left-side-menu-light">

        <div id="preloader">
            <div id="status">
                <div class="spinner-border avatar-lg text-primary m-2" role="status"></div>
                <br>
                <div class="d-flex align-items-center"><strong>Cargando...</strong></div>
            </div>
        </div>

        <div id="wrapper">

            <div class="navbar-custom">
                <ul class="list-unstyled topnav-menu float-right mb-0">
        
                    <li class="dropdown notification-list">
                        <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <img src="{{ asset('template/assets/images/users/user-1.jpg') }}" alt="user-image" class="rounded-circle">
                            <span class="pro-user-name ml-1">
                                {{ Auth::user()->name }} <i class="mdi mdi-chevron-down"></i> 
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                            <!-- item-->
                            <div class="dropdown-item noti-title">
                                <h5 class="m-0 text-white">
                                    Bienvenido !
                                </h5>
                            </div>

                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <a href="{{ route('logout') }}" @click.prevent="$root.submit();" class="dropdown-item notify-item" style="border: none;">
                                    <i class="fe-log-out"></i> Salir
                                </a>
                            </form>

                        </div>
                    </li>

                </ul>

                <!-- LOGO -->
                <div class="logo-box" style="background: white !important">
                    <a href="#" class="logo text-center">
                        <span class="logo-lg text-center">
                            <img src="{{ asset('template/assets/images/logo.png') }}" alt="" height="50">&nbsp;&nbsp;
                            <h4 class="text-dark" style="display: inline-block; vertical-align: middle;"><strong>{{ ENV('APP_NAME') }}</strong></h4>
                        </span>
                        <span class="logo-sm">
                            <img src="{{ asset('template/assets/images/logo.png') }}" alt="" height="50">
                        </span>
                    </a>
                </div>

                <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
                    <li>
                        <button class="button-menu-mobile waves-effect">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>
                    </li>
                </ul>
            </div>

            @include('template.appsidebar')

            <div class="content-page">

                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">
                        
                        @yield('content')
                        
                    </div> <!-- container -->

                </div>

                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                2024 &copy; {{ ENV('APP_NAME') }} <a href="">{{ ENV('APP_LONG_NAME') }}</a> 
                            </div>
                            <div class="col-md-6">
                                <div class="text-md-right footer-links d-none d-sm-block">
                                    <a href="javascript:void(0);">Ayuda</a>
                                    <a href="javascript:void(0);">Contactanos</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>

            </div>

        </div>

        @include('template.appfooter')

    </body>
</html>
