{{-- Main layout component for the Discover page --}}
<x-layouts.v-main title="Discover New Games" :breadcrumbs="$breadcrumbs">
    {{-- Page header for Discover --}}
    <header class="mb-8 text-center">
        <h1 class="text-4xl font-bold text-gray-800 dark:text-white">Discover Amazing Games</h1>
        <p class="mt-2 text-lg text-gray-600 dark:text-gray-400">Explore our curated collection of new and popular titles.</p>
    </header>

    {{-- Check if there are any games to display --}}
    @if($games->isEmpty())
        {{-- Message displayed if no games are found --}}
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No games found</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Check back later or try a different search.</p>
             {{-- Link for admins to add a new game --}}
             @auth
                @if(Auth::user()->is_admin)
                <div class="mt-6">
                  <a href="{{ route('admin.games.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Add New Game
                  </a>
                </div>
                @endif
            @endauth
        </div>
    @else
        {{-- Grid for displaying game cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-6 gap-y-8">
            @foreach ($games as $game)
                @include('partials._game_card', ['game' => $game])
            @endforeach
        </div>

        {{-- Pagination links for games --}}
        <div class="mt-10">
            {{ $games->appends(request()->query())->links() }}
        </div>
    @endif
</x-layouts.v-main>
