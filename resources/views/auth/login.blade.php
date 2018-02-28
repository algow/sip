<!-- ==========================================
                                                SISTEM INFORMASI PENOLAKAN ============================================ -->
<!-- ==========================================
                                                    Author: ALGO WIJAYA    ============================================ -->
<!-- ==========================================
                                                      KPPN JAKARTA III     ============================================ -->
<!-- ==========================================
                                                     Powered by: LARAVEL   ============================================ -->

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login</title>

    <!-- Styles -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/welcome.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/util.css') }}" rel="stylesheet">
    
</head>
<body class="welcomebody">
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100 p-b-160 p-t-50">
                <form class="login100-form validate-form" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}
                    <span class="login100-form-title">
                        Sistem Informasi Penolakan
                    </span>
                    <div class="wrap-input100 rs1{{ $errors->has('email') ? ' has-error' : '' }}">
                        <input id="email" class="input100" type="text" name="email" value="{{ old('email') }}" required autofocus>
                        <span class="label-input100">Username</span>											
                    </div>
                    <div class="wrap-input100 rs2{{ $errors->has('password') ? ' has-error' : '' }}">
                        <input class="input100" type="password" name="password" required>
                        <span class="label-input100">Password</span>
                    </div>
                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn">
                            Sign in
                        </button>
                    </div>
                    <div class="text-center w-full p-t-23">
                        @if ($errors->has('email'))
                            <span class="alert alert-danger">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                        @if ($errors->has('password'))
                            <span class="alert alert-danger">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                        </br>
                        <a href="{{ route('password.request') }}" class="txt1">
                            Forgot password?
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
