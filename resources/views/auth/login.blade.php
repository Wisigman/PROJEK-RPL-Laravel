<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-cover bg-center" style="background-image: url('{{ asset('storage/bg.jpg') }}')">
    <div class="bg-white bg-opacity-80 p-8 rounded-lg shadow-lg max-w-md w-full text-center">
        <div class="w-36 h-36 mx-auto mb-6 rounded-full">
            <img src="{{ asset('storage/logo.png') }}" alt="Logo" class="w-full h-full object-contain">
        </div>
        <h2 class="text-2xl font-semibold text-gray-800 mb-2">Welcome Back</h2>
        <p class="text-sm text-gray-600 mb-6">Please log in to your account</p>
        
        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="mb-4">
                <label for="login" class="block text-left font-medium text-gray-700 mb-1">Email or Username</label>
                <input type="text" id="login" name="login" value="{{ old('login') }}" placeholder="Enter email or username" required autofocus 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @if ($errors->has('login'))
                    <span class="text-red-600 text-sm">{{ $errors->first('login') }}</span>
                @endif
            </div>

            <div class="mb-6">
                <label for="password" class="block text-left font-medium text-gray-700 mb-1">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @if ($errors->has('password'))
                    <span class="text-red-600 text-sm">{{ $errors->first('password') }}</span>
                @endif
            </div>

            <!-- Forgot Password Link -->
            <div class="text-left -mt-3 mb-6">
                <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 font-medium">
                    Forgot your password?
                </a>
            </div>

            <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-lg font-medium hover:bg-indigo-700 transition">
                Log in
            </button>
        </form>

        <div class="mt-4">
            <p class="text-sm text-gray-600">Don't have an account? 
                <a href="{{ route('register') }}" class="text-indigo-600 font-medium">Register</a>
            </p>
        </div>
    </div>
</body>
</html>