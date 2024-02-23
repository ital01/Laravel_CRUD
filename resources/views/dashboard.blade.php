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
            <div class="col-md-6">
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
                
    
                <div class="card o-hidden border-0 shadow-lg my-2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="py-4 px-5">
                                    <form id="form" action="/enviar-form" method="POST" class="mb-4">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="nome" class="form-label fs-5">NOME</label>
                                            <input type="text" id="nome" name="nome" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label fs-5">EMAIL</label>
                                            <input type="email" id="email" name="email" class="form-control" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">ENVIAR</button>
                                    </form>
                                    <hr>
                                    <h3>Pesquisa</h3>
                                    <form action="{{ route('search') }}" method="GET" class="mb-4 py-1">
                                        <div class="input-group">
                                            <input type="text" name="search" class="form-control"
                                                   placeholder="Pesquisa por ID, Nome, ou Email">
                                            <button type="submit" class="btn btn-primary">PROCURAR</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
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
                    <th scope="col" class="text-center bg-dark text-white fs-5">Editar</th>
                    <th scope="col" class="text-center bg-dark text-white fs-5">Excluir</th>
                </tr>
            </thead>

            <tbody>
                @foreach($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->id }}</td>
                    <td class="editable" data-field="nome" data-id="{{ $usuario->id }}">{{ $usuario->nome }}</td>
                    <td class="editable" data-field="email" data-id="{{ $usuario->id }}">{{ $usuario->email }}</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-info editar-btn" data-id="{{ $usuario->id }}">Editar</button>
                    </td>
                    <td class="text-center">
                        <form id="form-excluir-{{ $usuario->id }}" action="{{ route('excluir', ['id' => $usuario->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger delete-btn">Excluir</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-center">
            @if ($usuarios->onFirstPage())
            <span class="btn btn-secondary disabled">Primeira Página</span>
            @else
            <a href="{{ $usuarios->url(1) }}#tabela" class="btn btn-primary">Primeira Página</a>
            @endif

            @if ($usuarios->previousPageUrl())
            <a href="{{ $usuarios->previousPageUrl() }}#tabela" class="btn btn-primary">{{ $usuarios->currentPage() - 1
                }}</a>
            @else
            <span class="btn btn-secondary disabled">Página Anterior</span>
            @endif

            @if ($usuarios->nextPageUrl())
            <a href="{{ $usuarios->nextPageUrl() }}#tabela" class="btn btn-primary">{{ $usuarios->currentPage() + 1
                }}</a>
            @else
            <span class="btn btn-secondary disabled">Próxima Página</span>
            @endif

            @if ($usuarios->hasMorePages())
            <a href="{{ $usuarios->url($usuarios->lastPage()) }}#tabela" class="btn btn-primary">Última Página</a>
            @else
            <span class="btn btn-secondary disabled">Última Página</span>
            @endif
        </div>



        <br />

        <form id="form-atualizar" action="" method="POST" style="display: none;">
            @csrf
            @method('POST')
            <input type="hidden" name="nome" id="nome">
            <input type="hidden" name="email" id="email">
        </form>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const editarButtons = document.querySelectorAll('.editar-btn');

                editarButtons.forEach(button => {
                    button.addEventListener('click', function () {
                        const otherEditButtons = document.querySelectorAll('.editar-btn:not([data-id="' + this.getAttribute('data-id') + '"])');
                        otherEditButtons.forEach(btn => btn.disabled = true);

                        const otherDeleteButtons = document.querySelectorAll('.delete-btn:not([data-id="' + this.getAttribute('data-id') + '"])');
                        otherDeleteButtons.forEach(btn => btn.disabled = true);

                        const id = this.getAttribute('data-id');
                        const fields = document.querySelectorAll(`.editable[data-id="${id}"]`);

                        fields.forEach(field => {
                            if (field.getAttribute('contenteditable') === 'true') {
                                field.setAttribute('contenteditable', 'false');
                                field.classList.remove('editable-active');
                                this.innerText = 'Editar';

                                const nome = document.querySelector(`.editable[data-field="nome"][data-id="${id}"]`).innerText;
                                const email = document.querySelector(`.editable[data-field="email"][data-id="${id}"]`).innerText;

                                window.location.href = `dashboard/atualizar/${id}?nome=${nome}&email=${email}`;
                            } else {
                                field.setAttribute('contenteditable', 'true');
                                field.classList.add('editable-active');
                                this.innerText = 'Salvar';
                            }
                        });
                    });
                });
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