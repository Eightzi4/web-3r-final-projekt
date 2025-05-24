<x-layouts.v-main-layout title="Site Information" :breadcrumbs="$breadcrumbs">
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <header class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Site Information & Statistics</h1>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">An overview of your application's data.</p>
            </header>

            @if (isset($stats) && !empty($stats))
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    {{-- Games Stats --}}
                    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                                {{-- Heroicon: puzzle-piece --}}
                                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M14.25 6.087c0-.355-.186-.676-.401-.959l-3.7-4.36c-.44-.52-1.26-.52-1.7 0l-3.7 4.36c-.215.283-.401.604-.401.959V9a2.25 2.25 0 002.25 2.25h.093c.128 0 .255-.05.348-.142l1.466-1.466c.19-.19.45-.293.722-.293s.532.103.722.293l1.466 1.466c.093.092.22.142.348.142h.093A2.25 2.25 0 0014.25 9V6.087z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6 18.75c0-.355.186-.676.401-.959l3.7-4.36c.44-.52 1.26-.52 1.7 0l3.7 4.36c.215.283.401.604.401.959V21a2.25 2.25 0 01-2.25 2.25h-.093a.75.75 0 00-.348.142l-1.466 1.466c-.19.19-.45.293-.722.293s-.532-.103-.722-.293l-1.466-1.466a.75.75 0 00-.348-.142h-.093A2.25 2.25 0 016 21v-2.25z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Games
                                </dt>
                                <dd class="text-3xl font-bold text-gray-900 dark:text-white">
                                    {{ $stats['totalGames'] ?? 'N/A' }}</dd>
                            </div>
                        </div>
                        <div class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                            Visible: {{ $stats['visibleGames'] ?? 'N/A' }} | Hidden:
                            {{ $stats['hiddenGames'] ?? 'N/A' }}
                        </div>
                    </div>

                    {{-- Users Stats --}}
                    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                {{-- Heroicon: users --}}
                                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM18 10.5a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Users
                                </dt>
                                <dd class="text-3xl font-bold text-gray-900 dark:text-white">
                                    {{ $stats['totalUsers'] ?? 'N/A' }}</dd>
                            </div>
                        </div>
                        <div class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                            Admins: {{ $stats['adminUsers'] ?? 'N/A' }} | Regular: {{ $stats['regularUsers'] ?? 'N/A' }}
                        </div>
                    </div>

                    {{-- Developers Stats --}}
                    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                                {{-- Heroicon: code-bracket --}}
                                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total
                                    Developers</dt>
                                <dd class="text-3xl font-bold text-gray-900 dark:text-white">
                                    {{ $stats['totalDevelopers'] ?? 'N/A' }}</dd>
                            </div>
                        </div>
                    </div>

                    {{-- Reviews Stats --}}
                    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-pink-500 rounded-md p-3">
                                {{-- Heroicon: chat-bubble-left-ellipsis --}}
                                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.625 9.75a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a.38.38 0 01.265-.112c2.036-.233 3.558-.909 4.654-1.905M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Reviews
                                </dt>
                                <dd class="text-3xl font-bold text-gray-900 dark:text-white">
                                    {{ $stats['totalReviews'] ?? 'N/A' }}</dd>
                            </div>
                        </div>
                    </div>

                    {{-- Tags Stats --}}
                    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                                {{-- Heroicon: tag --}}
                                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Tags
                                </dt>
                                <dd class="text-3xl font-bold text-gray-900 dark:text-white">
                                    {{ $stats['totalTags'] ?? 'N/A' }}</dd>
                            </div>
                        </div>
                    </div>

                    {{-- Platforms Stats --}}
                    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-teal-500 rounded-md p-3">
                                {{-- Heroicon: computer-desktop --}}
                                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25A2.25 2.25 0 015.25 3h13.5A2.25 2.25 0 0121 5.25z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total
                                    Platforms</dt>
                                <dd class="text-3xl font-bold text-gray-900 dark:text-white">
                                    {{ $stats['totalPlatforms'] ?? 'N/A' }}</dd>
                            </div>
                        </div>
                    </div>

                    {{-- Stores Stats --}}
                    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-orange-500 rounded-md p-3">
                                {{-- Heroicon: building-storefront --}}
                                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13.5 21v-7.5A2.25 2.25 0 0011.25 11.25H10.5a2.25 2.25 0 00-2.25 2.25V21M3 3h18M3 21h18M9 3.75h6M9 21v-6.375c0-.621.504-1.125 1.125-1.125H13.5c.621 0 1.125.504 1.125 1.125V21" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Stores
                                </dt>
                                <dd class="text-3xl font-bold text-gray-900 dark:text-white">
                                    {{ $stats['totalStores'] ?? 'N/A' }}</dd>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-lime-500 rounded-md p-3">
                                {{-- Heroicon: photo --}}
                                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Game Image
                                    Records</dt>
                                <dd class="text-3xl font-bold text-gray-900 dark:text-white">
                                    {{ $stats['totalGameImages'] ?? 'N/A' }}</dd>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-gray-500 rounded-md p-3">
                                {{-- Heroicon: link --}}
                                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Game-Tag
                                    Links</dt>
                                <dd class="text-3xl font-bold text-gray-900 dark:text-white">
                                    {{ $stats['totalGameTagRelations'] ?? 'N/A' }}</dd>
                            </div>
                        </div>
                    </div>

                </div>
            @else
                <p class="text-center text-gray-500 dark:text-gray-400">No statistics available at the moment.</p>
            @endif
            {{-- You can add charts here using a library like Chart.js or ApexCharts if you want --}}
            {{-- Example: <canvas id="myChart"></canvas> --}}
        </div>
    </div>
</x-layouts.v-main-layout>

{{-- @push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Example Chart.js setup if you pass data for charts
    // const ctx = document.getElementById('myChart');
    // if (ctx && typeof someChartData !== 'undefined') { // Ensure data is passed from controller
    //   new Chart(ctx, {
    //     type: 'bar',
    //     data: {
    //       labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
    //       datasets: [{
    //         label: '# of Votes',
    //         data: [12, 19, 3, 5, 2, 3],
    //         borderWidth: 1
    //       }]
    //     },
    //     options: { scales: { y: { beginAtZero: true } } }
    //   });
    // }
</script>
@endpush --}}
