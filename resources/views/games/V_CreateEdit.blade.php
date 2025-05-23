<x-layouts.v-main-layout :title="$game->exists ? 'Edit Game: ' . $game->name : 'Add New Game'" :breadcrumbs="$breadcrumbs">

    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg p-6 md:p-8">
        <h1 class="text-3xl font-bold mb-8 text-gray-800 dark:text-white">{{ $game->exists ? 'Edit Game' : 'Add New Game' }}</h1>

        {{-- Session messages are handled by the layout now --}}

        <form method="POST" action="{{ $game->exists ? route('admin.games.update', $game) : route('admin.games.store') }}"
            enctype="multipart/form-data" class="space-y-8" x-data="{
                priceEntries: {{ $game->exists && $game->prices->count() > 0
                    ? json_encode(
                        $game->prices->map(function ($price) {
                            return [
                                'platform_id' => (string) $price->platform_id, // Ensure string for Alpine model
                                'store_id' => (string) $price->store_id,     // Ensure string
                                'price' => $price->price,
                                'discount' => $price->discount,
                            ];
                        })->toArray(),
                    )
                    : json_encode([['platform_id' => '', 'store_id' => '', 'price' => '', 'discount' => '']]) }},
                allPlatforms: {{ json_encode($platforms->map->only(['id', 'name'])) }},
                allStores: {{ json_encode($stores->map->only(['id', 'name'])) }},
                selectedTags: {{ json_encode(old('tags') ? explode(',', old('tags')) : ($selectedTags ?? [])) }},
                newTag: '',
                allTagObjects: {{ json_encode($tags->map->only(['id', 'name'])) }}, // For potential future use with IDs
                availableTags() {
                    return this.allTagObjects.map(t => t.name).filter(t => !this.selectedTags.includes(t))
                },
                addTag(tag) {
                    if (tag.trim() !== '' && !this.selectedTags.includes(tag.trim())) {
                        this.selectedTags.push(tag.trim());
                    }
                    this.newTag = '';
                },
                removeTag(tag) {
                    this.selectedTags = this.selectedTags.filter(t => t !== tag);
                }
            }"
            x-init="
                @if (is_array(old('prices')))
                    priceEntries = {{ json_encode(collect(old('prices'))->map(function($p) {
                        return [
                            'platform_id' => (string)($p['platform_id'] ?? ''),
                            'store_id' => (string)($p['store_id'] ?? ''),
                            'price' => $p['price'] ?? '',
                            'discount' => $p['discount'] ?? '',
                        ];
                    })->toArray()) }};
                @endif
            ">
            @csrf
            @if ($game->exists)
                @method('PUT')
            @endif

            {{-- Basic Info Section --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name *</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $game->name ?? '') }}"
                        class="w-full p-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror" required>
                    @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="developer_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Developer *</label>
                    <select name="developer_id" id="developer_id" required class="w-full p-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('developer_id') border-red-500 @enderror">
                        <option value="">Select Developer</option>
                        @foreach ($developers as $developer)
                            <option value="{{ $developer->id }}"
                                {{ old('developer_id', $game->developer_id ?? '') == $developer->id ? 'selected' : '' }}>
                                {{ $developer->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('developer_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                <textarea name="description" id="description" rows="4"
                    class="w-full p-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('description') border-red-500 @enderror">{{ old('description', $game->description ?? '') }}</textarea>
                @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="trailer_link" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Trailer Link (YouTube URL)</label>
                    <input type="url" name="trailer_link" id="trailer_link" value="{{ old('trailer_link', $game->trailer_link ?? '') }}" placeholder="https://www.youtube.com/watch?v=..."
                        class="w-full p-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('trailer_link') border-red-500 @enderror">
                    @error('trailer_link') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="visible" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Visibility *</label>
                    <select name="visible" id="visible" class="w-full p-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('visible') border-red-500 @enderror" required>
                        <option value="1" {{ old('visible', $game->exists ? $game->visible : true) == '1' ? 'selected' : '' }}>Visible</option>
                        <option value="0" {{ old('visible', $game->exists ? $game->visible : true) == '0' ? 'selected' : '' }}>Hidden</option>
                    </select>
                    @error('visible') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Tags Section --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tags</label>
                <input type="hidden" name="tags" :value="selectedTags.join(',')">
                <div class="flex items-center border border-gray-300 dark:border-gray-600 rounded-md p-1">
                    <div class="flex flex-wrap gap-1 p-1 flex-grow">
                        <template x-for="tag in selectedTags" :key="tag">
                            <span class="bg-indigo-100 dark:bg-indigo-700 text-indigo-700 dark:text-indigo-200 px-2 py-1 rounded-full text-sm flex items-center">
                                <span x-text="tag"></span>
                                <button type="button" @click="removeTag(tag)" class="ml-1.5 text-indigo-500 dark:text-indigo-300 hover:text-indigo-700 dark:hover:text-indigo-100">&times;</button>
                            </span>
                        </template>
                    </div>
                    <div x-data="{ open: false }" class="relative">
                         <input type="text" x-model="newTag" @keydown.enter.prevent="addTag(newTag); $event.target.focus()" @focus="open = true" @blur="setTimeout(() => open = false, 200)" placeholder="Add or select tag"
                                class="p-2 border-none focus:ring-0 dark:bg-gray-700 dark:text-gray-200 min-w-[150px]">
                        <div x-show="open && availableTags().length > 0" class="absolute z-10 w-full mt-1 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-lg max-h-40 overflow-auto">
                            <template x-for="availTag in availableTags()" :key="availTag">
                                <div @click="addTag(availTag); open = false;" class="px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 cursor-pointer" x-text="availTag"></div>
                            </template>
                        </div>
                    </div>
                     <button type="button" @click="addTag(newTag)" class="ml-2 px-3 py-2 bg-indigo-500 text-white text-sm rounded-md hover:bg-indigo-600">Add</button>
                </div>
                 @error('tags') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Type a tag and press Enter or click Add. Existing tags can be selected from the dropdown.</p>
            </div>


            {{-- Image Upload Section --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Images</label>
                <input type="file" name="images[]" multiple accept="image/*" class="block w-full text-sm text-gray-500 dark:text-gray-400
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-full file:border-0
                    file:text-sm file:font-semibold
                    file:bg-indigo-50 dark:file:bg-indigo-800 file:text-indigo-700 dark:file:text-indigo-200
                    hover:file:bg-indigo-100 dark:hover:file:bg-indigo-700 @error('images.*') border-red-500 @enderror">
                @error('images.*') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                @error('images') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror


                @if ($game->exists && $game->images->isNotEmpty())
                    <div class="mt-4">
                        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Current Images:</h4>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                            @foreach ($game->images as $image)
                                <div class="relative group" x-data="{ showDelete: false }">
                                    <img src="{{ asset('storage/' . $image->image) }}" alt="Game image {{ $loop->iteration }}" class="w-full h-32 object-cover rounded-md shadow">
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-opacity flex items-center justify-center">
                                         <label :for="'delete_image_{{ $image->id }}'" class="hidden group-hover:flex items-center p-1.5 bg-red-600 text-white rounded-full cursor-pointer hover:bg-red-700 transition-colors">
                                            <input type="checkbox" name="delete_images[]" value="{{ $image->id }}" id="delete_image_{{ $image->id }}" class="opacity-0 absolute h-0 w-0 peer">
                                            <svg class="w-4 h-4 peer-checked:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            <svg class="w-4 h-4 hidden peer-checked:block" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                            <span class="ml-1 text-xs peer-checked:hidden">Mark to Delete</span>
                                            <span class="ml-1 text-xs hidden peer-checked:block">Marked</span>
                                        </label>
                                        {{-- Keep this for direct delete if preferred, but checkbox allows batch delete on save --}}
                                        {{-- <form action="{{ route('admin.game-images.destroy', $image->id) }}" method="POST" onsubmit="return confirm('Delete this image?')"
                                              class="absolute top-1 right-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-1.5 bg-red-600 text-white rounded-full hover:bg-red-700 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                        </form> --}}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Select images to delete them upon saving changes.</p>
                    </div>
                @endif
            </div>


            {{-- Prices Section --}}
            <div class="space-y-6 border-t border-gray-200 dark:border-gray-700 pt-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Pricing Information *</h3>
                @error('prices') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                <template x-for="(price, index) in priceEntries" :key="index">
                    <div class="border border-gray-200 dark:border-gray-700 p-4 rounded-lg shadow-sm bg-gray-50 dark:bg-gray-700/30 space-y-4">
                        <div class="flex justify-between items-center">
                            <h4 class="font-medium text-gray-700 dark:text-gray-300">Price Entry #<span x-text="index + 1"></span></h4>
                            <button type="button" @click="priceEntries.splice(index, 1)"
                                class="text-sm text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 font-medium" x-show="priceEntries.length > 1">
                                Remove Entry
                            </button>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-4">
                            <div>
                                <label :for="'platform_' + index" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Platform *</label>
                                <select x-model="price.platform_id" :name="`prices[${index}][platform_id]`" :id="'platform_' + index"
                                    class="w-full p-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                    <option value="">Select Platform</option>
                                    <template x-for="platform in allPlatforms" :key="platform.id">
                                        <option :value="platform.id" x-text="platform.name"></option>
                                    </template>
                                </select>
                            </div>

                            <div>
                                <label :for="'store_' + index" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Store *</label>
                                <select x-model="price.store_id" :name="`prices[${index}][store_id]`" :id="'store_' + index"
                                    class="w-full p-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                    <option value="">Select Store</option>
                                    <template x-for="store in allStores" :key="store.id">
                                        <option :value="store.id" x-text="store.name"></option>
                                    </template>
                                </select>
                            </div>

                            <div>
                                <label :for="'price_val_' + index" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Price ($) *</label>
                                <input type="number" step="0.01" min="0" x-model="price.price" :name="`prices[${index}][price]`" :id="'price_val_' + index"
                                    class="w-full p-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                            </div>

                            <div>
                                <label :for="'discount_' + index" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Discount (%)</label>
                                <input type="number" step="1" min="0" max="100" x-model="price.discount" :name="`prices[${index}][discount]`" :id="'discount_' + index"
                                    class="w-full p-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                        </div>
                    </div>
                </template>

                <button type="button"
                    @click="priceEntries.push({ platform_id: '', store_id: '', price: '', discount: '' })"
                    class="mt-2 px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-md hover:bg-gray-300 dark:hover:bg-gray-500 text-sm font-medium">
                    Add Another Price Entry
                </button>
            </div>

            {{-- Submit Button --}}
            <div class="pt-6 border-t border-gray-200 dark:border-gray-700 flex justify-end">
                <button type="submit" class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-md shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                    {{ $game->exists ? 'Update Game' : 'Add Game' }}
                </button>
            </div>
        </form>
    </div>
</x-layouts.v-main-layout>

@push('scripts')
<script>
    // Any page-specific JavaScript can go here if needed, for example, for a rich text editor.
</script>
@endpush
