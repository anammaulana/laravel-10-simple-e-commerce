<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css'])
    
    <!-- Scripts -->
    @vite(['resources/js/app.js'])
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dropdownToggles = document.querySelectorAll('[data-dropdown-toggle]');
            dropdownToggles.forEach(function(toggle) {
                toggle.addEventListener('click', function(event) {
                    event.preventDefault();
                    const dropdownId = toggle.getAttribute('data-dropdown-toggle');
                    const dropdown = document.getElementById(dropdownId);
                    dropdown.classList.toggle('hidden');
                });
            });
        });
    </script>
</head>
<body class="bg-gray-100">
    <div id="app">
        <nav class="bg-gray-800 p-4 shadow-md">
            <div class="container mx-auto flex justify-between items-center">
                <a class="text-white text-lg font-semibold" href="{{ route('index_product') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <div>
                    <ul class="flex space-x-4">
                        @guest
                            @if (Route::has('login'))
                                <li>
                                    <a class="text-gray-300 hover:text-white" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
        
                            @if (Route::has('register'))
                                <li>
                                    <a class="text-gray-300 hover:text-white" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="relative">
                                <a class="text-gray-300 hover:text-white flex items-center" href="#" role="button" data-dropdown-toggle="userDropdown">
                                    <img src="{{url('storage/'. Auth::user()->image)}}" alt="Logo" class="h-8 w-8 rounded-full mr-2">
                                    {{ Auth::user()->name }}
                                </a>
                                <div id="userDropdown" class="hidden absolute right-0 w-48 bg-white rounded shadow-md mt-2">
                                    @if (Auth::user()->is_admin)
                                        <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" href="{{ route('create_product') }}">
                                            Buat Produk
                                        </a>
                                    @else
                                        <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" href="{{ route('show_cart') }}">
                                            Keranjang
                                        </a>
                                    @endif
                                    <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" href="{{ route('index_order') }}">
                                        Pesanan
                                    </a>
                                    <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" href="{{ route('show_profile') }}">
                                        Profil
                                    </a>
                                    <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>

