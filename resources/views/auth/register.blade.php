<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Email Address -->
            <div class="mt-2 hidden">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" value="{{ $email[0]->email }}" required />
            </div>

            <!-- Name -->
            <div  class="mt-4">
                <x-label for="name" :value="__('Name')" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            </div>

            <!-- Birth Date -->
            <div class="mt-4">
                <x-label for="birth_date" :value="__('Birth Date')" />

                <x-input id="birth_date" class="block mt-1" type="date" name="birth_date" :value="old('birth_date')" required class="w-full"/>
            </div>

            <!-- Sex -->
            <div class="mt-4">
                <x-label for="sex" :value="__('Sex')" />

                <select name="sex" id="sex" class="block mt-1 w-full rounded-md" required>
                    <option class="hidden"></option>
                    <option class="bg-gray-200" value="male">Male</option>
                    <option class="bg-gray-200" value="female">Female</option>
                </select>
            </div>

            <!-- Address -->
            <div class="mt-4">
                <x-label for="address" :value="__('Address')" />

                <textarea class="block mt-1 rounded-md" name="address" id="address" cols="41" rows="3" required></textarea>
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" oninput="checkPassword()" required />
            </div>

            <p id="message" class="text-md font-medium"></p>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button id="registerButton" type="submit" class="ml-4" disabled>
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>

    <script>
        function checkPassword() {
            let password = document.getElementById('password').value;
            let confirmPassword = document.getElementById('password_confirmation').value;

            if (password === confirmPassword && confirmPassword.length > 0) {
                document.getElementById("message").innerHTML = "Ok! You are good to go";
                document.getElementById('registerButton').disabled = false;
            } else {
                document.getElementById("message").innerHTML = "Info! Your password doesn't match";
            }
        }
    </script>
</x-guest-layout>
