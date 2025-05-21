<x-layouts.v-main-layout>
    <x-slot name="title">{{ $game->exists ? 'Edit Game' : 'Add New Game' }}</x-slot>

    <h1 class="text-2xl font-bold p-6">{{ $game->exists ? 'Edit Game' : 'Add New Game' }}</h1>

    @if (session('success'))
        <div class="mx-6 mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            ✔ {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mx-6 mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            ⚠ Please fix the following errors:
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ $game->exists ? route('games.update', $game) : route('games.store') }}"
        enctype="multipart/form-data" class="p-6 space-y-6" x-data="{
            priceEntries: {{ $game->exists
                ? json_encode(
                    $game->prices->map(function ($price) {
                        return [
                            'platform_id' => $price->platform_id,
                            'store_id' => $price->store_id,
                            'price' => $price->price,
                            'discount' => $price->discount,
                        ];
                    }),
                )
                : json_encode([['platform_id' => '', 'store_id' => '', 'price' => '', 'discount' => '']]) }},
            allPlatforms: {{ json_encode($platforms) }},
            allStores: {{ json_encode($stores) }},
            selectedTags: {{ json_encode($selectedTags ?? []) }},
            allTags: {{ json_encode($tags->pluck('name')) }}
        }" x-init="@if (old('prices')) priceEntries = {{ json_encode(old('prices')) }} @endif">
        @csrf
        @if ($game->exists)
            @method('PUT')
        @endif

        <div class="space-y-6">
            <div>
                <label class="block font-medium mb-2">Name *</label>
                <input type="text" name="name" value="{{ old('name', $game->name ?? '') }}"
                    class="w-full p-2 border rounded @error('name') border-red-500 @enderror" required>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-medium mb-2">Description</label>
                <textarea name="description" rows="3"
                    class="w-full p-2 border rounded @error('description') border-red-500 @enderror">{{ old('description', $game->description ?? '') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Visibility and Name/Description (keep existing structure) -->
         <div>
            <label class="block font-medium mb-2">Visibility *</label>
            <select name="visible" class="w-full p-2 border rounded @error('visible') border-red-500 @enderror"
                required>
                <option value="1" {{ old('visible', $game->visible ?? true) ? 'selected' : '' }}>Visible</option>
                <option value="0" {{ old('visible', $game->visible ?? 0) == '0' ? 'selected' : '' }}>Hidden
                </option>
            </select>
            @error('visible')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Tags Section -->
        <div x-data="{ open: false }" class="relative">
            <h3 class="font-medium mb-2">Tags</h3>
            <input type="hidden" name="tags" :value="selectedTags.join(',')">
            <div x-data="{ open: false }" class="relative">
                <h3 class="font-medium mb-2">Tags</h3>
                <button type="button" @click="open = !open"
                    class="w-full p-2 border rounded text-left @error('tags') border-red-500 @enderror">
                    Select Tags
                </button>
                @error('tags')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <div x-show="open" @click.outside="open = false"
                    class="w-full mt-1 border rounded bg-white max-h-40 overflow-auto">
                    <template x-for="tag in allTags.filter(t => !selectedTags.includes(t))">
                        <label class="flex items-center p-2 hover:bg-gray-50">
                            <input type="checkbox" x-model="selectedTags" :value="tag" class="mr-2">
                            <span x-text="tag"></span>
                        </label>
                    </template>
                </div>
                <div class="flex flex-wrap gap-2 mt-2">
                    <template x-for="tag in selectedTags">
                        <div class="bg-blue-100 px-2 py-1 rounded flex items-center">
                            <span x-text="tag"></span>
                            <button type="button" @click="selectedTags = selectedTags.filter(t => t !== tag)"
                                class="ml-1 text-blue-600 hover:text-blue-800">×</button>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- Developer Dropdown -->
        <div>
            <label class="block font-medium mb-2">Developer *</label>
            <select name="developer_id" required class="w-full p-2 border rounded">
                @foreach ($developers as $developer)
                    <option value="{{ $developer->id }}"
                        {{ old('developer_id', $game->developer_id ?? '') == $developer->id ? 'selected' : '' }}>
                        {{ $developer->name }}
                    </option>
                @endforeach
            </select>
            @error('developer_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Image Upload -->
        <div>
            <label class="block font-medium mb-2">Images</label>
            <input type="file" name="images[]" multiple accept="image/*" class="w-full">

            @isset($game)
                <div class="grid grid-cols-3 gap-4 mt-4">
                    @foreach ($game->images as $image)
                        <div class="relative">
                            <img src="{{ asset('storage/' . $image->image) }}" class="w-full h-32 object-cover rounded">
                            <form action="{{ route('game-images.destroy', $image->id) }}" method="POST"
                                class="absolute top-1 right-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1 bg-white/80 rounded-full hover:bg-gray-100">
                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endisset
        </div>

        <!-- Prices Section -->
        <div class="space-y-4">
            <template x-for="(price, index) in priceEntries" :key="index">
                <div class="border p-4 rounded-lg space-y-4">
                    <div class="flex justify-between items-center">
                        <h3 class="font-medium">Price Entry #<span x-text="index + 1"></span></h3>
                        <button type="button" @click="priceEntries.splice(index, 1)"
                            class="text-red-600 hover:text-red-800" x-show="priceEntries.length > 1">
                            Remove
                        </button>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <!-- Platform Dropdown -->
                        <div>
                            <label class="block text-sm font-medium mb-1">Platform *</label>
                            <select x-model="price.platform_id" :name="`prices[${index}][platform_id]`"
                                class="w-full p-2 border rounded" required>
                                <option value="">Select Platform</option>
                                <template x-for="platform in allPlatforms" :key="platform.id">
                                    <option :value="platform.id" x-text="platform.name"
                                        :selected="price.platform_id == platform.id"></option>
                                </template>
                            </select>
                        </div>

                        <!-- Store Dropdown -->
                        <div>
                            <label class="block text-sm font-medium mb-1">Store *</label>
                            <select x-model="price.store_id" :name="`prices[${index}][store_id]`"
                                class="w-full p-2 border rounded" required>
                                <option value="">Select Store</option>
                                <template x-for="store in allStores" :key="store.id">
                                    <option :value="store.id" x-text="store.name"
                                        :selected="price.store_id == store.id"></option>
                                </template>
                            </select>
                        </div>

                        <!-- Price -->
                        <div>
                            <label class="block text-sm font-medium mb-1">Price *</label>
                            <input type="number" step="0.01" x-model="price.price"
                                :name="`prices[${index}][price]`" class="w-full p-2 border rounded" required>
                        </div>

                        <!-- Discount -->
                        <div>
                            <label class="block text-sm font-medium mb-1">Discount (%)</label>
                            <input type="number" x-model="price.discount" :name="`prices[${index}][discount]`"
                                class="w-full p-2 border rounded">
                        </div>
                    </div>
                </div>
            </template>

            <button type="button"
                @click="priceEntries.push({
                platform_id: '',
                store_id: '',
                price: '',
                discount: ''
            })"
                class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">
                Add Price Entry
            </button>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full bg-blue-600 text-white p-3 rounded hover:bg-blue-700">
            {{ $game->exists ? 'Update Game' : 'Add Game' }}
        </button>
    </form>
</x-layouts.v-main-layout>
