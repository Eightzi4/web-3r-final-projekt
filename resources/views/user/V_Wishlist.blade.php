<x-layouts.v-main-layout title="My Wishlist" :breadcrumbs="$breadcrumbs">
    <header class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">My Wishlist</h1>
    </header>

    @if($wishlistedGames->isEmpty())
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Your wishlist is empty</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Start exploring and add some games!</p>
            <div class="mt-6">
              <a href="{{ route('discover') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Discover Games
              </a>
            </div>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-6 gap-y-8">
            @foreach ($wishlistedGames as $game)
                @include('partials._game_card', ['game' => $game])
            @endforeach
        </div>

        <div class="mt-10">
            {{ $wishlistedGames->links() }}
        </div>
    @endif
</x-layouts.v-main-layout>
