{{-- Main layout component for the game search page --}}
<x-layouts.v-main title="Search Games" :breadcrumbs="$breadcrumbs">
    {{-- Page header section --}}
    <header class="mb-8 text-center">
        <h1 class="text-4xl font-extrabold text-gray-800 dark:text-white tracking-tight">Find Your Next Adventure</h1>
        <p class="mt-3 text-lg text-gray-500 dark:text-gray-400 max-w-2xl mx-auto">
            Use the filters below to narrow down your search and discover amazing games.
        </p>
    </header>

    {{-- Search filters form --}}
    <form method="GET" action="{{ route('search') }}"
        class="mb-10 bg-white dark:bg-gray-800 p-6 sm:p-8 rounded-xl shadow-2xl">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-x-6 gap-y-6 items-end">
            {{-- Search term input field --}}
            <div class="sm:col-span-2 lg:col-span-2">
                <label for="query" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Search by
                    Name or Keyword</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" name="query" id="query" value="{{ request('query') }}"
                        placeholder="e.g., Cyberpunk, RPG, Space Adventure"
                        class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-shadow hover:shadow-md">
                </div>
            </div>

            {{-- Sort by dropdown --}}
            <div>
                <label for="sort" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Sort
                    By</label>
                <select name="sort" id="sort"
                    class="mt-1 block w-full py-2.5 px-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-shadow hover:shadow-md">
                    <option value="">Default (Name A-Z)</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High
                    </option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to
                        Low</option>
                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name: A-Z</option>
                    <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name: Z-A</option>
                </select>
            </div>

            {{-- Platform filter dropdown --}}
            <div>
                <label for="platform"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Platform</label>
                <select name="platform" id="platform"
                    class="mt-1 block w-full py-2.5 px-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-shadow hover:shadow-md">
                    <option value="">All Platforms</option>
                    @foreach ($platforms as $platform)
                        <option value="{{ $platform->id }}"
                            {{ request('platform') == $platform->id ? 'selected' : '' }}>
                            {{ $platform->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Tags filter multi-select --}}
            <div class="sm:col-span-2 lg:col-span-4">
                <label for="tags" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Filter
                    by Tags</label>
                <select name="tags[]" id="tags" multiple
                    class="mt-1 block w-full h-32 py-2.5 px-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-shadow hover:shadow-md">
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->id }}"
                            {{ in_array($tag->id, (array) request('tags', [])) ? 'selected' : '' }}>
                            {{ $tag->name }}
                        </option>
                    @endforeach
                </select>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Hold Ctrl/Cmd to select multiple tags.</p>
            </div>
        </div>
        {{-- Form action buttons: Reset and Apply --}}
        <div
            class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4">
            <a href="{{ route('search') }}"
                class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                Reset Filters
            </a>
            <button type="submit"
                class="w-full sm:w-auto inline-flex items-center justify-center bg-indigo-600 text-white px-8 py-2.5 rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 font-semibold text-sm transition-colors">
                Apply Filters & Search
            </button>
        </div>
    </form>

    {{-- Display search results or "no results" message --}}
    @if ($games->isEmpty())
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                aria-hidden="true">
                <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No games match your criteria</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Try adjusting your search or filters.</p>
        </div>
    @else
        {{-- Results count and game cards grid --}}
        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
            Showing {{ $games->firstItem() }} to {{ $games->lastItem() }} of {{ $games->total() }} results.
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-6 gap-y-8">
            @foreach ($games as $game)
                @include('partials._game_card', ['game' => $game])
            @endforeach
        </div>

        {{-- Pagination links for search results --}}
        <div class="mt-10">
            {{ $games->appends(request()->query())->links() }}
        </div>
    @endif
</x-layouts.v-main>
