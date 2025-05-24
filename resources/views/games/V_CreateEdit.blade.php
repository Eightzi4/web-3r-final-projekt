<x-layouts.v-main-layout :title="$game->exists ? 'Edit Game: ' . $game->name : 'Add New Game'" :breadcrumbs="$breadcrumbs">

    {{-- Overall container for the form card --}}
    <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 shadow-2xl rounded-xl p-6 sm:p-8 md:p-10">
        <h1 class="text-3xl font-bold mb-8 text-gray-800 dark:text-white text-center">{{ $game->exists ? 'Edit Game' : 'Add New Game' }}</h1>

        <form method="POST" action="{{ $game->exists ? route('admin.games.update', $game) : route('admin.games.store') }}"
            enctype="multipart/form-data" class="space-y-10"
            x-data="{
                priceEntries: {{ $game->exists && $game->prices->count() > 0
                    ? json_encode(
                        $game->prices->map(function ($price) {
                            return [
                                'platform_id' => (string) $price->platform_id,
                                'store_id' => (string) $price->store_id,
                                'price' => $price->price,
                                'discount' => $price->discount,
                            ];
                        })->values()->all(), // Ensure it's a plain array for Alpine
                    )
                    : json_encode([['platform_id' => '', 'store_id' => '', 'price' => '', 'discount' => '0']]) }},
                allPlatforms: {{ json_encode($platforms->map->only(['id', 'name'])->values()->all()) }},
                allStores: {{ json_encode($stores->map->only(['id', 'name'])->values()->all()) }},
                selectedTags: {{ json_encode(old('tags') ? explode(',', old('tags')) : ($selectedTags ?? [])) }},
                newTag: '',
                // $tags is the full collection of M_Tags objects passed from the controller
                allTagObjects: {{ json_encode($tags->map->only(['id', 'name'])->values()->all()) }},
                availableTags() {
                    if (!this.allTagObjects) return []; // Guard against undefined
                    return this.allTagObjects
                               .map(t => t.name)
                               .filter(tName => tName && !this.selectedTags.includes(tName));
                },
                addTag(tagToAdd) {
                    const trimmedTag = typeof tagToAdd === 'string' ? tagToAdd.trim() : '';
                    if (trimmedTag !== '' && !this.selectedTags.includes(trimmedTag)) {
                        this.selectedTags.push(trimmedTag);
                    }
                    this.newTag = ''; // Clear the input field
                },
                removeTag(tagToRemove) {
                    this.selectedTags = this.selectedTags.filter(t => t !== tagToRemove);
                }
            }"
            x-init="
                @if (session()->has('errors') && is_array(old('prices')))
                    priceEntries = {{ json_encode(collect(old('prices'))->map(function($p) {
                        return [
                            'platform_id' => (string)($p['platform_id'] ?? ''),
                            'store_id' => (string)($p['store_id'] ?? ''),
                            'price' => $p['price'] ?? '',
                            'discount' => $p['discount'] ?? '0', // Default discount to '0' not empty string
                        ];
                    })->values()->all()) }};
                @elseif (!$game->exists || $game->prices->count() === 0)
                    // Ensure at least one empty price entry if no old input and no existing prices
                    if (priceEntries.length === 0) {
                        priceEntries.push({ platform_id: '', store_id: '', price: '', discount: '0' });
                    }
                @endif

                @if (session()->has('errors') && old('tags'))
                    selectedTags = {{ json_encode(explode(',', old('tags'))) }};
                @endif
            ">
            @csrf
            @if ($game->exists)
                @method('PUT')
            @endif

            {{-- Basic Info Section --}}
            <section class="space-y-6">
                <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-200 pb-2 border-b border-gray-200 dark:border-gray-700">Basic Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Name *</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $game->name ?? '') }}"
                            class="w-full p-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror" required>
                        @error('name') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="developer_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Developer *</label>
                        <select name="developer_id" id="developer_id" required class="w-full p-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('developer_id') border-red-500 @enderror">
                            <option value="">Select Developer</option>
                            @foreach ($developers as $developer)
                                <option value="{{ $developer->id }}"
                                    {{ old('developer_id', $game->developer_id ?? '') == $developer->id ? 'selected' : '' }}>
                                    {{ $developer->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('developer_id') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Description</label>
                    <textarea name="description" id="description" rows="5"
                        class="w-full p-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('description') border-red-500 @enderror">{{ old('description', $game->description ?? '') }}</textarea>
                    @error('description') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
                    <div>
                        <label for="trailer_link" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Trailer Link (YouTube URL)</label>
                        <input type="url" name="trailer_link" id="trailer_link" value="{{ old('trailer_link', $game->trailer_link ?? '') }}" placeholder="https://www.youtube.com/watch?v=..."
                            class="w-full p-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('trailer_link') border-red-500 @enderror">
                        @error('trailer_link') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="visible" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Visibility *</label>
                        <select name="visible" id="visible" class="w-full p-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('visible') border-red-500 @enderror" required>
                            <option value="1" {{ (old('visible', $game->exists ? $game->visible : '1') == '1') ? 'selected' : '' }}>Visible</option>
                            <option value="0" {{ (old('visible', $game->exists ? $game->visible : '1') == '0') ? 'selected' : '' }}>Hidden</option>
                        </select>
                        @error('visible') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </section>

            {{-- Tags Section --}}
            <section class="space-y-2">
                <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-200 pb-2 border-b border-gray-200 dark:border-gray-700">Tags</h2>
                <div>
                    <label for="tags-input-field" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Add or Select Tags</label>
                    <input type="hidden" name="tags" :value="selectedTags.join(',')">
                    <div class="flex items-center border border-gray-300 dark:border-gray-600 rounded-lg p-2">
                        <div class="flex flex-wrap gap-2 p-1 flex-grow min-h-[40px]">
                            <template x-for="tag in selectedTags" :key="tag">
                                <span class="bg-indigo-100 dark:bg-indigo-700 text-indigo-700 dark:text-indigo-200 px-3 py-1.5 rounded-full text-sm flex items-center shadow-sm">
                                    <span x-text="tag"></span>
                                    <button type="button" @click="removeTag(tag)" class="ml-2 text-indigo-500 dark:text-indigo-300 hover:text-indigo-700 dark:hover:text-indigo-100 text-lg leading-none">×</button>
                                </span>
                            </template>
                        </div>
                        <div x-data="{ openDropdown: false }" class="relative ml-2"> {{-- Changed x-data variable name to avoid conflict --}}
                             <input type="text" id="tags-input-field" x-model="newTag"
                                    @keydown.enter.prevent="addTag(newTag); openDropdown = false"
                                    @input.debounce.300ms="openDropdown = newTag.length > 0 && availableTags().length > 0"
                                    @focus="openDropdown = newTag.length > 0 && availableTags().length > 0"
                                    @click.outside="openDropdown = false"
                                    placeholder="New tag..."
                                    class="p-2.5 border-0 focus:ring-0 dark:bg-gray-700 dark:text-gray-200 rounded-md min-w-[160px]">
                            <div x-show="openDropdown && availableTags().length > 0"
                                 x-transition
                                 class="absolute z-20 w-full mt-1 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-lg max-h-48 overflow-auto">
                                <template x-for="availTag in availableTags()" :key="availTag">
                                    <div @click="addTag(availTag); openDropdown = false;" class="px-3 py-2.5 hover:bg-gray-100 dark:hover:bg-gray-600 cursor-pointer text-sm" x-text="availTag"></div>
                                </template>
                            </div>
                        </div>
                         <button type="button" @click="addTag(newTag)" class="ml-2 px-4 py-2.5 bg-indigo-600 text-white text-sm rounded-lg hover:bg-indigo-700 shadow-md">Add</button>
                    </div>
                     @error('tags') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                    <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">Type a tag and press Enter or click Add. Existing tags can be selected from the dropdown.</p>
                </div>
            </section>


            {{-- Image Upload Section --}}
            <section class="space-y-2">
                 <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-200 pb-2 border-b border-gray-200 dark:border-gray-700">Images</h2>
                <div>
                    <label for="images-upload" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Upload New Images</label>
                    <input type="file" name="images[]" id="images-upload" multiple accept="image/*" class="block w-full text-sm text-gray-500 dark:text-gray-400
                        file:mr-4 file:py-2.5 file:px-5
                        file:rounded-lg file:border-0
                        file:text-sm file:font-semibold
                        file:bg-indigo-50 dark:file:bg-indigo-700 file:text-indigo-700 dark:file:text-indigo-200
                        hover:file:bg-indigo-100 dark:hover:file:bg-indigo-600 cursor-pointer @error('images.*') border-red-500 @enderror">
                    @error('images.*') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                    @error('images') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror

                    @if ($game->exists && $game->images->isNotEmpty())
                        <div class="mt-6">
                            <h4 class="text-md font-medium text-gray-700 dark:text-gray-300 mb-3">Current Images:</h4>
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                                @foreach ($game->images as $image)
                                    <div class="relative group aspect-w-1 aspect-h-1">
                                        <img src="{{ asset('storage/images/' . $image->image) }}" alt="Game image {{ $loop->iteration }}" class="w-full h-full object-cover rounded-lg shadow-md">
                                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-60 transition-opacity flex items-center justify-center rounded-lg">
                                             <label :for="'delete_image_{{ $image->id }}'" class="hidden group-hover:flex items-center p-2 bg-red-600 text-white rounded-full cursor-pointer hover:bg-red-700 transition-colors shadow-lg">
                                                <input type="checkbox" name="delete_images[]" value="{{ $image->id }}" id="delete_image_{{ $image->id }}" class="opacity-0 absolute h-0 w-0 peer">
                                                <svg class="w-5 h-5 peer-checked:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                <svg class="w-5 h-5 hidden peer-checked:block" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                                <span class="ml-1.5 text-xs peer-checked:hidden">Delete</span>
                                                <span class="ml-1.5 text-xs hidden peer-checked:block">Marked</span>
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Select images to delete them upon saving changes.</p>
                        </div>
                    @endif
                </div>
            </section>

            {{-- Prices Section --}}
            <section class="space-y-6 border-t border-gray-300 dark:border-gray-700 pt-8">
                <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-200 pb-2">Pricing Information *</h2>
                @error('prices') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                <div class="space-y-6">
                    <template x-for="(price, index) in priceEntries" :key="index">
                        <div class="border border-gray-300 dark:border-gray-600 p-5 rounded-xl shadow-lg bg-gray-50 dark:bg-gray-700/50 space-y-4">
                            <div class="flex justify-between items-center mb-2">
                                <h4 class="font-semibold text-gray-700 dark:text-gray-300 text-lg">Price Entry #<span x-text="index + 1"></span></h4>
                                <button type="button" @click="priceEntries.splice(index, 1)"
                                    class="text-sm text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 font-medium px-3 py-1 rounded-md hover:bg-red-50 dark:hover:bg-red-900/50" x-show="priceEntries.length > 1">
                                    Remove
                                </button>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                                <div>
                                    <label :for="'platform_' + index" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Platform *</label>
                                    <select x-model="price.platform_id" :name="`prices[${index}][platform_id]`" :id="'platform_' + index"
                                        class="w-full p-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                        <option value="">Select Platform</option>
                                        <template x-for="platform in allPlatforms" :key="platform.id">
                                            <option :value="platform.id" x-text="platform.name"></option>
                                        </template>
                                    </select>
                                </div>

                                <div>
                                    <label :for="'store_' + index" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Store *</label>
                                    <select x-model="price.store_id" :name="`prices[${index}][store_id]`" :id="'store_' + index"
                                        class="w-full p-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                        <option value="">Select Store</option>
                                        <template x-for="store in allStores" :key="store.id">
                                            <option :value="store.id" x-text="store.name"></option>
                                        </template>
                                    </select>
                                </div>

                                <div>
                                    <label :for="'price_val_' + index" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Price ($) *</label>
                                    <input type="number" step="0.01" min="0" x-model="price.price" :name="`prices[${index}][price]`" :id="'price_val_' + index"
                                        class="w-full p-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                </div>

                                <div>
                                    <label :for="'discount_' + index" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Discount (%)</label>
                                    <input type="number" step="1" min="0" max="100" x-model="price.discount" :name="`prices[${index}][discount]`" :id="'discount_' + index" value="0" {{-- Default HTML value --}}
                                        class="w-full p-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <button type="button"
                    @click="priceEntries.push({ platform_id: '', store_id: '', price: '', discount: '0' })" {{-- Ensure new discount is '0' --}}
                    class="mt-4 px-5 py-2.5 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-500 text-sm font-medium shadow-md">
                    Add Another Price Entry
                </button>
            </section>

            {{-- Submit Button --}}
            <div class="pt-8 border-t border-gray-300 dark:border-gray-700 flex justify-end mt-6">
                <button type="submit" class="px-8 py-3 bg-indigo-600 text-white font-semibold rounded-lg shadow-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150 text-base">
                    {{ $game->exists ? 'Update Game' : 'Add Game' }}
                </button>
            </div>
        </form>
    </div>
</x-layouts.v-main-layout>

{{-- @push('scripts')
<script>
    // Any page-specific JavaScript can go here if needed, for example, for a rich text editor.
</script>
@endpush --}}
