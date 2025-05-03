<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-cover bg-center" style="background-image: url('{{ asset('storage/bg.jpg') }}')">
    <div class="bg-white bg-opacity-80 p-8 rounded-lg shadow-lg max-w-lg w-full text-center">
        <div class="w-36 h-36 mx-auto mb-6">
            <img src="{{ asset('storage/logo.png') }}" alt="Logo" class="w-full h-full object-contain">
        </div>
        <h2 class="text-2xl font-semibold text-gray-800 mb-2">Create an Account</h2>
        <p class="text-sm text-gray-600 mb-6">Please register to create a new account</p>

        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <!-- Display Name -->
            <div>
                <label for="name" class="block text-left font-medium text-gray-700">Display Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your name" value="{{ old('name') }}" required
                    class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @error('name')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
            </div>

            <!-- Username -->
            <div>
                <label for="username" class="block text-left font-medium text-gray-700">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" value="{{ old('username') }}" required
                    class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @error('username')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-left font-medium text-gray-700">Email Address</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" value="{{ old('email') }}" required
                    class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @error('email')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-left font-medium text-gray-700">Password</label>
                <div class="relative">
                    <input type="password" id="password" name="password" placeholder="Enter your password" required
                        class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <span class="absolute right-4 top-3 text-gray-500 cursor-pointer" onclick="togglePassword('password')">
                        <i class="bi bi-eye"></i>
                    </span>
                </div>
                @error('password')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-left font-medium text-gray-700">Confirm Password</label>
                <div class="relative">
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm your password" required
                        class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <span class="absolute right-4 top-3 text-gray-500 cursor-pointer" onclick="togglePassword('password_confirmation')">
                        <i class="bi bi-eye"></i>
                    </span>
                </div>
                @error('password_confirmation')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
            </div>

            <!-- Role -->
            <div>
                <label for="role" class="block text-left font-medium text-gray-700">Role</label>
                <select id="role" name="role" required
                    class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="" disabled {{ old('role') ? '' : 'selected' }}>Select Role</option>
                    <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User</option>
                    <option value="supplier" {{ old('role') === 'supplier' ? 'selected' : '' }}>Supplier</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('role')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
            </div>

            <!-- Registration Code -->
            <div>
                <label for="kode_pendaftaran" class="block text-left font-medium text-gray-700">Registration Code</label>
                <input type="text" id="kode_pendaftaran" name="kode_pendaftaran" placeholder="Enter registration code" required
                    class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @error('kode_pendaftaran')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-lg font-medium hover:bg-indigo-700 transition">Register</button>
        </form>

        <div class="mt-4">
            <p class="text-sm text-gray-600">Already have an account? 
                <a href="{{ route('login') }}" class="text-indigo-600 font-medium">Log in</a>
            </p>
        </div>
    </div>

    <script>
        function togglePassword(id) {
            const field = document.getElementById(id);
            field.type = field.type === 'password' ? 'text' : 'password';
        }
    </script>
</body>
</html>
