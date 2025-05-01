<x-layouts.v-main-layout>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($games as $game)
            @include('partials._game_card', ['game' => $game])
        @endforeach
    </div>

    <div class="mt-6">
        {{ $games->links() }}
    </div>
</x-layouts.v-main-layout>
