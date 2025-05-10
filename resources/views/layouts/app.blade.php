<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Inventori Medis' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 font-sans">
    <!-- Top Navigation Bar -->
    <header class="bg-teal-600 text-white shadow-md">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <span class="font-bold text-xl">Inventori Medis</span>
                </div>
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('dashboard') }}"
                        class="py-2 hover:text-teal-200 {{ request()->routeIs('dashboard') ? 'border-b-2 border-white' : '' }}">Dashboard</a>

                    @if (auth()->user()->role == 'Admin' || auth()->user()->role == 'Pharmacist')
                        <a href="{{ route('medicines.index') }}"
                            class="py-2 hover:text-teal-200 {{ request()->routeIs('medicines.*') ? 'border-b-2 border-white' : '' }}">Obat</a>
                    @endif

                    @if (auth()->user()->role == 'Admin' || auth()->user()->role == 'Technician')
                        <a href="{{ route('medical.index') }}"
                            class="py-2 hover:text-teal-200 {{ request()->routeIs('medical.*') ? 'border-b-2 border-white' : '' }}">Peralatan
                            Medis</a>
                    @endif

                    @if (auth()->user()->role == 'Admin')
                        <a href="{{ route('users.index') }}"
                            class="py-2 hover:text-teal-200 {{ request()->routeIs('users.*') ? 'border-b-2 border-white' : '' }}">Pengguna</a>
                        <a href="{{ route('consumables.index') }}"
                            class="py-2 hover:text-teal-200 {{ request()->routeIs('consumables.*') ? 'border-b-2 border-white' : '' }}">Consumable</a>
                    @endif
                </div>
                <div class="flex items-center space-x-3">
                    <span class="hidden md:inline text-sm text-teal-100">{{ auth()->user()->role ?? 'Tamu' }}</span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="px-3 py-1 bg-red-500 text-white text-sm rounded hover:bg-red-600 transition">
                            Logout
                        </button>
                    </form>
                    <button id="mobile-menu-button" class="md:hidden text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Navigation Drawer -->
    <div id="mobile-menu" class="fixed inset-0 bg-gray-800 bg-opacity-50 z-50 hidden">
        <div class="bg-white h-full w-64 shadow-lg p-5 transform transition-transform">
            <div class="flex justify-between items-center mb-6">
                <h2 class="font-bold text-teal-600">Menu</h2>
                <button id="close-menu" class="text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="flex items-center mb-6 p-3 bg-teal-50 rounded">
                <div class="mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-teal-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Login sebagai:</p>
                    <p class="font-medium">{{ auth()->user()->role ?? 'Tamu' }}</p>
                </div>
            </div>
            <nav>
                <ul class="space-y-1">
                    <li><a href="{{ route('dashboard') }}"
                            class="block py-2 px-4 rounded hover:bg-teal-50 {{ request()->routeIs('dashboard') ? 'bg-teal-50 text-teal-600 font-medium' : 'text-gray-700' }}">Dashboard</a>
                    </li>

                    @if (auth()->user()->role == 'Admin' || auth()->user()->role == 'Pharmacist')
                        <li><a href="{{ route('medicines.index') }}"
                                class="block py-2 px-4 rounded hover:bg-teal-50 {{ request()->routeIs('medicines.*') ? 'bg-teal-50 text-teal-600 font-medium' : 'text-gray-700' }}">Obat</a>
                        </li>
                    @endif

                    @if (auth()->user()->role == 'Admin' || auth()->user()->role == 'Technician')
                        <li><a href="{{ route('medical.index') }}"
                                class="block py-2 px-4 rounded hover:bg-teal-50 {{ request()->routeIs('medical.*') ? 'bg-teal-50 text-teal-600 font-medium' : 'text-gray-700' }}">Peralatan
                                Medis</a></li>
                    @endif

                    @if (auth()->user()->role == 'Admin')
                        <li><a href="{{ route('users.index') }}"
                                class="block py-2 px-4 rounded hover:bg-teal-50 {{ request()->routeIs('users.*') ? 'bg-teal-50 text-teal-600 font-medium' : 'text-gray-700' }}">Pengguna</a>
                        </li>
                        <li><a href="{{ route('consumables.index') }}"
                                class="block py-2 px-4 rounded hover:bg-teal-50 {{ request()->routeIs('consumables.*') ? 'bg-teal-50 text-teal-600 font-medium' : 'text-gray-700' }}">Consumable</a>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-6">
        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm"
                role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-sm p-5 md:p-6">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-100 py-4 mt-8">
        <div class="container mx-auto px-4 text-center text-gray-500 text-sm">
            <p>© {{ date('Y') }} Inventori Medis. Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const closeMenuButton = document.getElementById('close-menu');
            const mobileMenu = document.getElementById('mobile-menu');

            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.remove('hidden');
                document.body.style.overflow = 'hidden'; // Prevent scrolling
            });

            closeMenuButton.addEventListener('click', function() {
                mobileMenu.classList.add('hidden');
                document.body.style.overflow = ''; // Allow scrolling again
            });

            // Close when clicking outside the menu drawer
            mobileMenu.addEventListener('click', function(event) {
                if (event.target === mobileMenu) {
                    mobileMenu.classList.add('hidden');
                    document.body.style.overflow = '';
                }
            });
        });
    </script>
</body>

</html>
