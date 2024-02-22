<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body class="bg-light">
    
<header class="container">
    @if (Route::has('login'))
        <div class="fixed-top p-4 text-right">
            @auth
            <a href="{{ url('/dashboard') }}" class="font-weight-bold btn btn-outline-dark"
                onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#000'">Dashboard</a>
            @else
            <a href="{{ route('login') }}" class="font-weight-bold btn btn-outline-dark"
                onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#000'">Entrar</a>

            @if (Route::has('register'))
            <a href="{{ route('register') }}" class="ml-4 font-weight-bold btn btn-outline-dark"
                onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#000'">Registrar-se</a>
            @endif
            @endauth
        </div>
    @endif
</header>



</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

</html>