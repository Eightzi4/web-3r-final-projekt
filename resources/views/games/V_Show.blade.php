<x-layouts.v-main-layout>
    <x-slot name="title">{{ $game->name }}</x-slot>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-3xl font-bold">{{ $game->name }}</h1>
                    <p class="text-gray-600">by {{ $game->developer->name }}</p>
                </div>
                <div>
                    <span
                        class="px-3 py-1 rounded-full text-sm font-semibold {{ $game->visible ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $game->visible ? 'Visible' : 'Hidden' }}
                    </span>
                </div>
            </div>

            @if ($game->trailer_link)
                <div class="mt-4 aspect-w-16 aspect-h-9">
                    <iframe class="w-full h-96" src="{{ $game->trailer_link }}" frameborder="0" allowfullscreen></iframe>
                </div>
            @endif

            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2">
                    <h2 class="text-xl font-semibold mb-2">Description</h2>
                    <p class="text-gray-700 whitespace-pre-line">{{ $game->description ?? 'No description provided.' }}
                    </p>

                    <h2 class="text-xl font-semibold mt-6 mb-2">Tags</h2>
                    <div class="flex flex-wrap gap-2">
                        @forelse($game->tags as $tag)
                            <span class="px-3 py-1 rounded-full text-sm font-medium"
                                style="background-color: #{{ dechex($tag->color) }}; color: white;">
                                {{ $tag->name }}
                            </span>
                        @empty
                            <p class="text-gray-500">No tags assigned</p>
                        @endforelse
                    </div>

                    <h2 class="text-xl font-semibold mt-6 mb-2">Game States</h2>
                    <div class="flex flex-wrap gap-2">
                        @forelse($game->gameStates as $state)
                            <span class="px-3 py-1 rounded-full text-sm font-medium bg-gray-200 text-gray-800">
                                {{ $state->name }}
                            </span>
                        @empty
                            <p class="text-gray-500">No states assigned</p>
                        @endforelse
                    </div>
                </div>

                <div>
                    <h2 class="text-xl font-semibold mb-2">Pricing</h2>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        @foreach ($game->prices->groupBy('platforms_id') as $platformId => $prices)
                            @php $platform = $prices->first()->platform; @endphp
                            <div class="mb-4">
                                <h3 class="font-medium">{{ $platform->name }}</h3>
                                <ul class="mt-2 space-y-2">
                                    @foreach ($prices as $price)
                                        <li class="flex justify-between">
                                            <span>{{ $price->store->name }}:</span>
                                            <span class="font-medium">
                                                @if ($price->discount > 0)
                                                    <span
                                                        class="text-gray-500 line-through mr-2">${{ number_format($price->price, 2) }}</span>
                                                    <span
                                                        class="text-red-600">${{ number_format($price->price * (1 - $price->discount / 100), 2) }}</span>
                                                    <span
                                                        class="text-xs bg-red-100 text-red-800 px-1 rounded ml-1">-{{ $price->discount }}%</span>
                                                @else
                                                    ${{ number_format($price->price, 2) }}
                                                @endif
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>

                    <h2 class="text-xl font-semibold mt-6 mb-2">Images</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-2 mt-2">
                        @foreach ($game->images as $image)
                            <div class="relative group">
                                <img src="{{ asset('storage/' . $image->image) }}" alt="Game image"
                                    class="w-full h-24 object-cover rounded">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3">
            <a href="{{ route('games.edit', $game->id) }}"
                class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <a href="{{ route('games.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                <i class="fas fa-arrow-left mr-2"></i>Back to List
            </a>
        </div>
    </div>
</x-layouts.v-main-layout>
