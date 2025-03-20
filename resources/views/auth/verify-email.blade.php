<x-guest-layout>

    {{-- Instruction --}}
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by entering the verification code we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </div>

    {{-- Success Message when Code Resent --}}
    @if (session('status') == 'verification-code-sent')
        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
            {{ __('A new verification code has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    {{-- Error or Success after submitting verification code --}}
    @if (session('success'))
        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
            {{ session('success') }}
        </div>
    @endif

    {{-- Verification Code Input Form --}}
    <form method="POST" action="{{ route('user.verify.code') }}" class="mb-6">
        @csrf

        <div class="mb-4">
            <label for="verification_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                {{ __('Verification Code') }}
            </label>
            <input 
                type="text" 
                name="verification_code" 
                id="verification_code" 
                required 
                maxlength="8"
                pattern="[A-Za-z0-9]{8}"
                placeholder="Enter verification code"
                value="{{ old('verification_code') }}"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            >

            @error('verification_code')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <x-primary-button>
                {{ __('Verify Email') }}
            </x-primary-button>
        </div>
    </form>

    <form method="POST" action="{{ route('verification.resend') }}">
    @csrf
    <div>
        <label for="email">Enter your email to resend the code:</label>
        <input type="email" name="email" id="email" required>
    </div>
    <button type="submit">Resend Verification Code</button>
</form>

@if(session('status'))
    <div>{{ session('status') }}</div>
@endif

@if($errors->any())
    <div>
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

        {{-- Logout Button --}}
        <form method="POST" action="{{ route('user.logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>


</x-guest-layout>
