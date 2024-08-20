<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Enter the OTP you received to verify your identity.') }}
        </div>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('otp.verify') }}">
            @csrf
            <div class="block mt-4">
                <x-label for="otp" value="{{ __('OTP') }}" />
                <x-input id="otp" class="block mt-1 w-full" type="text" name="otp" required autofocus />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Verify OTP') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
