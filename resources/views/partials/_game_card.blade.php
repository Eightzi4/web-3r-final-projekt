<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
    @if ($game->images->isNotEmpty())
        <img src="{{ asset('storage/' . $game->images->first()->image) }}" alt="{{ $game->name }}"
            class="w-full h-48 object-cover">
    @else
        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
            <span class="text-gray-500">No image</span>
        </div>
    @endif

    <div class="p-4">
        <h3 class="font-semibold text-lg mb-2">{{ $game->name }}</h3>
        <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $game->description }}</p>

        <div class="flex justify-between items-center">
            <span class="text-indigo-600 font-bold">
                @if ($game->prices->isNotEmpty())
                    ${{ number_format($game->prices->first()->price, 2) }}
                @else
                    N/A
                @endif
            </span>
            <span class="text-sm text-gray-500">by {{ $game->developer->name }}</span>
        </div>
    </div>
</div>
