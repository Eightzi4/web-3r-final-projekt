<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow relative">
    <!-- Add action buttons -->
    <div class="absolute top-2 right-2 flex space-x-2">
        <a href="{{ route('games.edit', $game->id) }}" class="p-1 bg-white/80 rounded-full hover:bg-gray-100">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
            </svg>
        </a>
        <form action="{{ route('games.destroy', $game->id) }}" method="POST"
            onsubmit="return confirm('Are you sure you want to delete this game?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="p-1 bg-white/80 rounded-full hover:bg-gray-100">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </button>
        </form>
    </div>
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
                @if ($game->latestPrice)
                    ${{ number_format($game->latestPrice->price, 2) }}
                    @if ($game->latestPrice->discount)
                        <span class="text-sm text-green-600 ml-2">
                            ({{ $game->latestPrice->discount }}% off)
                        </span>
                    @endif
                @else
                    N/A
                @endif
            </span>
            <span class="text-sm text-gray-500">by {{ $game->developer->name }}</span>
        </div>
    </div>
</div>
