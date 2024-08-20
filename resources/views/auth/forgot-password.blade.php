<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Forgot your password? No problem. Just let us know your NISN and we will email you an OTP that will allow you to reset your password.') }}
        </div>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.forgot') }}">
            @csrf
            <div class="block">
                <x-label for="NISN_NIP" value="{{ __('NISN_NIP') }}" />
                <x-input id="NISN_NIP" class="block mt-1 w-full" type="text" name="NISN_NIP" :value="old('NISN_NIP')" required autofocus autocomplete="NISN_NIP" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Send OTP') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
