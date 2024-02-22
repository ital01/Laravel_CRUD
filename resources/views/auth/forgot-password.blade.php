<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Esqueci minha senha</title>

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
                                <div class="p-5 my-auto">
                                    <h1 class="text-justify mb-4 text-black fs-5 lh-sm">Esqueceu sua senha? Sem
                                        problemas!</h1>
                                    <p class="text-justify mb-4 text-black lh-sm"> 
                                        Nos informe seu endereço de
                                        e-mail e enviaremos um link para redefinição
                                        de senha.</p>

                                    @if (session('status'))
                                    <div class="mb-4">
                                        {{ session('status') }}
                                    </div>
                                    @endif

                                    <form method="POST" action="{{ route('password.email') }}">
                                        @csrf

                                        <!-- Endereço de E-mail -->
                                        <div class="form-group">
                                            <label for="email" class="form-label">E-mail</label>
                                            <input id="email" class="form-control" type="email" name="email"
                                                value="{{ old('email') }}" required autofocus>
                                            @if ($errors->has('email'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('email') }}
                                            </div>
                                            @endif
                                        </div>

                                        <div class="text-start mt-4">
                                            <button type="submit" class="btn btn-primary">
                                                Enviar Link
                                            </button>
                                        </div>
                                        <hr>
                                        <div class="mb-3">
                                            <a href="{{ route('login') }}" class="text-decoration-none">{{ __('Fazer
                                                Login') }}</a>
                                        </div>
                                    </form>
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