<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.0/css/dataTables.bootstrap5.min.css">
</head>

<body class="bg-light">
    @include('layouts.navigation')

    <header class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                @if (session('success'))
                    <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                        class="alert alert-success alert-dismissible fade show my-2 text-center" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
    
                @if (session('error'))
                    <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                        class="alert alert-danger alert-dismissible fade show my-2 text-center" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
    
                <div class="d-flex justify-content-center">
                    <!-- Formulário de envio -->
                    <div class="card o-hidden border-0 shadow-lg my-2 w-75">
                        <div class="card-body">
                            <h3 class="mb-4">Adicionar cadastro</h3>
                            <form id="form" action="/enviar-form" method="POST">
                                @csrf
                                <div class="py-2">
                                    <label for="nome" class="form-label">Nome</label>
                                    <input type="text" id="nome" name="nome" class="form-control" required
                                        minlength="2">
                                </div>
                                <div class="py-2">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" id="email" name="email" class="form-control" required>
                                </div>
                                <div class="py-2">
                                    <button type="submit" class="btn btn-primary">Enviar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-center">
                    <!-- Formulário de pesquisa -->
                    <div class="card o-hidden border-0 shadow-lg my-2 w-75">
                        <div class="card-body">
                            <h3>Pesquisa</h3>
                            <form id="searchForm" class="py-1">
                                <div class="form-group mb-3">
                                    <label for="searchById">ID</label>
                                    <input type="number" id="searchById" name="searchById" class="form-control" placeholder="Pesquisa por ID" min="1">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="searchByName">Nome</label>
                                    <input type="text" id="searchByName" name="searchByName" class="form-control" placeholder="Pesquisa por Nome">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="searchByEmail">Email</label>
                                    <input type="text" id="searchByEmail" name="searchByEmail" class="form-control" placeholder="Pesquisa por Email">
                                </div>
                                <!--<button type="submit" id="searchButton" class="btn btn-primary">PROCURAR</button>-->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    

    <section class="container p-1" id="tabela">
        <table id="tabela-usuarios" class="table table-bordered table-striped">
            <thead class="bg-dark text-white">
                <tr>
                    <th scope="col" class="fs-5 text-white">ID</th>
                    <th scope="col" class="fs-5 text-white">Nome</th>
                    <th scope="col" class="fs-5 text-white">Email</th>
                    <th scope="col" class="text-center fs-5 text-white">Editar</th>
                    <th scope="col" class="text-center fs-5 text-white">Excluir</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usuarios as $usuario)
                    <tr>
                        <td>{{ $usuario->id }}</td>
                        <td class="editable" data-field="nome" data-id="{{ $usuario->id }}">{{ $usuario->nome }}
                        </td>
                        <td class="editable" data-field="email" data-id="{{ $usuario->id }}">{{ $usuario->email }}
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-info editar-btn"
                                data-id="{{ $usuario->id }}">Editar</button>
                        </td>
                        <td class="text-center">
                            <form id="form-excluir-{{ $usuario->id }}"
                                action="{{ route('excluir', ['id' => $usuario->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger delete-btn">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>



        <br />

        <form id="form-atualizar" action="" method="POST" style="display: none;">
            @csrf
            @method('POST')
            <input type="hidden" name="nome" id="nome">
            <input type="hidden" name="email" id="email">
        </form>

    </section>

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.0.0/js/dataTables.bootstrap5.min.js">
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editarButtons = document.querySelectorAll('.editar-btn');

            editarButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const otherEditButtons = document.querySelectorAll(
                        '.editar-btn:not([data-id="' + this.getAttribute('data-id') + '"])');
                    otherEditButtons.forEach(btn => btn.disabled = true);

                    const otherDeleteButtons = document.querySelectorAll(
                        '.delete-btn:not([data-id="' + this.getAttribute('data-id') + '"])');
                    otherDeleteButtons.forEach(btn => btn.disabled = true);

                    const id = this.getAttribute('data-id');
                    const fields = document.querySelectorAll(`.editable[data-id="${id}"]`);

                    fields.forEach(field => {
                        if (field.getAttribute('contenteditable') === 'true') {
                            field.setAttribute('contenteditable', 'false');
                            field.classList.remove('editable-active');
                            this.innerText = 'Editar';

                            const nome = document.querySelector(
                                    `.editable[data-field="nome"][data-id="${id}"]`)
                                .innerText;
                            const email = document.querySelector(
                                    `.editable[data-field="email"][data-id="${id}"]`)
                                .innerText;

                            window.location.href =
                                `dashboard/atualizar/${id}?nome=${nome}&email=${email}`;
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

<script>
    $(document).ready(function() {
        
        function filtrarTabela() {
            var id = $('#searchById').val();
            var nome = $('#searchByName').val().toLowerCase();
            var email = $('#searchByEmail').val().toLowerCase();

            $('#tabela-usuarios').DataTable().columns(0).search(id).columns(1).search(nome).columns(2).search(email).draw();
        }

        filtrarTabela();

        $('#searchForm').submit(function(event) {
            event.preventDefault();
            filtrarTabela();
        });

        $('#searchById, #searchByName, #searchByEmail').on('input', filtrarTabela);
    });
</script>


</body>

</html>
