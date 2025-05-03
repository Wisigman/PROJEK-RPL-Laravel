<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PKK Market')</title>
    @vite(['resources/ts/app.ts', 'resources/css/app.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="/src/styles.css" rel="stylesheet">
    <link rel="public/favicon.ico" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body class="flex flex-col min-h-screen bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('storage/bg.jpg') }}');">
    <nav class="bg-gray-800 py-4">
        <div class="container mx-auto px-6 flex items-center justify-between">
            <a href="{{ route('barangs.index') }}" class="text-white text-2xl font-bold">PKK Market</a>
            <!-- Navbar Content -->
            <div class="flex items-center space-x-8">
                @auth
                <ul class="flex items-center space-x-8 list-none">
                    <li class="nav-item relative right-10">
                        <a href="{{ route('history.index') }}" class="nav-link flex items-center">
                            <i class="fas fa-history text-gray-500 text-2xl transition-all duration-300 transform hover:text-blue-500 hover:scale-110"></i>
                        </a>
                    </li>
                    @auth
                    @if (Auth::user()->role === 'admin' || Auth::user()->role === 'supplier')
                            <li class="nav-item relative right-10">
                                <a href="{{ route('barangs.create') }}" class="nav-link flex items-center">
                                    <i class="fas fa-plus-circle text-gray-500 text-2xl transition-all duration-300 transform hover:text-blue-500 hover:scale-110"></i>
                                </a>
                            </li>
                        @endif
                    @endauth
                    @if (Auth::user()->role === 'user')
                    <li class="nav-item relative right-10">
                        <a href="{{ route('cart.index') }}" class="nav-link flex items-center relative">
                            <i class="fas fa-shopping-cart text-gray-500 text-2xl transition-all duration-300 transform hover:text-blue-500 hover:scale-110"></i>
                            @php
                                $cartCount = session('cart.count', 0);
                                $displayCount = $cartCount > 99 ? '99+' : ($cartCount > 0 ? $cartCount : null);
                            @endphp
                            @if($displayCount)
                            <span class="absolute -right-6 translate-x-1/2 -translate-y-1/2 text-xs font-bold text-white bg-red-600 py-0.5 px-2 rounded-full min-w-[30px] text-center truncate max-w-[50px] ai-style-change-1 -top-2">
                                {{ $displayCount }}
                            </span>                            
                            @endif
                        </a>
                    </li>                    
                    @endif
                </ul>
                <div class="relative right-10 z-60">
                    <button id="dropdownButton" class="flex items-center space-x-3 text-white hover:text-blue-400 focus:outline-none">
                        @if (Auth::user()->foto)
                        <img src="{{ asset('storage/' . Auth::user()->foto) }}" alt="Profile Photo"
                            class="w-12 h-12 rounded-full object-cover">
                        @else
                        <img src="https://static.vecteezy.com/system/resources/previews/005/129/844/non_2x/profile-user-icon-isolated-on-white-background-eps10-free-vector.jpg"
                            alt="Default Photo" class="w-12 h-12 rounded-full object-cover">
                        @endif
                    </button>
                    <ul id="dropdownMenu" class="hidden absolute right-0 mt-2 w-56 bg-gray-800 text-white rounded shadow-lg z-30">
                        <li class="px-4 py-2 hover:bg-gray-600 flex items-center space-x-2">
                            <i class="fas fa-user-circle"></i>⠀
                            <span>{{ Auth::user()->name }}: {{ auth()->user()->role }}</span>
                        </li>
                        <li class="px-4 py-2 hover:bg-gray-600 flex items-center space-x-2">
                            <i class="fas fa-user"></i>
                            <a href="{{ route('profile.edit') }}">⠀Profile</a>
                        </li>
                        <li>
                            <hr class="border-gray-600">
                        </li>
                        <li class="px-4 py-2 hover:bg-gray-600 flex items-center space-x-2">
                            <i class="fas fa-sign-out-alt"></i>
                            <a href="{{ route('logout') }}" 
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">⠀Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        </li>                        
                    </ul>
                </div>
                @else
                <a href="{{ route('login') }}" class="text-white hover:text-blue-400 text-lg"><i class="fas fa-sign-in-alt"></i>⠀Login</a>
                <a href="{{ route('register') }}" class="text-white hover:text-blue-400 text-lg"><i class="fas fa-user-plus"></i>⠀Register</a>
                @endif
            </div>
        </div>
    </nav>

    <!-- Kontainer Utama -->
    <main class="flex-grow container mx-auto mt-6 px-6">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6 mt-auto">
        <div class="container mx-auto text-center">
            <p class="text-sm">&copy; {{ date('Y') }} PKK Market. All rights reserved.</p>
            <div class="mt-4 flex justify-center space-x-4">
                <a href="mailto:info@smkn8jakarta.sch.id" title="Contact" class="text-white hover:text-blue-400 text-2xl">
                    <i class="fas fa-envelope"></i>
                </a>
                <a href="https://www.youtube.com/@Smkn8jkt" target="_blank" title="Youtube" class="text-white hover:text-red-600 text-2xl">
                    <i class="fab fa-youtube"></i>
                </a>
                <a href="https://www.facebook.com/smkn8jktofficial" target="_blank" title="Facebook" class="text-white hover:text-blue-600 text-2xl">
                    <i class="fab fa-facebook"></i>
                </a>
                <a href="https://www.instagram.com/delapanjkt" target="_blank" title="Instagram" class="text-white hover:text-pink-500 text-2xl">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="https://x.com/smkn8jkt" target="_blank" title="X (Formerly Twitter)" class="text-white hover:text-black text-2xl">
                    <i class="fab fa-x-twitter"></i>
                </a>
                <a href="https://wa.me/6285717281174" target="_blank" title="WhatsApp" class="text-white hover:text-green-500 text-2xl">
                    <i class="fab fa-whatsapp"></i>
                </a>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const dropdownButton = document.getElementById('dropdownButton');
        const dropdownMenu = document.getElementById('dropdownMenu');

        dropdownButton.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdownMenu.classList.toggle('hidden');
        });

        window.addEventListener('click', (e) => {
            if (!dropdownButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
