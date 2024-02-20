<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Confirmar Senha</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

</head>

<body class="bg-gradient-primary d-flex align-items-center justify-content-center">

    <div class="container w-75">

        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9 w-50">

                <div class="card o-hidden border-0 shadow-lg my-5 ">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5 my-auto">
                                    <h1 class="text-justify mb-4 text-black fs-5 lh-sm">Segurança</h1>
                                    <p class="text-justify mb-4 text-black lh-sm">Por favor, confirme sua senha antes de
                                        continuar.</p>
                                    <form method="POST" action="{{ route('password.confirm') }}">
                                        @csrf

                                        <!-- Password -->
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Senha</label>
                                            <input id="password" class="form-control" type="password" name="password"
                                                required autocomplete="current-password">
                                            @if ($errors->has('password'))
                                            <div class="text-danger">
                                                {{ $errors->first('password') }}
                                            </div>
                                            @endif
                                        </div>

                                        <div class="text-start">
                                            <button type="submit" class="btn btn-primary">
                                                Confirmar
                                            </button>
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