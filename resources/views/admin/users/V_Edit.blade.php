{{-- Main layout component for editing a user --}}
<x-layouts.v-main :title="'Edit User: ' . $user->name" :breadcrumbs="$breadcrumbs">
    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            {{-- Card container for the form --}}
            <div class="bg-white dark:bg-gray-800 shadow-2xl rounded-xl p-6 sm:p-8 md:p-10">
                {{-- Form header --}}
                <h1 class="text-2xl font-bold mb-8 text-gray-800 dark:text-white">Edit User: <span
                        class="text-indigo-600 dark:text-indigo-400">{{ $user->name }}</span></h1>

                {{-- User update form --}}
                <form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Name input field --}}
                    <div>
                        <label for="name"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Name *</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                            class="w-full p-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror"
                            required>
                        @error('name')
                            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email input field --}}
                    <div>
                        <label for="email"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Email Address
                            *</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                            class="w-full p-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('email') border-red-500 @enderror"
                            required>
                        @error('email')
                            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Administrator status checkbox --}}
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="is_admin" name="is_admin" type="checkbox" value="1"
                                {{ old('is_admin', $user->is_admin) ? 'checked' : '' }}
                                @if (auth()->id() === $user->id && $user->is_admin) disabled @endif
                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:checked:bg-indigo-500 rounded">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="is_admin" class="font-medium text-gray-700 dark:text-gray-300">Administrator
                                Privileges</label>
                            <p class="text-gray-500 dark:text-gray-400 text-xs">Grant this user full administrative
                                access.</p>
                            @if (auth()->id() === $user->id && $user->is_admin)
                                <p class="text-yellow-600 dark:text-yellow-400 text-xs mt-1">You cannot remove your own
                                    admin status.</p>
                            @endif
                        </div>
                    </div>

                    {{-- Banned status checkbox --}}
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="is_banned" name="is_banned" type="checkbox" value="1"
                                {{ old('is_banned', $user->is_banned ?? false) ? 'checked' : '' }}
                                @if (auth()->id() === $user->id) disabled @endif
                                class="focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:checked:bg-red-500 rounded">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="is_banned" class="font-medium text-gray-700 dark:text-gray-300">Ban User</label>
                            <p class="text-gray-500 dark:text-gray-400 text-xs">Prevent this user from logging in.</p>
                            @if (auth()->id() === $user->id)
                                <p class="text-yellow-600 dark:text-yellow-400 text-xs mt-1">You cannot ban yourself.
                                </p>
                            @endif
                        </div>
                    </div>

                    {{-- Form action buttons: Cancel and Update --}}
                    <div class="pt-6 border-t border-gray-300 dark:border-gray-700 flex justify-end">
                        <a href="{{ route('admin.users.index') }}"
                            class="px-6 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 mr-3">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-6 py-2.5 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150 text-sm">
                            Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.v-main>
