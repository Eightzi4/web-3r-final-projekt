<x-layouts.guest-layout> {{-- Or your main layout if preferred --}}
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-900">
        <div class="p-8 bg-white dark:bg-gray-800 shadow-xl rounded-lg text-center max-w-md">
            <svg class="mx-auto h-16 w-16 text-red-500 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
            </svg>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-3">Account Suspended</h1>
            <p class="text-gray-600 dark:text-gray-400 mb-6">
                Your account has been suspended. Please contact support if you believe this is an error.
            </p>
            <a href="{{ route('home') }}" class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium">
                Go to Homepage
            </a>
        </div>
    </div>
</x-layouts.guest-layout>
