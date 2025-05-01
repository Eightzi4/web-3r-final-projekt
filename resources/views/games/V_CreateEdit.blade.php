<!-- resources/views/games/V_CreateEdit.blade.php -->
<x-layouts.v-main-layout>
    <x-slot name="title">Add New Game</x-slot>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 mx-6 mt-4">
        ✔ Game created successfully!
    </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <form method="POST" action="{{ route('games.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="p-6 space-y-6">
                <!-- Basic Information -->
                <div class="space-y-4 border-b border-gray-200 pb-6">
                    <h2 class="text-xl font-semibold">Basic Information</h2>

                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Name *</label>
                        <input type="text" name="name" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Developer -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Developer *</label>
                        <select name="developer_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @foreach($developers as $developer)
                            <option value="{{ $developer->id }}">{{ $developer->name }}</option>
                            @endforeach
                        </select>
                        @error('developer_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    </div>

                    <!-- Visibility -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Visibility *</label>
                        <select name="visible" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="1">Visible</option>
                            <option value="0">Hidden</option>
                        </select>
                    </div>
                </div>

                <!-- Tags -->
                <div class="border-b border-gray-200 pb-6">
                    <h2 class="text-xl font-semibold mb-4">Tags</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                        @foreach($tags as $tag)
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}" class="rounded border-gray-300">
                            <span>{{ $tag->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <!-- Platforms -->
                <div class="border-b border-gray-200 pb-6">
                    <h2 class="text-xl font-semibold mb-4">Platforms *</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                        @foreach($platforms as $platform)
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="platforms[]" value="{{ $platform->id }}" required
                                class="rounded border-gray-300">
                            <span>{{ $platform->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <!-- Stores -->
                <div class="border-b border-gray-200 pb-6">
                    <h2 class="text-xl font-semibold mb-4">Stores *</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                        @foreach($stores as $store)
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="stores[]" value="{{ $store->id }}" required
                                class="rounded border-gray-300">
                            <span>{{ $store->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <!-- Pricing -->
                <div class="border-b border-gray-200 pb-6">
                    <h2 class="text-xl font-semibold mb-4">Pricing</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Base Price *</label>
                            <input type="number" step="0.01" name="price" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Discount (%)</label>
                            <input type="number" min="0" max="100" name="discount" value="0"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>
                </div>

                <!-- Images -->
                <div>
                    <h2 class="text-xl font-semibold mb-4">Images</h2>
                    <input type="file" name="images[]" multiple accept="image/*"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                </div>
            </div>

            <!-- Submit Button -->
            <div class="bg-gray-50 px-6 py-4 flex justify-end">
                <button type="submit"
                    class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                    Create Game
                </button>
            </div>
        </form>
    </div>
</x-layouts.v-main-layout>
