<section>
    <div class="container">
        <header>
                @if (session('status') === 'password-updated')
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                    {{ __('Senha atualizada com sucesso') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
        <h2 class="text-lg font-medium">
            {{ __('Atualizar Senha') }}
        </h2>

        </header>
        <form method="post" action="{{ route('password.update') }}" class="mt-6">
            @csrf
            @method('put')

            <div class="mb-3">
                <label for="update_password_current_password" class="form-label">{{ __('Senha Atual') }}</label>
                <input type="password" id="update_password_current_password" name="current_password" class="form-control" autocomplete="current-password" required>
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div>

            <div class="mb-3">
                <label for="update_password_password" class="form-label">{{ __('Nova Senha') }}</label>
                <input type="password" id="update_password_password" name="password" class="form-control" autocomplete="new-password" required>
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            </div>

            <div class="mb-3">
                <label for="update_password_password_confirmation" class="form-label">{{ __('Confirmar Nova Senha') }}</label>
                <input type="password" id="update_password_password_confirmation" name="password_confirmation" class="form-control" autocomplete="new-password" required>
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">{{ __('Salvar') }}</button>
            </div>
        </form>
    </div>
</section>
