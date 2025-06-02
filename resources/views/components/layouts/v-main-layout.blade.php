<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }} - {{ config('app.name', 'Game Application') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- AlpineJS is included via Vite build in app.js usually. If not: --}}
    {{-- <script src="//unpkg.com/alpinejs" defer></script> --}}

    <!-- Styles -->
    {{-- <link rel="stylesheet" href="{{ asset('css/custom.css') }}"> --}}
    @stack('styles') {{-- For page-specific styles --}}
</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <nav class="bg-white dark:bg-gray-800 shadow-md sticky top-0 z-50" x-data="{ isOpen: false }">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center">
                        <a href="{{ route('discover') }}" class="flex-shrink-0 flex items-center">
                            {{-- Replace with your logo --}}
                            <svg class="h-10 w-auto text-indigo-600 dark:text-indigo-400" viewBox="0 0 24 24"
                                fill="currentColor">
                                <path
                                    d="M19.496 7.014C18.317 5.836 16.706 5.199 15 5.199h-6c-1.706 0-3.317.637-4.496 1.815C3.317 8.193 2.68 9.804 2.68 11.5s.637 3.307 1.815 4.486C5.683 17.164 7.294 17.801 9 17.801h6c1.706 0 3.317-.637 4.496-1.815 1.178-1.179 1.815-2.79 1.815-4.486s-.637-3.307-1.815-4.486zM8 10H6v2h2v2h2v-2h2v-2h-2V8H8v2zm9.5-1c.828 0 1.5.672 1.5 1.5s-.672 1.5-1.5 1.5S16 11.328 16 10.5 16.672 9 17.5 9zm-3 3c.828 0 1.5.672 1.5 1.5s-.672 1.5-1.5 1.5S13 14.328 13 13.5 13.672 12 14.5 12z" />
                            </svg>
                            <span
                                class="ml-2 text-xl font-semibold text-gray-700 dark:text-gray-200">{{ config('app.name', 'GamePlatform') }}</span>
                        </a>
                    </div>

                    <!-- Desktop Menu -->
                    <div class="hidden md:flex items-center space-x-6">
                        <a href="{{ route('discover') }}"
                            class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white">Discover</a>
                        <a href="{{ route('search') }}"
                            class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white">Search</a>
                        @auth
                            <a href="{{ route('wishlist.index') }}"
                                class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white">Wishlist</a>
                            @if (Auth::user()->is_admin)
                                <a href="{{ route('admin.dashboard') }}"
                                    class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white">Admin
                                    Dashboard</a>
                            @endif
                            <!-- User Dropdown -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open"
                                    class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white focus:outline-none">
                                    <div>{{ Auth::user()->name }}</div>
                                    <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <div x-show="open" @click.outside="open = false"
                                    class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-700 rounded-md shadow-lg py-1 z-20 ring-1 ring-black ring-opacity-5"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 transform scale-95"
                                    x-transition:enter-end="opacity-100 transform scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="opacity-100 transform scale-100"
                                    x-transition:leave-end="opacity-0 transform scale-95" style="display: none;">
                                    {{-- <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">Profile</a> --}}
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                                            Log Out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}"
                                class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white">Log
                                In</a>
                            <a href="{{ route('register') }}"
                                class="px-3 py-2 rounded-md text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600">Register</a>
                        @endauth
                    </div>

                    <!-- Mobile menu button -->
                    <div class="md:hidden flex items-center">
                        <button @click="isOpen = !isOpen" type="button"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
                            aria-controls="mobile-menu" aria-expanded="false">
                            <span class="sr-only">Open main menu</span>
                            <svg x-show="!isOpen" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <svg x-show="isOpen" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div class="md:hidden" id="mobile-menu" x-show="isOpen" @click.away="isOpen = false" style="display: none;">
                <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                    <a href="{{ route('discover') }}"
                        class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white">Discover</a>
                    <a href="{{ route('search') }}"
                        class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white">Search</a>
                    @auth
                        <a href="{{ route('wishlist.index') }}"
                            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white">Wishlist</a>
                        @if (Auth::user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}"
                                class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white">Admin
                                Panel</a>
                        @endif
                        {{-- <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white">Profile</a> --}}
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white">
                                Log Out
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}"
                            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white">Log
                            In</a>
                        <a href="{{ route('register') }}"
                            class="block px-3 py-2 rounded-md text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600">Register</a>
                    @endauth
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="flex-grow container mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            @if (!empty($breadcrumbs) && count($breadcrumbs) > 0)
                <nav class="mb-6" aria-label="Breadcrumb">
                    <ol role="list" class="flex items-center space-x-2 text-sm">
                        @foreach ($breadcrumbs as $breadcrumb)
                            <li>
                                <div class="flex items-center">
                                    @if (!$loop->first)
                                        <svg class="flex-shrink-0 h-5 w-5 text-gray-300 dark:text-gray-500"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                            viewBox="0 0 20 20" aria-hidden="true">
                                            <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                                        </svg>
                                    @endif
                                    <a href="{{ $breadcrumb['url'] ?? '#' }}"
                                        class="{{ $loop->last ? 'text-gray-700 dark:text-gray-300' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200' }} ml-2 font-medium">
                                        {{ $breadcrumb['name'] }}
                                    </a>
                                </div>
                            </li>
                        @endforeach
                    </ol>
                </nav>
            @endif

            <!-- Flash Messages -->
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 dark:bg-green-800 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-200 rounded-md shadow-sm"
                    role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 dark:bg-red-800 border border-red-400 dark:border-red-600 text-red-700 dark:text-red-200 rounded-md shadow-sm"
                    role="alert">
                    {{ session('error') }}
                </div>
            @endif
            @if (session('warning'))
                <div class="mb-4 p-4 bg-yellow-100 dark:bg-yellow-800 border border-yellow-400 dark:border-yellow-600 text-yellow-700 dark:text-yellow-200 rounded-md shadow-sm"
                    role="alert">
                    {{ session('warning') }}
                </div>
            @endif
            @if (session('info'))
                <div class="mb-4 p-4 bg-blue-100 dark:bg-blue-800 border border-blue-400 dark:border-blue-600 text-blue-700 dark:text-blue-200 rounded-md shadow-sm"
                    role="alert">
                    {{ session('info') }}
                </div>
            @endif

            @if ($errors->any() && !session()->has('success')) {{-- Avoid showing general errors if a specific success message is present --}}
                <div
                    class="mb-4 p-4 bg-red-100 dark:bg-red-800 border border-red-400 dark:border-red-600 text-red-700 dark:text-red-200 rounded-md shadow-sm">
                    <strong class="font-bold">Oops! Something went wrong.</strong>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="bg-white dark:bg-gray-800 shadow-inner mt-auto py-6">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center text-gray-500 dark:text-gray-400 text-sm">
                &copy; {{ date('Y') }} {{ config('app.name', 'Game Application') }}. All rights reserved.
                <p class="mt-1">Built with Laravel & Tailwind CSS</p>
            </div>
        </footer>
    </div>
    @stack('scripts') {{-- For page-specific scripts --}}
</body>

</html>
