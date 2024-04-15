<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <title>{{ ENV('APP_NAME') }} - {{ ENV('APP_LONG_NAME') }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <link rel="shortcut icon" href="{{ asset('template/assets/images/logo.ico') }}">
        <link href="{{ asset('template/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('template/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('template/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />

    </head>

    <body class="authentication-bg authentication-bg-pattern">
        
        <div class="account-pages mt-5 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card">

                            <div class="card-body p-4">
                                
                                <div class="text-center w-75 m-auto">
                                    
                                    <a href="#">
                                        <span><img src="{{ asset('template/assets/images/logo.png') }}" alt="" height="166px"></span>
                                    </a>
                                    
                                </div>

                                <h4 class="auth-title mb-4 mt-3">INICIO DE SESIÓN</h4>

                                <form action="{{ route('login') }}" method="POST">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <label for="emailaddress">Correo Electrónico</label>
                                        <input class="form-control" name="email" type="email" id="emailaddress" required="" placeholder="Ingresa el correo electrónico">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="password">Contraseña</label>
                                        <input class="form-control" name="password" type="password" required="" id="password" placeholder="Ingresa la contraseña">
                                    </div>

                                    <div class="form-group mb-3">
                                        {{-- <div class="custom-control custom-checkbox checkbox-info">
                                            <input type="checkbox" class="custom-control-input" id="checkbox-signin">
                                            <label class="custom-control-label" for="checkbox-signin">Recordar credenciales</label>
                                        </div> --}}
                                    </div>

                                    <div class="form-group mb-0 text-center">
                                        <button class="btn btn-dark btn-block">Ingresar</button>
                                    </div>

                                    <div class="form-group mt-3">
                                        <x-validation-errors class="mb-4 text-danger" />
                                    </div>

                                </form>

                            </div> <!-- end card-body -->

                        </div>
                        <!-- end card -->

                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                
                                <p> <a href="{{ route('password.request') }}" class="text-muted ml-1">Olvidaste tu contraseña?</a></p>
                                
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->


        <footer class="footer footer-alt">
            2024 &copy; {{ ENV('APP_NAME') }} <a href="" class="text-muted">- {{ ENV('APP_LONG_NAME') }}</a> 
        </footer>

        <!-- Vendor js -->
        <script src="{{ asset('template/assets/js/vendor.min.js') }}"></script>

        <!-- App js -->
        <script src="{{ asset('template/assets/js/app.min.js') }}"></script>

    </body>
</html>

{{--<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                Soy Jose Eduardo
            </div>

            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ms-4">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout> --}}
