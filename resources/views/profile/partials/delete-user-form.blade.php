<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium">
            {{ __('Excluir Conta') }}
        </h2>

        <p class="mt-1 text-sm text-justify">
            {{ __('Uma vez que sua conta seja excluída, todos os seus recursos e dados serão permanentemente apagados.') }}
        </p>
        <p class="mt-1 text-sm text-justify">
            {{ __('Antes de excluir sua conta, por favor faça o download de quaisquer dados ou informações que deseje manter.') }}
        </p>
    </header>

    <button type="button" class="btn btn-danger"
            data-bs-toggle="modal" data-bs-target="#confirmUserDeletionModal">
        {{ __('Excluir Conta') }}
    </button>

    <div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="confirmUserDeletionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmUserDeletionModalLabel">{{ __('Confirmar Exclusão de Conta') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>{{ __('Uma vez que sua conta seja excluída, todos os seus recursos e dados serão permanentemente apagados.') }}</p>
                        <p>{{ __('Por favor, digite sua senha para confirmar que você deseja excluir sua conta permanentemente.') }}</p>
                        <div class="mb-3">
                            <label for="password" class="form-label visually-hidden">{{ __('Senha') }}</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="{{ __('Senha') }}">
                            @error('password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancelar') }}</button>
                        <button type="submit" class="btn btn-danger">{{ __('Excluir Conta') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
