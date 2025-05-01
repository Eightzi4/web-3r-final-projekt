@props(['title' => 'Game Application'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind CDN for quick setup -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white shadow">
            <div class="container mx-auto px-4 py-4">
                <div class="flex justify-between">
                    <div class="flex space-x-4">
                        <a href="{{ route('discover') }}"
                            class="font-medium text-gray-700 hover:text-gray-900">Discover</a>
                        <a href="{{ route('search') }}" class="font-medium text-gray-700 hover:text-gray-900">Search</a>
                    </div>
                    <div>
                        <a href="{{ route('games.create') }}"
                            class="font-medium text-indigo-600 hover:text-indigo-900">Add Game</a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="container mx-auto py-8 px-4">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="bg-white shadow mt-8 py-4">
            <div class="container mx-auto px-4 text-center text-gray-500 text-sm">
                &copy; {{ date('Y') }} Game Application
            </div>
        </footer>
    </div>
</body>

</html>
