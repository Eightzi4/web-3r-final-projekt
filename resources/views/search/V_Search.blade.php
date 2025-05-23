<x-layouts.v-main-layout title="Search Games" :breadcrumbs="$breadcrumbs">
    <header class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Search for Games</h1>
    </header>

    <form method="GET" action="{{ route('search') }}" class="mb-8 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 items-end">
            <div>
                <label for="query" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Search Term</label>
                <input type="text" name="query" id="query" value="{{ request('query') }}" placeholder="e.g., Cyberpunk, RPG"
                       class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <div>
                <label for="tags" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tags</label>
                <select name="tags[]" id="tags" multiple
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 h-32">
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->id }}"
                            {{ in_array($tag->id, (array) request('tags', [])) ? 'selected' : '' }}>
                            {{ $tag->name }}
                        </option>
                    @endforeach
                </select>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Hold Ctrl/Cmd to select multiple.</p>
            </div>

            <div>
                <label for="platform" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Platform</label>
                <select name="platform" id="platform" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">All Platforms</option>
                    @foreach ($platforms as $platform)
                        <option value="{{ $platform->id }}" {{ request('platform') == $platform->id ? 'selected' : '' }}>
                            {{ $platform->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="sort" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sort By</label>
                <select name="sort" id="sort"
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">Default (Name Asc)</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name: A-Z</option>
                    <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name: Z-A</option>
                    {{-- <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option> --}}
                </select>
            </div>

            <div class="col-span-1 md:col-span-2 lg:col-span-4 flex justify-end space-x-3">
                 <a href="{{ route('search') }}" class="px-4 py-2 border border-gray-300 dark:border-gray-500 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Reset Filters
                </a>
                <button type="submit" class="w-full md:w-auto bg-indigo-600 text-white px-6 py-2 rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 font-medium">
                    Search
                </button>
            </div>
        </div>
    </form>

    @if($games->isEmpty())
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No games match your criteria</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Try adjusting your search or filters.</p>
        </div>
    @else
        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
            Showing {{ $games->firstItem() }} to {{ $games->lastItem() }} of {{ $games->total() }} results.
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-6 gap-y-8">
            @foreach ($games as $game)
                @include('partials._game_card', ['game' => $game])
            @endforeach
        </div>

        <div class="mt-10">
            {{ $games->appends(request()->query())->links() }}
        </div>
    @endif
</x-layouts.v-main-layout>
