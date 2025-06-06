{{-- Main layout component for displaying a single game page --}}
<x-layouts.v-main :title="$game->name" :breadcrumbs="$breadcrumbs">

    <div class="bg-white dark:bg-gray-800 shadow-2xl rounded-xl overflow-hidden">
        {{-- Game Header section with banner image and title --}}
        <div class="relative">
            @if ($game->images->isNotEmpty())
                <img src="{{ asset('storage/images/' . $game->images->first()->image) }}" alt="{{ $game->name }} banner"
                    class="w-full h-72 md:h-[500px] object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
            @else
                <div
                    class="w-full h-72 md:h-[500px] bg-gray-300 dark:bg-gray-700 flex flex-col items-center justify-center text-center p-4">
                    <svg class="w-24 h-24 text-gray-400 dark:text-gray-500 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <span class="text-gray-500 dark:text-gray-400 text-2xl font-semibold">No Image Available</span>
                    <span class="text-gray-400 dark:text-gray-500 text-sm mt-1">This game is awaiting its
                        spotlight.</span>
                </div>
            @endif
            <div class="absolute bottom-0 left-0 p-6 md:p-10">
                <h1 class="text-4xl md:text-6xl font-bold text-white [text-shadow:0_2px_4px_rgba(0,0,0,0.5)]">
                    {{ $game->name }}</h1>
                @if ($game->developer)
                    <p class="text-xl md:text-2xl text-gray-200 mt-1.5 [text-shadow:0_1px_3px_rgba(0,0,0,0.5)]">
                        by <a href="#" class="hover:underline font-medium">{{ $game->developer->name }}</a>
                    </p>
                @endif
            </div>
        </div>

        {{-- Main content area for game details, trailer, reviews, etc. --}}
        <div class="p-6 md:p-8 lg:p-10">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-x-8 gap-y-10 lg:gap-x-12">
                {{-- Left column for primary game content --}}
                <div class="lg:col-span-2 space-y-10 md:space-y-12">
                    {{-- Game Trailer section --}}
                    @if ($game->trailer_link)
                        @php
                            $embedUrl = '';
                            if (str_contains($game->trailer_link, 'youtube.com/watch?v=')) {
                                $videoId = substr($game->trailer_link, strpos($game->trailer_link, 'v=') + 2);
                                if (strpos($videoId, '&') !== false) {
                                    $videoId = substr($videoId, 0, strpos($videoId, '&'));
                                }
                                $embedUrl = 'https://www.youtube.com/embed/' . $videoId;
                            } elseif (str_contains($game->trailer_link, 'youtu.be/')) {
                                $videoId = substr($game->trailer_link, strpos($game->trailer_link, 'youtu.be/') + 9);
                                $embedUrl = 'https://www.youtube.com/embed/' . $videoId;
                            }
                        @endphp

                        @if ($embedUrl)
                            <section>
                                <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-4">Trailer</h2>
                                <div
                                    class="aspect-w-16 aspect-h-9 rounded-xl overflow-hidden shadow-xl border border-gray-200 dark:border-gray-700">
                                    <iframe src="{{ $embedUrl }}" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen class="w-full h-full"></iframe>
                                </div>
                            </section>
                        @else
                            <section>
                                <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-4">Trailer</h2>
                                <p
                                    class="text-sm text-gray-600 dark:text-gray-400 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    Trailer link: <a href="{{ $game->trailer_link }}" target="_blank"
                                        class="text-indigo-600 hover:underline">{{ $game->trailer_link }}</a> (Could not
                                    generate embed link)
                                </p>
                            </section>
                        @endif
                    @endif

                    {{-- Game Description section --}}
                    <section>
                        <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-4">About This Game</h2>
                        <div
                            class="prose prose-lg dark:prose-invert max-w-none text-gray-700 dark:text-gray-300 leading-relaxed">
                            {!! nl2br(e($game->description)) !!}
                        </div>
                    </section>

                    {{-- Image Gallery section --}}
                    @if ($game->images->count() > 1)
                        <section>
                            <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-4">Gallery</h2>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 md:gap-5">
                                @foreach ($game->images as $image)
                                    @if (!$loop->first)
                                        <a href="{{ asset('storage/images/' . $image->image) }}" data-fancybox="gallery"
                                            class="block rounded-lg overflow-hidden shadow-lg hover:shadow-2xl transition-shadow duration-300 aspect-w-16 aspect-h-9">
                                            <img src="{{ asset('storage/images/' . $image->image) }}"
                                                alt="Screenshot {{ $loop->iteration }}"
                                                class="w-full h-full object-cover">
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </section>
                    @endif

                    {{-- User Reviews section --}}
                    <section id="reviews" class="pt-6 border-t border-gray-200 dark:border-gray-700">
                        <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6">User Reviews
                            ({{ $game->reviews->count() }})</h2>

                        @auth
                            {{-- Review submission form for authenticated users --}}
                            <div class="mb-8 bg-gray-50 dark:bg-gray-800/60 p-5 md:p-6 rounded-xl shadow-xl">
                                <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Leave a Review</h3>
                                <form action="{{ route('reviews.store', $game) }}" method="POST" class="space-y-4"
                                    id="review-form">
                                    @csrf
                                    <div class="flex items-center space-x-2" x-data="{ rating: {{ old('rating', 0) }}, hoverRating: 0 }">
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Your
                                            Rating:</span>
                                        <div class="flex">
                                            <template x-for="star in 5" :key="star">
                                                <button type="button" @click="rating = star"
                                                    @mouseenter="hoverRating = star" @mouseleave="hoverRating = 0"
                                                    :class="{ 'text-yellow-400': (hoverRating || rating) >=
                                                        star, 'text-gray-300 dark:text-gray-600 hover:text-yellow-300': (
                                                            hoverRating || rating) < star }"
                                                    class="w-7 h-7 cursor-pointer transition-colors">
                                                    <svg class="w-full h-full" fill="currentColor" viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                </button>
                                            </template>
                                        </div>
                                        <input type="hidden" name="rating" x-model="rating">
                                    </div>
                                    @error('rating')
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror

                                    <div>
                                        <label for="review_title"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Review
                                            Title</label>
                                        <input type="text" name="title" id="review_title"
                                            placeholder="e.g., A Masterpiece!" value="{{ old('title') }}"
                                            class="w-full p-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                        @error('title')
                                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="review_comment_quill"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Your
                                            Review</label>
                                        <div id="quill-editor-container" style="min-height: 150px;">{!! old('comment') !!}
                                        </div>
                                        <input type="hidden" name="comment" id="review_comment_quill">
                                        @error('comment')
                                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <button type="submit"
                                        class="px-6 py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-lg shadow-md hover:bg-indigo-700 transition-colors">Submit
                                        Review</button>
                                </form>
                            </div>
                        @else
                            {{-- Prompt for non-authenticated users to log in or register --}}
                            <div class="mb-8 p-6 bg-gray-100 dark:bg-slate-800 rounded-xl shadow-lg text-center">
                                <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-3">Want to share your
                                    thoughts?</h3>
                                <p class="text-gray-600 dark:text-gray-300 mb-5">
                                    <a href="{{ route('login', ['redirect' => url()->current()]) }}"
                                        class="text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300 font-semibold hover:underline">Log
                                        in</a>
                                    or
                                    <a href="{{ route('register', ['redirect' => url()->current()]) }}"
                                        class="text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300 font-semibold hover:underline">create
                                        an account</a>
                                    to leave a review.
                                </p>
                            </div>
                        @endauth

                        {{-- Display existing game reviews --}}
                        @if ($game->reviews->isNotEmpty())
                            <div class="space-y-8">
                                @foreach ($game->reviews()->latest()->take(5)->get() as $review)
                                    <article class="p-5 md:p-6 bg-gray-50 dark:bg-gray-700/50 rounded-xl shadow-lg">
                                        <div class="flex items-start mb-3">
                                            <div
                                                class="flex-shrink-0 w-12 h-12 rounded-full bg-indigo-500 dark:bg-indigo-600 mr-4 flex items-center justify-center text-white text-xl font-bold">
                                                {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                            </div>
                                            <div class="flex-grow">
                                                <p class="font-semibold text-lg text-gray-800 dark:text-white">
                                                    {{ $review->user->name }}</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $review->created_at->diffForHumans() }}</p>
                                            </div>
                                            <div class="ml-auto flex pt-1">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <svg class="w-5 h-5 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}"
                                                        fill="currentColor" viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                        </path>
                                                    </svg>
                                                @endfor
                                            </div>
                                        </div>
                                        <h4 class="font-semibold text-md text-gray-700 dark:text-gray-200 mb-2">
                                            {{ $review->title }}</h4>
                                        <div class="trix-content">
                                            {!! $review->comment !!}
                                        </div>
                                        @auth
                                            @if (Auth::id() == $review->user_id || Auth::user()->is_admin)
                                                <div class="mt-3 text-xs flex justify-end">
                                                    <form action="{{ route('reviews.destroy', $review) }}" method="POST"
                                                        class="inline" onsubmit="return confirm('Delete this review?')">
                                                        @csrf @method('DELETE')
                                                        <button type="submit"
                                                            class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 hover:underline">Delete
                                                            Review</button>
                                                    </form>
                                                </div>
                                            @endif
                                        @endauth
                                    </article>
                                @endforeach
                            </div>
                        @else
                            <p
                                class="text-gray-600 dark:text-gray-400 p-4 bg-gray-100 dark:bg-gray-700/30 rounded-lg text-center">
                                Be the first to review this game!
                            </p>
                        @endif
                    </section>
                </div>

                {{-- Right sidebar column for pricing, wishlist, and game details --}}
                <aside class="lg:col-span-1 space-y-8">
                    {{-- Pricing and Wishlist box --}}
                    <div class="bg-gray-100 dark:bg-gray-700/50 p-6 rounded-xl shadow-xl sticky top-24">
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-5 text-center">Pricing & Wishlist
                        </h3>
                        @if ($game->latestPrice)
                            <div class="mb-6 text-center">
                                <span
                                    class="text-5xl font-extrabold text-indigo-600 dark:text-indigo-400">${{ number_format($game->latestPrice->price, 2) }}</span>
                                @if ($game->latestPrice->discount > 0)
                                    <div class="mt-1">
                                        <span
                                            class="text-lg text-green-600 dark:text-green-400 font-semibold">({{ $game->latestPrice->discount }}%
                                            OFF)</span>
                                        <span class="ml-2 text-md text-gray-500 dark:text-gray-400 line-through">
                                            ${{ number_format($game->latestPrice->price / (1 - $game->latestPrice->discount / 100), 2) }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        @endif

                        @auth
                            <div class="mb-6 space-y-3">
                                @if ($game->is_wishlisted)
                                    <form action="{{ route('wishlist.remove', $game->id) }}" method="POST"
                                        class="w-full">
                                        @csrf
                                        <button type="submit"
                                            class="w-full flex items-center justify-center px-6 py-3 border border-red-300 dark:border-red-600 rounded-lg shadow-md text-base font-medium text-red-700 dark:text-red-300 bg-red-50 dark:bg-red-700/30 hover:bg-red-100 dark:hover:bg-red-700/50 transition-colors">
                                            <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            In Wishlist
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('wishlist.add', $game->id) }}" method="POST" class="w-full">
                                        @csrf
                                        <button type="submit"
                                            class="w-full flex items-center justify-center px-6 py-3 border border-transparent rounded-lg shadow-md text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 transition-colors">
                                            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                                </path>
                                            </svg>
                                            Add to Wishlist
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endauth

                        @if ($game->prices->isNotEmpty())
                            <h4 class="text-md font-semibold text-gray-700 dark:text-gray-300 mb-3">Available on:</h4>
                            <ul class="space-y-3">
                                @foreach ($game->prices->sortByDesc('date')->unique(function ($item) {
            return $item['platform_id'] . '-' . $item['store_id'];
        })->take(5) as $priceInfo)
                                    <li
                                        class="flex justify-between items-center p-3.5 bg-white dark:bg-gray-600 rounded-lg shadow">
                                        <div>
                                            <span
                                                class="font-semibold text-gray-800 dark:text-gray-100 block">{{ $priceInfo->platform->name }}</span>
                                            @if ($priceInfo->store->website_link)
                                                <a href="{{ $priceInfo->store->website_link }}" target="_blank"
                                                    rel="noopener noreferrer"
                                                    class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline block">
                                                    via {{ $priceInfo->store->name }}
                                                </a>
                                            @else
                                                <span class="text-xs text-gray-500 dark:text-gray-400 block">via
                                                    {{ $priceInfo->store->name }}</span>
                                            @endif
                                        </div>
                                        <div class="text-right">
                                            <span
                                                class="font-bold text-lg text-indigo-700 dark:text-indigo-300">${{ number_format($priceInfo->price, 2) }}</span>
                                            @if ($priceInfo->discount > 0)
                                                <span
                                                    class="text-xs text-green-600 dark:text-green-400 block">({{ $priceInfo->discount }}%
                                                    off)</span>
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-600 dark:text-gray-400 text-sm text-center py-3">No specific pricing
                                information available yet.</p>
                        @endif
                    </div>

                    {{-- Game Details box (developer, rating, tags) --}}
                    <div class="bg-gray-100 dark:bg-gray-700/50 p-6 rounded-xl shadow-xl">
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-5">Game Details</h3>
                        <dl class="space-y-4">
                            @if ($game->developer)
                                <div
                                    class="flex justify-between items-center border-b border-gray-200 dark:border-gray-600 pb-2">
                                    <dt class="text-sm font-medium text-gray-600 dark:text-gray-400">Developer</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100 font-semibold text-right">
                                        <a href="{{ route('developers.show', $game->developer) }}"
                                            class="hover:underline font-medium">{{ $game->developer->name }}</a>
                                    </dd>
                                </div>
                            @endif
                            @if ($game->average_rating)
                                <div
                                    class="flex justify-between items-center border-b border-gray-200 dark:border-gray-600 pb-2">
                                    <dt class="text-sm font-medium text-gray-600 dark:text-gray-400">Average Rating
                                    </dt>
                                    <dd
                                        class="text-sm text-gray-900 dark:text-gray-100 flex items-center font-semibold">
                                        <span class="mr-1.5">{{ number_format($game->average_rating, 1) }} / 5</span>
                                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                    </dd>
                                </div>
                            @endif
                            @if ($game->tags->isNotEmpty())
                                <div class="pt-2">
                                    <dt class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">Tags</dt>
                                    <dd class="flex flex-wrap gap-2">
                                        @foreach ($game->tags as $tag)
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
                                    </dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                </aside>
            </div>
        </div>
    </div>

    {{-- Related Games section --}}
    @if ($relatedGames->isNotEmpty())
        <section class="mt-16">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-white mb-8 text-center">You Might Also Like</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-6 gap-y-10">
                @foreach ($relatedGames as $relatedGame)
                    @include('partials._game_card', ['game' => $relatedGame])
                @endforeach
            </div>
        </section>
    @endif

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/quill@1.3.6/dist/quill.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                const editorContainer = document.getElementById('quill-editor-container');
                const hiddenInput = document.getElementById('review_comment_quill');
                const reviewForm = document.getElementById('review-form');

                if (editorContainer) {
                    try {
                        var quill = new Quill('#quill-editor-container', {
                            theme: 'snow',
                            modules: {
                                toolbar: [
                                    [{
                                        'header': [1, 2, 3, false]
                                    }],
                                    ['bold', 'italic', 'underline', 'strike'],
                                    ['blockquote', 'code-block'],
                                    [{
                                        'list': 'ordered'
                                    }, {
                                        'list': 'bullet'
                                    }],
                                    [{
                                        'indent': '-1'
                                    }, {
                                        'indent': '+1'
                                    }],
                                    ['link', 'image', 'video'],
                                    ['clean']
                                ]
                            },
                            placeholder: 'Share your thoughts about this game...'
                        });

                        if (hiddenInput) {
                            quill.on('text-change', function(delta, oldDelta, source) {
                                let htmlContent = quill.root.innerHTML;
                                hiddenInput.value = (htmlContent === '<p><br></p>') ? '' : htmlContent;
                            });
                        } else {
                            console.error('Hidden input for Quill comment not found!');
                        }

                        if (reviewForm && hiddenInput) {
                            reviewForm.addEventListener('submit', function() {
                                let htmlContent = quill.root.innerHTML;
                                hiddenInput.value = (htmlContent === '<p><br></p>') ? '' : htmlContent;
                                console.log('Form submit, hidden input value set to:', hiddenInput.value);
                            });
                        } else {
                            if (!reviewForm) console.error('Review form not found!');
                            if (!hiddenInput) console.error(
                                'Hidden input for Quill comment not found (in form submit)!');
                        }

                    } catch (e) {
                        console.error('Error initializing Quill:', e);
                    }
                }
            });
        </script>
    @endpush

</x-layouts.v-main>
