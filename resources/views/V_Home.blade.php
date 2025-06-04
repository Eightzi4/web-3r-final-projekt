{{-- Main layout component for the welcome page --}}
<x-layouts.v-main title="Welcome" :breadcrumbs="$breadcrumbs">
    {{-- Centered content container --}}
    <div class="flex items-center justify-center min-h-[60vh]">
        <div class="text-center">
            {{-- Welcome message heading --}}
            <h1 class="text-4xl font-bold text-gray-800 dark:text-white mb-4">
                Welcome to {{ config('app.name', 'Game Application') }}!
            </h1>
            {{-- Subtitle or brief description --}}
            <p class="text-lg text-gray-600 dark:text-gray-400">
                Your central hub for amazing games. Discover, search, and manage your collection.
            </p>
            {{-- Call to action button --}}
            <div class="mt-8">
                <a href="{{ route('discover') }}" class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 transition-colors">
                    Discover Games
                </a>
            </div>
        </div>
    </div>
</x-layouts.v-main>
