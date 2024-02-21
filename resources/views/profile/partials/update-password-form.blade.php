<section>
    <div class="container">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Atualizar Senha') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Certifique-se de que sua conta esteja usando uma senha longa e aleatória para permanecer segura.') }}
        </p>

        <form method="post" action="{{ route('password.update') }}" class="mt-6">
            @csrf
            @method('put')

            <div class="mb-3">
                <label for="update_password_current_password" class="form-label">{{ __('Senha Atual') }}</label>
                <input type="password" id="update_password_current_password" name="current_password" class="form-control" autocomplete="current-password">
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div>

            <div class="mb-3">
                <label for="update_password_password" class="form-label">{{ __('Nova Senha') }}</label>
                <input type="password" id="update_password_password" name="password" class="form-control" autocomplete="new-password">
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            </div>

            <div class="mb-3">
                <label for="update_password_password_confirmation" class="form-label">{{ __('Confirmar Nova Senha') }}</label>
                <input type="password" id="update_password_password_confirmation" name="password_confirmation" class="form-control" autocomplete="new-password">
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">{{ __('Salvar') }}</button>

                @if (session('status') === 'password-updated')
                    <div class="alert alert-success mt-2" role="alert">
                        {{ __('Senha atualizada com sucesso.') }}
                    </div>
                @endif
            </div>
        </form>
    </div>
</section>
