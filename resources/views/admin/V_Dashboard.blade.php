<x-layouts.v-main-layout title="Admin Dashboard" :breadcrumbs="$breadcrumbs">
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <header class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Admin Dashboard</h1>
            </header>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Game Management Card -->
                <a href="{{ route('admin.games.index') }}"
                    class="block p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                    <div class="flex items-center">
                        <div class="p-3 bg-indigo-500 rounded-full text-white mr-4">
                            {{-- Heroicon: puzzle (gamepad would be better if available) --}}
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-700 dark:text-white">Manage Games</h2>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">Add, edit, or delete game entries.</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.siteinfo') }}"
                    class="block p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                    <div class="flex items-center">
                        <div class="p-3 bg-cyan-500 rounded-full text-white mr-4">
                            {{-- Heroicon: information-circle --}}
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-700 dark:text-white">Site Information</h2>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">View site statistics and analytics.</p>
                        </div>
                    </div>
                </a>

                {{-- User Management Card --}}
                <a href="{{ route('admin.users.index') }}"
                    class="block p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-500 rounded-full text-white mr-4">
                            {{-- Heroicon: users --}}
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-700 dark:text-white">Manage Users</h2>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">View users, manage roles, and
                                permissions.</p>
                        </div>
                    </div>
                </a>

                <!-- User Management Card (Example - requires C_Admin_UserController etc.) -->
                {{-- <a href="#" class="block p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-500 rounded-full text-white mr-4">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-700 dark:text-white">Manage Users</h2>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">View users and manage roles.</p>
                        </div>
                    </div>
                </a> --}}

                <!-- Tag Management Card (Example) -->
                {{-- <a href="#" class="block p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                    <div class="flex items-center">
                        <div class="p-3 bg-yellow-500 rounded-full text-white mr-4">
                           <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-700 dark:text-white">Manage Tags</h2>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">Create and edit game tags.</p>
                        </div>
                    </div>
                </a> --}}
            </div>
        </div>
    </div>
</x-layouts.v-main-layout>
