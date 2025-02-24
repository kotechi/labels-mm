<form method="POST" action="{{ route('otp.verify') }}">
    @csrf

    <!-- OTP -->
    <div>
        <x-input-label for="otp" :value="__('Enter OTP')" />
        <x-text-input id="otp" class="block mt-1 w-full"
                     type="text"
                     name="otp"
                     required />
        <x-input-error :messages="$errors->get('otp')" class="mt-2" />
    </div>

    <div class="flex items-center justify-end mt-4">
        <x-primary-button class="ml-4">
            {{ __('Verify OTP') }}
        </x-primary-button>
    </div>
</form>