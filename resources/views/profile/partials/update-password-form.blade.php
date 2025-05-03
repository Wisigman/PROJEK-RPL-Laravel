<section class="card bg-white bg-opacity-80 p-6 rounded-xl shadow-md mx-auto mt-4 max-w-6xl">
    <div>
        <header class="mb-6 text-center">
            <h2 class="text-xl font-semibold text-gray-800">
                {{ __('Update Password') }}
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                {{ __('Ensure your account is using a long, random password to stay secure.') }}
            </p>
        </header>

        <form method="post" action="{{ route('password.update') }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Current Password -->
            <div class="relative mb-4">
                <x-input-label for="update_password_current_password" :value="__('Current Password')" class="mb-2" />
                <div class="relative">
                    <input id="update_password_current_password" name="current_password" type="password" class="w-full py-3 pl-4 pr-12 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" autocomplete="current-password" />
                    <button type="button" class="absolute right-3 top-3 text-gray-500 focus:outline-none" onclick="togglePassword('update_password_current_password')">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div>

            <!-- New Password -->
            <div class="relative mb-4">
                <x-input-label for="update_password_password" :value="__('New Password')" class="mb-2" />
                <div class="relative">
                    <input id="update_password_password" name="password" type="password" class="w-full py-3 pl-4 pr-12 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" autocomplete="new-password" />
                    <button type="button" class="absolute right-3 top-3 text-gray-500 focus:outline-none" onclick="togglePassword('update_password_password')">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="relative mb-4">
                <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" class="mb-2" />
                <div class="relative">
                    <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="w-full py-3 pl-4 pr-12 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" autocomplete="new-password" />
                    <button type="button" class="absolute right-3 top-3 text-gray-500 focus:outline-none" onclick="togglePassword('update_password_password_confirmation')">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Save Button -->
            <div class="flex justify-center mt-6">
                <x-primary-button class="px-6 py-3 text-sm sm:text-base">
                    {{ __('Save') }}
                </x-primary-button>
            </div>

            <!-- Success Message -->
            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition
                    x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600 text-center mt-4">
                    {{ __('Saved.') }}
                </p>
            @endif
        </form>
    </div>

    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            const icon = input.nextElementSibling.querySelector('i');

            if (input.type === "password") {
                input.type = "text";
                icon.classList.replace("fa-eye", "fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.replace("fa-eye-slash", "fa-eye");
            }
        }
    </script>
</section>
