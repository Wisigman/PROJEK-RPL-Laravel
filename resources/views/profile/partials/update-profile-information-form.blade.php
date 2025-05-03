<section class="card bg-white bg-opacity-80 p-6 rounded-xl shadow-md mx-auto mt-4 max-w-6xl">
    <header class="text-center mb-6">
        <h2 class="text-xl font-semibold text-gray-800">{{ __('Profile Information') }}</h2>
        <h5 class="mt-2 text-sm text-gray-600">{{ __("Update your account's profile information, email address, and profile picture.") }}</h5>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PATCH')
        <input type="hidden" name="action" value="update_profile">

        <!-- Role (Read-Only) -->
        <div>
            <x-input-label for="role" :value="__('Role')" class="font-medium text-gray-700" />
            <x-text-input id="role" name="role" type="text" 
                class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" 
                :value="$user->role" readonly />
            <input type="hidden" name="role" value="{{ $user->role }}">
            <x-input-error class="mt-2" :messages="$errors->get('role')" />
        </div>        

        <!-- Name Input -->
        <x-input-label for="name" :value="__('Display Name')" />
        <x-text-input id="name" name="name" type="text" :value="old('name', $user->name)" required class="mt-1 block w-full" />
        <x-input-error :messages="$errors->get('name')" />
    
        <!-- Username Input -->
        <div>
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input id="username" name="username" type="text" :value="old('username', $user->username)" required class="mt-1 block w-full" />
            <x-input-error :messages="$errors->get('username')" />
        </div>
            
        <!-- Email Input -->
        <div class="mb-4">
            <label for="email" class="font-medium text-gray-700">{{ __('Email') }}</label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            @error('email') 
                <p class="text-red-600 mt-2">{{ $message }}</p>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div class="mt-4 text-sm text-gray-600">
                    <p>{{ __('Your email address is unverified.') }}</p>
                    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="underline text-indigo-600 hover:text-indigo-900">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </form>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm text-green-600">{{ __('A new verification link has been sent to your email address.') }}</p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Birth Date -->
        <div class="mb-4">
            <x-input-label for="birth_date" :value="__('Birth Date')" />
            <x-text-input type="date" id="birth_date" name="birth_date" :value="old('birth_date', $user->birth_date)" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
            <x-input-error :messages="$errors->get('birth_date')" />
        </div>

        <!-- About -->
        <div class="mb-4">
            <x-input-label for="about" :value="__('About')" />
            <textarea id="about" name="about" class="block w-full mt-1 pl-2.5 pt-1.5 border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 resize-none" rows="4">{{ old('about', $user->about) }}</textarea>
            <x-input-error :messages="$errors->get('about')" />
        </div>    
    
        <!-- Photo Input -->
        <div class="mb-6 relative group">
            <x-input-label for="foto" :value="__('Profile Photo')" class="font-medium text-gray-700" />
            
            <!-- Gambar Profil yang Dapat Diklik -->
            <label for="foto" class="block mt-2 relative cursor-pointer w-24 h-24 overflow-hidden">
                <img src="{{ $user->foto ? Storage::url($user->foto) : 'https://static.vecteezy.com/system/resources/previews/005/129/844/non_2x/profile-user-icon-isolated-on-white-background-eps10-free-vector.jpg' }}" 
                    class="rounded-full w-full h-full object-cover transition-all duration-300 ease-in-out group-hover:brightness-75" 
                    alt="{{ $user->name }}">
                
                <!-- Tulisan "Ubah" -->
                <div class="absolute inset-0 flex items-center justify-center rounded-full bg-gray-900 bg-opacity-50 opacity-0 pointer-events-none group-hover:opacity-90 transition-opacity duration-200 ease-in-out">
                    <span class="text-white text-sm font-semibold opacity-60 group-hover:opacity-100 transition-opacity duration-100 ease-in-out">Ubah</span>
                </div>
            </label>
            
            <!-- Input Foto yang Tersembunyi (akan dibuka saat gambar diklik) -->
            <input type="file" name="foto" id="foto" accept="image/*" class="w-full hidden" />
            
            <x-input-error :messages="$errors->get('foto')" />
        </div>
    
        <!-- Save Button -->
        <div class="flex justify-center mt-6">
            <x-primary-button class="px-6 py-3 text-sm sm:text-base">
                {{ __('Save') }}
            </x-primary-button>
        </div>

        @if (session('status') === 'profile-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-gray-600 text-center mt-4"
            >{{ __('Saved.') }}</p>
        @endif
    </form>
</section>