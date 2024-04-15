
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

                                <x-validation-errors class="mb-4" />

                                <form method="POST" action="{{ route('password.update') }}">
                                    @csrf
                                    
                                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                                    <div class="form-group mb-3">
                                        <label for="email">Correo electrónico</label>
                                        <input class="form-control" type="email" name="email" id="email" value="{{ $request->email }}" required="" placeholder="Ingresa tu correo electrónico">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="password">Contraseña</label>
                                        <input class="form-control" type="password" name="password" id="password" required="" placeholder="Ingresa tu nueva contraseña">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="password_confirmation">Repetir contraseña</label>
                                        <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" required="" placeholder="Repite la contraseña ingresada">
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

{{-- <x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="block">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Reset Password') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout> --}}
