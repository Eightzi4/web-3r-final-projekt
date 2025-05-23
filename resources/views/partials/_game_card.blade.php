<div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden transition-all duration-300 ease-in-out hover:shadow-xl relative group">
    <a href="{{ route('games.show', $game) }}" class="block">
        @if ($game->images->isNotEmpty())
            <img src="{{ asset('storage/' . $game->images->first()->image) }}" alt="{{ $game->name }}"
                 class="w-full h-56 object-cover transform group-hover:scale-105 transition-transform duration-300">
        @else
            <div class="w-full h-56 bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                <svg class="w-16 h-16 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
        @endif
    </a>

    <div class="p-5">
        <h3 class="font-semibold text-xl mb-2 truncate text-gray-800 dark:text-white">
            <a href="{{ route('games.show', $game) }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">{{ $game->name }}</a>
        </h3>
        <p class="text-gray-600 dark:text-gray-400 text-sm mb-3 line-clamp-2">{{ Str::limit($game->description, 100) }}</p>

        <div class="mb-3">
            @if($game->tags->isNotEmpty())
                <div class="flex flex-wrap gap-2">
                    @foreach($game->tags->take(3) as $tag)
                        <span class="px-2 py-1 text-xs font-semibold text-indigo-700 bg-indigo-100 dark:text-indigo-200 dark:bg-indigo-700 rounded-full">{{ $tag->name }}</span>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="flex justify-between items-center mb-3">
            <span class="text-xl font-bold text-indigo-600 dark:text-indigo-400">
                @if ($game->latestPrice)
                    ${{ number_format($game->latestPrice->price, 2) }}
                    @if ($game->latestPrice->discount > 0)
                        <span class="text-xs text-green-600 dark:text-green-400 ml-1 line-through opacity-75">
                            ${{ number_format($game->latestPrice->price / (1 - ($game->latestPrice->discount / 100)), 2) }}
                        </span>
                        <span class="text-sm text-green-500 dark:text-green-400 ml-1">({{ $game->latestPrice->discount }}% off)</span>
                    @endif
                @else
                    Price N/A
                @endif
            </span>
            @if($game->developer)
            <a href="#" class="text-sm text-gray-500 dark:text-gray-400 hover:underline">
                by {{ $game->developer->name }}
            </a>
            @endif
        </div>

        @auth
        <div class="mt-auto pt-3 border-t border-gray-200 dark:border-gray-700 flex justify-between items-center">
            @if (Auth::user()->is_admin)
                <div class="flex space-x-2">
                    <a href="{{ route('admin.games.edit', $game->id) }}" title="Edit Game" class="p-2 bg-gray-100 dark:bg-gray-700 rounded-full hover:bg-yellow-400 dark:hover:bg-yellow-600 text-yellow-600 dark:text-yellow-300 transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg>
                    </a>
                    <form action="{{ route('admin.games.destroy', $game->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete {{ $game->name }}? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" title="Delete Game" class="p-2 bg-gray-100 dark:bg-gray-700 rounded-full hover:bg-red-500 dark:hover:bg-red-700 text-red-500 dark:text-red-400 transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        </button>
                    </form>
                </div>
            @endif

            <div>
                @if($game->is_wishlisted)
                    <form action="{{ route('wishlist.remove', $game->id) }}" method="POST">
                        @csrf
                        <button type="submit" title="Remove from Wishlist" class="p-2 bg-red-100 dark:bg-red-700 rounded-full text-red-500 dark:text-red-300 hover:bg-red-200 dark:hover:bg-red-600 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
                        </button>
                    </form>
                @else
                    <form action="{{ route('wishlist.add', $game->id) }}" method="POST">
                        @csrf
                        <button type="submit" title="Add to Wishlist" class="p-2 bg-gray-100 dark:bg-gray-700 rounded-full text-gray-500 dark:text-gray-400 hover:bg-pink-100 dark:hover:bg-pink-700 hover:text-pink-500 dark:hover:text-pink-300 transition-colors">
                           <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        </button>
                    </form>
                @endif
            </div>
        </div>
        @endauth
    </div>
</div>
