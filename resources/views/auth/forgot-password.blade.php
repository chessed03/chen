
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

                                <h4 class="auth-title mb-4 mt-3">RECUPERAR CONTRASEÑA</h4>

                                @if (session('status'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <div>
                                            <strong><h4 class="text-success">Información:</strong></h4>
                                        </div>
                                        <ul class="mt-1 text-success">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <li>{{ session('status') }}</li>
                                        </ul>
                                    </div>
                                @endif

                                <x-validation-errors class="mb-4"/>

                                <form method="POST" action="{{ route('password.email') }}">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <label for="email">Correo electrónico</label>
                                        <input class="form-control" type="email" name="email" id="email" value="{{ old('email') }}" required="" placeholder="Ingresa tu correo electrónico">
                                    </div>

                                    <div class="form-group mb-0 text-center">
                                        <button class="btn btn-dark btn-block" type="submit"> Recuperar contraseña </button>
                                    </div>

                                </form>    

                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->

                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <p class="text-muted">Regesar a<a href="{{ route('login') }}" class="text-muted ml-1"><b class="font-weight-semibold">Inicio de sesión</b></a></p>
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

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="block">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Email Password Reset Link') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout> --}}
