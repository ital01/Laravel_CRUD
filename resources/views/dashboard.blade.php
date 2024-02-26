<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body class="bg-light">

    @include('layouts.navigation')
    
<header class="container">
    <div class="row justify-content-center">

            @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                class="alert alert-success alert-dismissible fade show my-2 w-50" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            
            @if (session('error'))
            <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                class="alert alert-danger alert-dismissible fade show my-2 w-50" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            
            <div class="card o-hidden border-0 shadow-lg my-2 w-75">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="">
                                <div class="row">
                                    <div class="col-md-6 container d-flex align-items-center justify-content-center">
                                        <div class="w-75">
                                            <h3>Adicionar usuário</h3>
                                            <form id="form" action="/enviar-form" method="POST" class="py-2">
                                                @csrf
                                                <div class="py-2">
                                                    <label for="nome" class="form-label fs-5">Nome</label>
                                                    <input type="text" id="nome" name="nome" class="form-control" required>
                                                </div>
                                                <div class="py-2">
                                                    <label for="email" class="form-label fs-5">Email</label>
                                                    <input type="email" id="email" name="email" class="form-control" required>
                                                </div>
                                                <div class="py-3">
                                                    <button type="submit" class="btn btn-primary">Enviar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-md-6 container d-flex align-items-center justify-content-center">
                                        <div class="w-75">
                                            <h3>Editar usuário pelo ID</h3>
                                            <form action="" method="GET" class="py-1">
                                                <div class="input-group">
                                                    <input type="number" name="search_ID" class="form-control" placeholder="Pesquisar por ID" oninput="validity.valid||(value='');" min="0">
                                                    <button type="submit" class="btn btn-primary">Buscar</button>
                                                </div>
                                            </form>
                                            <form id="form-atualizar" action="" method="POST">
                                                @csrf
                                                @method('POST')
                                                <div class="mb-3">
                                                    <label for="nome" class="form-label fs-5">Nome</label>
                                                    <input name="nome" class="form-control" id="nome" value="">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="email" class="form-label fs-5">Email</label>
                                                    <input name="email" class="form-control" id="email" value="">
                                                </div>
                                                <button type="submit" class="btn btn-primary editar-btn">Editar</button>
                                            </form>
                                        </div>
                                    </div>
                                    
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="px-5 mb-3">
                    <h3>Pesquisa</h3>
                    <form action="" method="GET" class="py-1" id="form-search">
                        <div class="input-group">
                            <input type="text" id="search" name="search" class="form-control" placeholder="Pesquisar por ID, Nome ou Email">
                            <button type="submit" class="btn btn-primary">Buscar</button>
                        </div>
                    </form>
                </div>
            </div>

    </div>
</header>

<section class="container p-1" id="tabela">

    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col" class="bg-dark text-white fs-5">ID</th>
                <th scope="col" class="bg-dark text-white fs-5">Nome</th>
                <th scope="col" class="bg-dark text-white fs-5">Email</th>
                <th scope="col" class="text-center bg-dark text-white fs-5">Excluir</th>
            </tr>
        </thead>
        <tbody id="tabela-usuarios">
        </tbody>
    </table>
    <script>
        function carregarUsuarios() {
            fetch('/dashboard/usuarios-json')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('tabela-usuarios').innerHTML = '';

                    data.usuarios.forEach(function(usuario) {
                        var tr = document.createElement('tr');

                        var tdId = document.createElement('td');
                        tdId.textContent = usuario.id;
                        tr.appendChild(tdId);

                        var tdNome = document.createElement('td');
                        tdNome.textContent = usuario.nome;
                        tr.appendChild(tdNome);

                        var tdEmail = document.createElement('td');
                        tdEmail.textContent = usuario.email;
                        tr.appendChild(tdEmail);

                        var tdExcluir = document.createElement('td');
                        tdExcluir.classList.add('text-center');
                        var form = document.createElement('form');
                        form.setAttribute('action', '/excluir/' + usuario.id);
                        form.setAttribute('method', 'POST');

                        var csrfToken = document.createElement('input');
                        csrfToken.setAttribute('type', 'hidden');
                        csrfToken.setAttribute('name', '_token');
                        csrfToken.setAttribute('value', '{{ csrf_token() }}');
                        form.appendChild(csrfToken);

                        var methodField = document.createElement('input');
                        methodField.setAttribute('type', 'hidden');
                        methodField.setAttribute('name', '_method');
                        methodField.setAttribute('value', 'DELETE');
                        form.appendChild(methodField);

                        var submitBtn = document.createElement('button');
                        submitBtn.setAttribute('type', 'submit');
                        submitBtn.textContent = 'Excluir';
                        submitBtn.classList.add('btn', 'btn-sm', 'btn-danger', 'delete-btn');
                        form.appendChild(submitBtn);

                        tdExcluir.appendChild(form);
                        tr.appendChild(tdExcluir);

                        document.getElementById('tabela-usuarios').appendChild(tr);
                    });
                })
                .catch(error => {
                    console.error('Erro ao carregar usuários:', error);
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            carregarUsuarios();
        });
    </script>

    <br />

    <script>
        function pesquisarUsuarios() {
            var searchTerm = document.getElementById('search').value;

            fetch('/dashboard/usuarios-json?search=' + searchTerm)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('tabela-usuarios').innerHTML = '';

                    data.usuarios.forEach(function(usuario) {
                        var tr = document.createElement('tr');

                        var tdId = document.createElement('td');
                        tdId.textContent = usuario.id;
                        tr.appendChild(tdId);

                        var tdNome = document.createElement('td');
                        tdNome.textContent = usuario.nome;
                        tr.appendChild(tdNome);

                        var tdEmail = document.createElement('td');
                        tdEmail.textContent = usuario.email;
                        tr.appendChild(tdEmail);

                        var tdExcluir = document.createElement('td');
                        tdExcluir.classList.add('text-center');
                        var form = document.createElement('form');
                        form.setAttribute('action', '/excluir/' + usuario.id);
                        form.setAttribute('method', 'POST');

                        var csrfToken = document.createElement('input');
                        csrfToken.setAttribute('type', 'hidden');
                        csrfToken.setAttribute('name', '_token');
                        csrfToken.setAttribute('value', '{{ csrf_token() }}');
                        form.appendChild(csrfToken);

                        var methodField = document.createElement('input');
                        methodField.setAttribute('type', 'hidden');
                        methodField.setAttribute('name', '_method');
                        methodField.setAttribute('value', 'DELETE');
                        form.appendChild(methodField);

                        var submitBtn = document.createElement('button');
                        submitBtn.setAttribute('type', 'submit');
                        submitBtn.textContent = 'Excluir';
                        submitBtn.classList.add('btn', 'btn-sm', 'btn-danger', 'delete-btn');
                        form.appendChild(submitBtn);

                        tdExcluir.appendChild(form);
                        tr.appendChild(tdExcluir);

                        document.getElementById('tabela-usuarios').appendChild(tr);
                    });
                })
                .catch(error => {
                    console.error('Erro ao carregar usuários:', error);
                });
        }

        document.getElementById('form-search').addEventListener('submit', function(event) {
            event.preventDefault();
            pesquisarUsuarios();
        });
    </script>
    

</section>



</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>

</html>
