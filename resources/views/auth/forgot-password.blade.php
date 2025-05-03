<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-cover bg-center" style="background-image: url('{{ asset('storage/bg.jpg') }}')">
    <div class="bg-white bg-opacity-80 p-8 rounded-lg shadow-lg max-w-md w-full text-center">
        <div class="w-36 h-36 mx-auto mb-6 rounded-full">
            <img src="{{ asset('storage/logo.png') }}" alt="Logo" class="w-full h-full object-contain">
        </div>
        <h2 class="text-2xl font-semibold text-gray-800 mb-2">Forgot Password?</h2>
        <p class="text-sm text-gray-600 mb-6">No problem. Just let us know your email address and we will email you a password reset link.</p>
        
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            
            <div class="mb-4">
                <label for="email" class="block text-left font-medium text-gray-700 mb-1">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required autofocus 
                       class="w-full px-4 py-3 text-gray-700 bg-gray-50 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @if ($errors->has('email'))
                    <span class="text-red-600 text-sm">{{ $errors->first('email') }}</span>
                @endif
            </div>

            <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-lg font-medium hover:bg-indigo-700 transition">
                Send Reset Link
            </button>
        </form>

        <div class="mt-4">
            <p class="text-sm text-gray-600">Remember your password? 
                <a href="{{ route('login') }}" class="text-indigo-600 font-medium">Back to login</a>
            </p>
        </div>
    </div>
</body>
</html>