{{-- Main container for a single game card --}}
<div
    class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden transition-all duration-300 ease-in-out hover:shadow-2xl group flex flex-col
            @if (!$game->visible && auth()->check() && auth()->user()->is_admin) opacity-60 border-2 border-dashed border-gray-400 dark:border-gray-600 @endif">
    {{-- Badge for hidden games (visible to admins) --}}
    @if (!$game->visible && auth()->check() && auth()->user()->is_admin)
        <div
            class="absolute top-2 left-2 bg-yellow-400 text-yellow-800 text-xs font-semibold px-2 py-0.5 rounded-full z-10">
            Hidden
        </div>
    @endif
    {{-- Link to the game's detail page --}}
    <a href="{{ route('games.show', $game) }}" class="block relative">
        @if ($game->images->isNotEmpty())
            <img src="{{ asset('storage/images/' . $game->images->first()->image) }}" alt="{{ $game->name }}"
                class="w-full h-60 object-cover transform group-hover:scale-105 transition-transform duration-300">
        @else
            {{-- Placeholder for games without an image --}}
            <div
                class="w-full h-60 bg-gray-200 dark:bg-gray-700 flex flex-col items-center justify-center text-center p-4">
                <svg class="w-16 h-16 text-gray-400 dark:text-gray-500 mb-2" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                    </path>
                </svg>
                <span class="text-gray-500 dark:text-gray-400 font-medium">No Image</span>
            </div>
        @endif
    </a>

    {{-- Content section of the game card --}}
    <div class="p-5 flex flex-col flex-grow">
        <h3 class="font-semibold text-lg mb-1.5 text-gray-800 dark:text-white">
            <a href="{{ route('games.show', $game) }}"
                class="hover:text-indigo-600 dark:hover:text-indigo-400 line-clamp-2"
                title="{{ $game->name }}">{{ $game->name }}</a>
        </h3>

        @if ($game->developer)
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-2.5">
                By <a href="{{ route('developers.show', $game->developer) }}"
                    class="hover:underline font-medium">{{ $game->developer->name }}</a>
            </p>
        @endif

        {{-- Tags and price section, pushed to the bottom --}}
        <div class="mt-auto space-y-3">
            <div class="flex flex-wrap gap-1.5 mb-2">
                @if ($game->tags->isNotEmpty())
                    @foreach ($game->tags->take(2) as $tag)
                        <a href="{{ route('tags.show', $tag) }}"
                            class="flex items-center px-2 py-0.5 text-xs font-medium text-gray-700 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 rounded-full hover:bg-gray-200 dark:hover:bg-gray-600"
                            title="{{ $tag->description ?? $tag->name }}">
                            @if ($tag->color)
                                <span class="w-2 h-2 rounded-full mr-1.5"
                                    style="background-color: {{ $tag->color }};"></span>
                            @endif
                            {{ $tag->name }}
                        </a>
                    @endforeach
                    @if ($game->tags->count() > 2)
                        <span
                            class="px-2 py-0.5 text-xs font-medium text-gray-500 bg-gray-100 dark:text-gray-300 dark:bg-gray-600 rounded-full">+{{ $game->tags->count() - 2 }}</span>
                    @endif
                @endif
            </div>

            {{-- Price display --}}
            <div class="flex justify-between items-center">
                <span class="text-lg font-bold text-indigo-600 dark:text-indigo-400">
                    @if ($game->latestPrice)
                        ${{ number_format($game->latestPrice->price, 2) }}
                        @if ($game->latestPrice->discount > 0)
                            <span class="text-xs text-green-600 dark:text-green-400 ml-1 line-through opacity-75">
                                ${{ number_format($game->latestPrice->price / (1 - $game->latestPrice->discount / 100), 2) }}
                            </span>
                        @endif
                    @else
                        N/A
                    @endif
                </span>
                @if ($game->latestPrice && $game->latestPrice->discount > 0)
                    <span
                        class="px-2 py-0.5 text-xs font-semibold text-white bg-red-500 rounded-full">-{{ $game->latestPrice->discount }}%</span>
                @endif
            </div>

            {{-- Admin and Wishlist actions for authenticated users --}}
            @auth
                <div class="pt-3 border-t border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <div class="flex space-x-1.5">
                        @if (Auth::user()->is_admin)
                            <a href="{{ route('admin.games.edit', $game->id) }}" title="Edit Game"
                                class="p-1.5 bg-gray-100 dark:bg-gray-700 rounded-full hover:bg-yellow-400 dark:hover:bg-yellow-600 text-yellow-600 dark:text-yellow-300 transition-colors">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z">
                                    </path>
                                    <path fill-rule="evenodd"
                                        d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </a>
                            <form action="{{ route('admin.games.destroy', $game->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete {{ addslashes($game->name) }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Delete Game"
                                    class="p-1.5 bg-gray-100 dark:bg-gray-700 rounded-full hover:bg-red-500 dark:hover:bg-red-700 text-red-500 dark:text-red-400 transition-colors">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </form>
                        @else
                            <div></div>
                        @endif
                    </div>

                    <div>
                        @if ($game->is_wishlisted)
                            <form action="{{ route('wishlist.remove', $game->id) }}" method="POST">
                                @csrf
                                <button type="submit" title="Remove from Wishlist"
                                    class="p-1.5 bg-red-100 dark:bg-red-700 rounded-full text-red-500 dark:text-red-300 hover:bg-red-200 dark:hover:bg-red-600 transition-colors">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </form>
                        @else
                            <form action="{{ route('wishlist.add', $game->id) }}" method="POST">
                                @csrf
                                <button type="submit" title="Add to Wishlist"
                                    class="p-1.5 bg-gray-100 dark:bg-gray-700 rounded-full text-gray-500 dark:text-gray-400 hover:bg-pink-100 dark:hover:bg-pink-700 hover:text-pink-500 dark:hover:text-pink-300 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                        </path>
                                    </svg>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endauth
        </div>
    </div>
</div>
