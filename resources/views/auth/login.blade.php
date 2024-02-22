<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

</head>

<body class="bg-gradient-primary d-flex align-items-center justify-content-center">

    <div class="container w-50">

        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9 w-50">

                <div class="card o-hidden border-0 shadow-lg my-5 ">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="py-4 px-5 my-auto">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4 fs-2">Bem-vindo de volta!</h1>
                                    </div>
                                    <form method="POST" action="{{ route('login') }}" class="user">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="email" class="form-label">{{ __('Email') }}</label>
                                            <input id="email" type="email" class="form-control form-control-user"
                                                name="email" :value="old('email')" required autofocus
                                                autocomplete="username">
                                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                        </div>
                                        <div class="mb-3">
                                            <label for="password" class="form-label">{{ __('Senha') }}</label>
                                            <input id="password" type="password" class="form-control form-control-user"
                                                name="password" required autocomplete="current-password">
                                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                        </div>
                                        <div class="mb-3 form-check">
                                            <input id="remember_me" type="checkbox" class="form-check-input border-dark"
                                                name="remember">
                                            <label for="remember_me" class="form-check-label">{{ __('Lembrar de mim')
                                                }}</label>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">{{ __('Entrar')
                                            }}</button>
                                        <hr>
                                        <div class="text-center py-1">
                                            <a class="text-decoration-none"
                                                href="{{ route('password.request') }}">Esqueceu a
                                                senha?</a>
                                        </div>
                                        <div class="text-center py-1">
                                            <a class="text-decoration-none" href="{{ route('register') }}">Criar uma
                                                conta!</a>
                                        </div>
                                    </form>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

</body>

</html>