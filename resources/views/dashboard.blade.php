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
                class="alert alert-success alert-dismissible fade show my-2" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            
            @if (session('error'))
            <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                class="alert alert-danger alert-dismissible fade show my-2" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            

            <div class="card o-hidden border-0 shadow-lg my-2 w-75">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-md-6 container d-flex align-items-center justify-content-center">
                                        <div class="w-75">
                                            <h3>Adicionar usuário</h3>
                                            <form id="form" action="/enviar-form" method="POST" class="py-2">
                                                @csrf
                                                <div class="py-2">
                                                    <label for="nome" class="form-label fs-5 py-1">Nome</label>
                                                    <input type="text" id="nome" name="nome" class="form-control" required>
                                                </div>
                                                <div class="py-2">
                                                    <label for="email" class="form-label fs-5 py-1">Email</label>
                                                    <input type="email" id="email" name="email" class="form-control mb-2" required>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Enviar</button>
                                            </form>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 container d-flex align-items-center justify-content-center">
                                        <div class="w-75">
                                            <h3>Editar usuário pelo ID</h3>
                                            <form action="{{ route('dashboard.search') }}" method="GET" class="py-2">
                                                <div class="input-group">
                                                    <input type="number" name="search_ID" class="form-control" placeholder="Pesquisar por ID" oninput="validity.valid||(value='');" min="0">
                                                    <button type="submit" class="btn btn-primary">Buscar</button>
                                                </div>
                                            </form>
                                        @foreach($usuarios as $usuario)
                                            <form id="form-editar" action="{{ route('atualizar', ['id' => $usuario->id]) }}" method="POST" class="py-2">
                                        @endforeach       
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-1">
                                                    <label for="nome_editar" class="form-label fs-5">Nome</label>
                                                    <input name="nome" class="form-control" id="nome_editar" value="{{ $usuario->nome }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="email_editar" class="form-label fs-5">Email</label>
                                                    <input name="email" class="form-control" id="email_editar" value="{{ $usuario->email }}">
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
                    <form action="{{ route('search') }}" method="GET" class="py-1">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control"
                                placeholder="Pesquisar por ID, Nome ou Email">
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

        <tbody id="usuarios-body">
            <!-- Aqui serão inseridos os usuários dinamicamente via JavaScript -->
        </tbody>
    </table>

    <div class="text-center" id="pagination"></div>

</section>

<script>
    // Função para fazer uma requisição HTTP GET
    function fetchData(url, callback) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    callback(null, JSON.parse(xhr.responseText));
                } else {
                    callback(xhr.status);
                }
            }
        };
        xhr.open('GET', url, true);
        xhr.send();
    }

    // Função para exibir os usuários na tabela
    function displayUsers(users) {
        var tbody = document.getElementById('usuarios-body');
        tbody.innerHTML = '';

        users.forEach(function (user) {
            var tr = document.createElement('tr');

            var tdId = document.createElement('td');
            tdId.textContent = user.id;
            tr.appendChild(tdId);

            var tdNome = document.createElement('td');
            tdNome.textContent = user.nome;
            tr.appendChild(tdNome);

            var tdEmail = document.createElement('td');
            tdEmail.textContent = user.email;
            tr.appendChild(tdEmail);

            var tdExcluir = document.createElement('td');
            tdExcluir.setAttribute('class', 'text-center');
            var form = document.createElement('form');
            form.setAttribute('action', '/dashboard/excluir/{id}');
            form.setAttribute('method', 'POST');
            form.setAttribute('class', 'delete-form');
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
            var deleteButton = document.createElement('button');
            deleteButton.setAttribute('type', 'submit');
            deleteButton.setAttribute('class', 'btn btn-sm btn-danger delete-btn');
            deleteButton.textContent = 'Excluir';
            form.appendChild(deleteButton);
            tdExcluir.appendChild(form);
            tr.appendChild(tdExcluir);

            tbody.appendChild(tr);
        });
    }

    // Função para exibir a paginação
    function displayPagination(pagination) {
        var paginationDiv = document.getElementById('pagination');
        paginationDiv.innerHTML = ''; // Limpa o conteúdo anterior

        if (pagination.prev_page_url) {
            var prevButton = document.createElement('a');
            prevButton.setAttribute('href', pagination.prev_page_url + '#tabela');
            prevButton.setAttribute('class', 'btn btn-primary');
            prevButton.textContent = 'Página Anterior';
            paginationDiv.appendChild(prevButton);
        } else {
            paginationDiv.innerHTML += '<span class="btn btn-secondary disabled">Página Anterior</span>';
        }

        if (pagination.next_page_url) {
            var nextButton = document.createElement('a');
            nextButton.setAttribute('href', pagination.next_page_url + '#tabela');
            nextButton.setAttribute('class', 'btn btn-primary');
            nextButton.textContent = 'Próxima Página';
            paginationDiv.appendChild(nextButton);
        } else {
            paginationDiv.innerHTML += '<span class="btn btn-secondary disabled">Próxima Página</span>';
        }
    }

    // Adiciona um evento de escuta para o formulário de exclusão
    document.addEventListener('submit', function (event) {
        if (event.target.matches('.delete-form')) {
            event.preventDefault(); // Previne o envio do formulário
            var form = event.target;
            var url = form.getAttribute('action');
            var method = form.getAttribute('method');
            fetch(url, { method: method })
                .then(response => {
                    if (response.ok) {
                        fetchData('/dashboard', function (error, data) {
                            if (error) {
                                console.error('Ocorreu um erro ao buscar os usuários:', error);
                            } else {
                                displayUsers(data.usuarios);
                                displayPagination(data.usuarios);
                            }
                        });
                    } else {
                        console.error('Ocorreu um erro ao excluir o usuário:', response.status);
                    }
                })
                .catch(error => console.error('Ocorreu um erro ao excluir o usuário:', error));
        }
    });

    // Quando a página é carregada, buscar os usuários e exibi-los
    window.onload = function () {
        fetchData('/dashboard/usuarios-json', function (error, data) {
            if (error) {
                console.error('Ocorreu um erro ao buscar os usuários:', error);
            } else {
                console.log('Usuários obtidos com sucesso:', data.usuarios);
                displayUsers(data.usuarios);
                displayPagination(data.usuarios);
            }
        });
    };
</script>





</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>

</html>