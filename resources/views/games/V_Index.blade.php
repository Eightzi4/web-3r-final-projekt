<x-layouts.v-main-layout :title="'Manage Games'" :breadcrumbs="$breadcrumbs"> {{-- Assuming $breadcrumbs is passed from controller --}}

    <div class="flex flex-col sm:flex-row justify-between items-center mb-8"> {{-- mb-8 for more space --}}
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-4 sm:mb-0">Game Management</h1>
        <a href="{{ route('admin.games.create') }}" class="inline-flex items-center bg-indigo-600 text-white px-5 py-2.5 rounded-lg shadow-md hover:bg-indigo-700 transition-colors duration-150 text-sm font-medium">
            {{-- Heroicon example (replace FontAwesome if you prefer) --}}
            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Add New Game
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl overflow-x-auto"> {{-- Increased rounding and shadow --}}
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-100 dark:bg-gray-700"> {{-- Slightly different bg for thead --}}
                <tr>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Name</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Developer</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Price</th>
                    <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Actions</th> {{-- Text-right for actions --}}
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($games as $game)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-12 w-12"> {{-- Slightly larger image --}}
                                    @if ($game->images->isNotEmpty())
                                        <img class="h-12 w-12 rounded-md object-cover" {{-- rounded-md --}}
                                            src="{{ asset('storage/images/' . $game->images->first()->image) }}"
                                            alt="{{ $game->name }} thumbnail">
                                    @else
                                        {{-- Placeholder if no image --}}
                                        <div class="h-12 w-12 rounded-md bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $game->name }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">ID: {{ $game->id }}</div> {{-- Added ID for context --}}
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-700 dark:text-gray-300">{{ $game->developer->name ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $game->visible ? 'bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-200' }}">
                                {{ $game->visible ? 'Visible' : 'Hidden' }}
                            </span>
                        </td>
                         <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                            {{ $game->latestPrice ? '$' . number_format($game->latestPrice->price, 2) : 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2"> {{-- space-x-2 for button spacing --}}
                            <a href="{{ route('games.show', $game->id) }}" target="_blank"
                                class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300" title="View">
                                {{-- Heroicon: eye (replace FontAwesome) --}}
                                <svg class="inline-block h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            </a>
                            <a href="{{ route('admin.games.edit', $game->id) }}"
                                class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300" title="Edit">
                                {{-- Heroicon: pencil (replace FontAwesome) --}}
                                <svg class="inline-block h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                            </a>
                            <form action="{{ route('admin.games.destroy', $game->id) }}" method="POST" class="inline"
                                onsubmit="return confirm('Are you sure you want to delete this game: {{ addslashes($game->name) }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300" title="Delete">
                                    {{-- Heroicon: trash (replace FontAwesome) --}}
                                    <svg class="inline-block h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                  <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No games found</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by adding a new game.</p>
                                <div class="mt-6">
                                  <a href="{{ route('admin.games.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                      <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                    </svg>
                                    Add New Game
                                  </a>
                                </div>
                              </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($games->hasPages()) {{-- Only show pagination if needed --}}
    <div class="mt-6">
        {{ $games->links() }}
    </div>
    @endif
</x-layouts.v-main-layout>
