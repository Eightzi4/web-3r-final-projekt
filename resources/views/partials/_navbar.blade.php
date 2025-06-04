{{-- Main navigation bar, responsive with Alpine.js for mobile toggle --}}
<nav class="bg-white shadow-lg" x-data="{ isOpen: false }">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            {{-- Site logo/brand name --}}
            <div class="flex items-center">
                <a href="http://localhost/web-3r-final-projekt/public/" class="text-2xl font-bold text-gray-800">GamePlatform</a>
            </div>

            {{-- Mobile menu toggle button --}}
            <div class="md:hidden">
                <button @click="isOpen = !isOpen" class="text-gray-600 hover:text-gray-800">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            {{-- Desktop navigation links --}}
            <div class="hidden md:flex space-x-8">
                <a href="{{ route('discover') }}" class="text-gray-600 hover:text-gray-800">Discover</a>
                <a href="{{ route('search') }}" class="text-gray-600 hover:text-gray-800">Search</a>
                <a href="{{ route('games.create') }}" class="text-gray-600 hover:text-gray-800">Add</a>
            </div>
        </div>
    </div>

    {{-- Mobile navigation menu (collapsible) --}}
    <div class="md:hidden" x-show="isOpen" @click.away="isOpen = false">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="{{ route('discover') }}" class="block text-gray-600 hover:text-gray-800">Discover</a>
            <a href="{{ route('search') }}" class="block text-gray-600 hover:text-gray-800">Search</a>
            @auth
                @if (auth()->user()->is_admin)
                    <a href="{{ route('games.create') }}" class="block text-gray-600 hover:text-gray-800">Add</a>
                @endif
            @endauth
        </div>
    </div>
</nav>
