<x-layouts.v-main-layout>
    <form method="GET" action="{{ route('search') }}" class="mb-6 bg-white p-4 rounded-lg shadow">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Tags Dropdown -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Tags</label>
                <select name="tags[]" multiple
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->id }}"
                            {{ in_array($tag->id, (array) request('tags', [])) ? 'selected' : '' }}>
                            {{ $tag->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Sort Dropdown -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Sort By</label>
                <select name="sort"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="">None</option>
                    <option value="price" {{ request('sort') == 'price' ? 'selected' : '' }}>Price</option>
                </select>
            </div>

            <!-- Submit Button -->
            <div class="self-end">
                <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                    Filter
                </button>
            </div>
        </div>
    </form>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($games as $game)
            @include('partials._game_card', ['game' => $game])
        @endforeach
    </div>

    <div class="mt-6">
        {{ $games->appends(request()->query())->links() }}
    </div>
</x-layouts.v-main-layout>
