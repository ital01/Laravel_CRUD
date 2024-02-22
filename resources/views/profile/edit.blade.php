<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    @include('layouts.navigation')
    <div class="container py-4 d-flex justify-content-center">
        <div class="w-75">
            <h1 class="font-semibold text-xl mb-4">
                Atualizar informações
            </h1>
    
            <div class="row row-cols-1 row-cols-md-2 g-4">
                <div class="col">
                    <div class="p-4 bg-white shadow rounded-lg">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
    
                <div class="col">
                    <div class="p-4 bg-white shadow rounded-lg">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>
            <br>
    
            <div class="p-4 bg-white shadow rounded-lg">
                @include('profile.partials.delete-user-form')
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