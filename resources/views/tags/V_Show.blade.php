<x-layouts.v-main-layout :title="'Games tagged with: ' . $tag->name" :breadcrumbs="$breadcrumbs">
    <div class="py-6">
        <header class="mb-8 text-center">
            <div class="inline-block px-4 py-2 rounded-lg text-white mb-3" style="background-color: {{ $tag->color ?? '#6366f1' }};">
                <h1 class="text-3xl md:text-4xl font-bold">{{ $tag->name }}</h1>
            </div>
            @if($tag->description)
                <p class="mt-2 text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">{{ $tag->description }}</p>
            @endif
        </header>

        <section>
            <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200 mb-6 text-center">Games with this tag ({{ $games->total() }})</h2>
             @if($games->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-6 gap-y-10">
                    @foreach ($games as $game)
                        @include('partials._game_card', ['game' => $game])
                    @endforeach
                </div>
                <div class="mt-10">
                    {{ $games->links() }}
                </div>
            @else
                <p class="text-center text-gray-500 dark:text-gray-400">No games found with this tag.</p>
            @endif
        </section>
    </div>
</x-layouts.v-main-layout>
