<x-layouts.v-main-layout :title="$game->name" :breadcrumbs="$breadcrumbs">

    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg overflow-hidden">
        {{-- Game Header --}}
        <div class="relative">
            @if($game->images->isNotEmpty())
                <img src="{{ asset('storage/' . $game->images->first()->image) }}" alt="{{ $game->name }} banner"
                     class="w-full h-64 md:h-96 object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/0 to-black/0"></div>
            @else
                <div class="w-full h-64 md:h-96 bg-gray-300 dark:bg-gray-700 flex items-center justify-center">
                    <span class="text-gray-500 text-2xl">No Image Available</span>
                </div>
            @endif
            <div class="absolute bottom-0 left-0 p-6 md:p-8">
                <h1 class="text-4xl md:text-5xl font-bold text-white shadow-xl">{{ $game->name }}</h1>
                @if($game->developer)
                <p class="text-xl text-gray-200 mt-1">by <a href="#" class="hover:underline">{{ $game->developer->name }}</a></p>
                @endif
            </div>
        </div>

        <div class="p-6 md:p-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Main Content Column --}}
                <div class="lg:col-span-2 space-y-8">
                    {{-- Trailer --}}
                    @if($game->trailer_link)
                        @php
                            $embedUrl = '';
                            if (str_contains($game->trailer_link, 'youtube.com/watch?v=')) {
                                $videoId = substr($game->trailer_link, strpos($game->trailer_link, 'v=') + 2);
                                if (strpos($videoId, '&') !== false) {
                                    $videoId = substr($videoId, 0, strpos($videoId, '&'));
                                }
                                $embedUrl = "https://www.youtube.com/embed/" . $videoId;
                            } elseif (str_contains($game->trailer_link, 'youtu.be/')) {
                                $videoId = substr($game->trailer_link, strpos($game->trailer_link, 'youtu.be/') + 9);
                                $embedUrl = "https://www.youtube.com/embed/" . $videoId;
                            }
                        @endphp
                        @if($embedUrl)
                        <div class="aspect-w-16 aspect-h-9 rounded-lg overflow-hidden shadow-lg">
                            <iframe src="{{ $embedUrl }}" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen class="w-full h-full"></iframe>
                        </div>
                        @else
                        <p class="text-sm text-gray-600 dark:text-gray-400">Trailer link: <a href="{{$game->trailer_link}}" target="_blank" class="text-indigo-600 hover:underline">{{$game->trailer_link}}</a> (Unable to embed)</p>
                        @endif
                    @endif

                    {{-- Description --}}
                    <section>
                        <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-3">About this game</h2>
                        <div class="prose dark:prose-invert max-w-none text-gray-700 dark:text-gray-300">
                            {!! nl2br(e($game->description)) !!}
                        </div>
                    </section>

                    {{-- Image Gallery --}}
                    @if($game->images->count() > 1)
                    <section>
                        <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-3">Gallery</h2>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                            @foreach($game->images as $image)
                            <a href="{{ asset('storage/' . $image->image) }}" data-fancybox="gallery" class="block rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-shadow">
                                <img src="{{ asset('storage/' . $image->image) }}" alt="Screenshot {{ $loop->iteration }}" class="w-full h-32 object-cover">
                            </a>
                            @endforeach
                        </div>
                    </section>
                    @endif

                    {{-- Reviews Section --}}
                    <section id="reviews">
                        <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-4">Reviews ({{ $game->reviews->count() }})</h2>
                        @auth
                            <div class="mb-6 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow">
                                <h3 class="text-lg font-medium text-gray-800 dark:text-white mb-2">Leave a Review</h3>
                                <form action="{{ route('reviews.store', $game) }}" method="POST" class="space-y-3">
                                    @csrf
                                    <div>
                                        <label for="rating" class="sr-only">Rating</label>
                                        <div class="flex items-center" x-data="{ rating: 0, hoverRating: 0 }">
                                            <span class="text-sm text-gray-700 dark:text-gray-300 mr-2">Your Rating:</span>
                                            <template x-for="star in 5" :key="star">
                                                <svg @click="rating = star"
                                                     @mouseenter="hoverRating = star"
                                                     @mouseleave="hoverRating = 0"
                                                     :class="{'text-yellow-400': (hoverRating || rating) >= star, 'text-gray-300 dark:text-gray-500': (hoverRating || rating) < star}"
                                                     class="w-6 h-6 cursor-pointer" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            </template>
                                            <input type="hidden" name="rating" x-model="rating">
                                        </div>
                                        @error('rating') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label for="title" class="sr-only">Review Title</label>
                                        <input type="text" name="title" id="title" placeholder="Review Title" value="{{ old('title') }}"
                                               class="w-full p-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                        @error('title') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label for="comment" class="sr-only">Your Review</label>
                                        <textarea name="comment" id="comment" rows="3" placeholder="Write your review..."
                                                  class="w-full p-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('comment') }}</textarea>
                                        @error('comment') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">Submit Review</button>
                                </form>
                            </div>
                        @else
                            <p class="text-gray-600 dark:text-gray-400 mb-4"><a href="{{ route('login') }}" class="text-indigo-600 hover:underline">Log in</a> to leave a review.</p>
                        @endauth

                        @if($game->reviews->isNotEmpty())
                            <div class="space-y-6">
                                @foreach($game->reviews()->latest()->take(5)->get() as $review) {{-- Paginate this for more reviews --}}
                                <article class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg shadow">
                                    <div class="flex items-center mb-2">
                                        {{-- User Avatar Placeholder --}}
                                        <div class="w-10 h-10 rounded-full bg-gray-300 dark:bg-gray-600 mr-3 flex items-center justify-center text-white font-semibold">
                                            {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-800 dark:text-white">{{ $review->user->name }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $review->created_at->format('M d, Y') }}</p>
                                        </div>
                                        <div class="ml-auto flex">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg class="w-5 h-5 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-500' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                            @endfor
                                        </div>
                                    </div>
                                    <h4 class="font-medium text-gray-700 dark:text-gray-200 mb-1">{{ $review->title }}</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-300">{{ nl2br(e($review->comment)) }}</p>
                                    @auth
                                        @if(Auth::id() == $review->user_id || Auth::user()->is_admin)
                                        <div class="mt-2 text-xs">
                                            {{-- Edit review form could be a modal or separate page --}}
                                            {{-- <a href="#" class="text-blue-500 hover:underline">Edit</a> - --}}
                                            <form action="{{ route('reviews.destroy', $review) }}" method="POST" class="inline" onsubmit="return confirm('Delete this review?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:underline">Delete</button>
                                            </form>
                                        </div>
                                        @endif
                                    @endauth
                                </article>
                                @endforeach
                                {{-- Add link to all reviews page if paginating --}}
                            </div>
                        @else
                            <p class="text-gray-600 dark:text-gray-400">No reviews yet. Be the first to write one!</p>
                        @endif
                    </section>

                </div>

                {{-- Sidebar Column --}}
                <aside class="lg:col-span-1 space-y-6">
                    {{-- Purchase Options / Pricing --}}
                    <div class="bg-gray-50 dark:bg-gray-700 p-5 rounded-lg shadow">
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Where to Buy</h3>
                         @if($game->latestPrice)
                            <div class="mb-4 text-center">
                                <span class="text-4xl font-bold text-indigo-600 dark:text-indigo-400">${{ number_format($game->latestPrice->price, 2) }}</span>
                                @if ($game->latestPrice->discount > 0)
                                    <span class="ml-2 text-lg text-green-600 dark:text-green-400">({{ $game->latestPrice->discount }}% off)</span>
                                @endif
                            </div>
                        @endif

                        @auth
                        <div class="mb-4">
                             @if($game->is_wishlisted)
                                <form action="{{ route('wishlist.remove', $game->id) }}" method="POST" class="w-full">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center justify-center px-4 py-2.5 border border-transparent rounded-md shadow-sm text-base font-medium text-red-700 bg-red-100 hover:bg-red-200 dark:text-red-200 dark:bg-red-700 dark:hover:bg-red-600">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
                                        Remove from Wishlist
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('wishlist.add', $game->id) }}" method="POST" class="w-full">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center justify-center px-4 py-2.5 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                        Add to Wishlist
                                    </button>
                                </form>
                            @endif
                        </div>
                        @endauth

                        @if($game->prices->isNotEmpty())
                            <ul class="space-y-3">
                                @foreach($game->prices->sortByDesc('date')->groupBy(['platform.name', 'store.name']) as $platformName => $stores)
                                    @foreach($stores as $storeName => $platformPrices)
                                        @php $latestPlatformPrice = $platformPrices->first(); @endphp
                                        <li class="flex justify-between items-center p-3 bg-white dark:bg-gray-600 rounded-md shadow-sm">
                                            <div>
                                                <span class="font-medium text-gray-700 dark:text-gray-200">{{ $latestPlatformPrice->platform->name }}</span>
                                                <span class="text-xs text-gray-500 dark:text-gray-400 block">{{ $latestPlatformPrice->store->name }}</span>
                                            </div>
                                            <div class="text-right">
                                                <span class="font-semibold text-indigo-600 dark:text-indigo-400">${{ number_format($latestPlatformPrice->price, 2) }}</span>
                                                @if($latestPlatformPrice->discount > 0)
                                                <span class="text-xs text-green-500 dark:text-green-400 block">({{ $latestPlatformPrice->discount }}% off)</span>
                                                @endif
                                            </div>
                                        </li>
                                    @endforeach
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-600 dark:text-gray-400">No pricing information available yet.</p>
                        @endif
                    </div>

                    {{-- Game Details --}}
                    <div class="bg-gray-50 dark:bg-gray-700 p-5 rounded-lg shadow">
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Details</h3>
                        <dl class="space-y-3">
                            @if($game->developer)
                            <div class="flex justify-between">
                                <dt class="text-sm font-medium text-gray-600 dark:text-gray-400">Developer:</dt>
                                <dd class="text-sm text-gray-800 dark:text-gray-200">{{ $game->developer->name }}</dd>
                            </div>
                            @endif
                            {{-- Add Publisher if you have that model/relation --}}
                            {{-- <div class="flex justify-between">
                                <dt class="text-sm font-medium text-gray-600 dark:text-gray-400">Release Date:</dt>
                                <dd class="text-sm text-gray-800 dark:text-gray-200">{{ $game->release_date ? $game->release_date->format('M d, Y') : 'TBA' }}</dd>
                            </div> --}}
                            @if($game->tags->isNotEmpty())
                            <div>
                                <dt class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Tags:</dt>
                                <dd class="flex flex-wrap gap-2">
                                    @foreach($game->tags as $tag)
                                    <span class="px-2 py-0.5 text-xs font-semibold text-indigo-700 bg-indigo-100 dark:text-indigo-200 dark:bg-indigo-700 rounded-full">{{ $tag->name }}</span>
                                    @endforeach
                                </dd>
                            </div>
                            @endif
                             @if($game->average_rating)
                            <div class="flex justify-between items-center">
                                <dt class="text-sm font-medium text-gray-600 dark:text-gray-400">Avg. Rating:</dt>
                                <dd class="text-sm text-gray-800 dark:text-gray-200 flex items-center">
                                    <span class="mr-1 font-semibold">{{ number_format($game->average_rating, 1) }} / 5</span>
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                </dd>
                            </div>
                            @endif
                        </dl>
                    </div>
                </aside>
            </div>
        </div>
    </div>

    {{-- Related Games Section --}}
    @if($relatedGames->isNotEmpty())
    <section class="mt-12">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6">You Might Also Like</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-6 gap-y-8">
            @foreach($relatedGames as $relatedGame)
                @include('partials._game_card', ['game' => $relatedGame])
            @endforeach
        </div>
    </section>
    @endif

</x-layouts.v-main-layout>

@push('styles')
{{-- For image gallery lightbox (e.g., Fancybox) --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css"/>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
<script>
  Fancybox.bind("[data-fancybox]", {
    // Your custom options
  });
</script>
@endpush
