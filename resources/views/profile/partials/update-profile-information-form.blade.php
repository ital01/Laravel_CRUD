<section>
    <header>
            @if (session('status') === 'profile-updated')
            <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                {{ __('Informações do perfil atualizadas com sucesso') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

        <h2 class="text-lg font-medium">
            {{ __('Informações do Perfil') }}
        </h2>

        <p class="py-2 mt-1 text-sm">
            {{ __("Atualize as informações do seu perfil e endereço de email.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6">
        @csrf
        @method('patch')

        <div class="mb-3">
            <label for="name" class="form-label">{{ __('Nome') }}</label>
            <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="py-2 mb-3">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required autocomplete="username">
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-sm">
                        {{ __('Seu endereço de email não foi verificado.') }}
                        <button form="send-verification" class="btn btn-link">
                            {{ __('Clique aqui para reenviar o email de verificação.') }}
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-success">
                            {{ __('Um novo link de verificação foi enviado para o seu endereço de email.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="py-2 mb-3">
            <button type="submit" class="btn btn-primary">{{ __('Salvar') }}</button>
        </div>
    </form>
</section>
