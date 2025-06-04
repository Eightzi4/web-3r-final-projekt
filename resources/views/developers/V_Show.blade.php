{{-- Main layout component for displaying a developer's page --}}
<x-layouts.v-main :title="$developer->name" :breadcrumbs="$breadcrumbs">
    <div class="py-6">
        {{-- Developer information header --}}
        <header class="mb-8 text-center">
            <h1 class="text-4xl font-bold text-gray-800 dark:text-white">{{ $developer->name }}</h1>
            @if($developer->country)
                <p class="text-lg text-gray-600 dark:text-gray-400 mt-1">Based in {{ $developer->country->name }}</p>
            @endif
            @if($developer->founded_date)
                <p class="text-sm text-gray-500 dark:text-gray-300">Founded: {{ \Carbon\Carbon::parse($developer->founded_date)->format('M Y') }}</p>
            @endif
            @if($developer->website_link)
                <p class="mt-2"><a href="{{ $developer->website_link }}" target="_blank" rel="noopener noreferrer" class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 hover:underline">Visit Website</a></p>
            @endif
        </header>

        {{-- Developer description section --}}
        @if($developer->description)
        <section class="mb-10 max-w-3xl mx-auto">
            <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200 mb-3">About {{ $developer->name }}</h2>
            <div class="prose dark:prose-invert max-w-none">
                {{ $developer->description }}
            </div>
        </section>
        @endif

        {{-- Developer images gallery section --}}
        @if($developer->images->isNotEmpty())
        <section class="mb-10">
            <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200 mb-4 text-center">Gallery</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                @foreach($developer->images as $image)
                <a href="{{ asset('storage/images/' . $image->image) }}" data-fancybox="dev-gallery" class="block rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-shadow aspect-w-16 aspect-h-9">
                    <img src="{{ asset('storage/images/' . $image->image) }}" alt="{{ $developer->name }} image" class="w-full h-full object-cover">
                </a>
                @endforeach
            </div>
        </section>
        @endif

        {{-- Games by developer section --}}
        <section>
            <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200 mb-6 text-center">Games by {{ $developer->name }} ({{ $games->total() }})</h2>
            @if($games->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-6 gap-y-10">
                    @foreach ($games as $game)
                        @include('partials._game_card', ['game' => $game])
                    @endforeach
                </div>
                {{-- Pagination for games --}}
                <div class="mt-10">
                    {{ $games->links() }}
                </div>
            @else
                <p class="text-center text-gray-500 dark:text-gray-400">No games found for this developer.</p>
            @endif
        </section>
    </div>
</x-layouts.v-main>
