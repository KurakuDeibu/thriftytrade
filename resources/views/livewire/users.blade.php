<div>
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><small><a href="{{ url('/') }}">Home</a></small></li>
            <li class="breadcrumb-item active"><small>Finders</small></li>
            </li>
        </ol>
    </nav>

    {{-- Loading Overlay --}}
    <div wire:loading.flex class="fixed inset-0 z-50 items-center justify-center bg-gray-500 bg-opacity-75">
        <div class="flex flex-col items-center">
            <div class="w-16 h-16 mb-4 border-4 border-t-4 border-blue-500 rounded-full animate-spin"></div>
            <span class="text-lg text-white">Searching Finders...</span>
        </div>
    </div>

    <div class="min-h-screen py-6 bg-gradient-to-br from-gray-100 to-indigo-100">
        <div class="px-4 mx-auto">
            <div class="flex items-center justify-between mb-4"
                style="
                    padding-left: 18px;
                    border-left: 3px solid #477CDB">
                <div>
                    <h2 class="text-xl font-bold text-indigo-500 md:text-2xl">Available Finders</h2>
                    <span class="text-sm text-muted">Looking for a finder?</span>
                </div>

                {{-- Search Input --}}
                <div class="relative w-1/2">
                    <input type="text" wire:model.live.debounce.500ms="search" placeholder="Search finders by name"
                        class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-blue-200">

                    @if ($search)
                        <button wire:click="$set('search', '')"
                            class="absolute text-gray-400 transform -translate-y-1/2 right-3 top-1/2 hover:text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    @endif
                </div>
            </div>


            <div class="grid grid-cols-2 gap-3 md:grid-cols-3 lg:grid-cols-4 md:gap-4">
                <!-- View Finder Card -->
                @forelse($finders as $finder)
                    <div class="overflow-hidden bg-white border rounded-lg shadow-md border-blue-50">
                        <div class="relative flex items-center justify-center p-4 bg-blue-50/50">
                            <div class="relative">
                                <img src="{{ $finder->profile_photo_url }}" alt="{{ $finder->name }} Profile"
                                    class="object-cover border-blue-200 rounded-full shadow-md w-28 h-28 md:w-32 md:h-32 border-3">

                                @if ($finder->is_verified)
                                    <span
                                        class="absolute bottom-0 right-0 bg-blue-500 text-white px-2 py-0.5 rounded-full text-xs">
                                        Verified
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="p-4">
                            <div class="mb-3 text-center">
                                <h3 class="mb-1 text-lg font-semibold text-blue-800">{{ $finder->name }}</h3>
                            </div>

                            <div class="mb-3 space-y-2">
                                <div class="flex items-center text-sm text-blue-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2 text-blue-400"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745" />
                                    </svg>
                                    <span>Specialized at: {{ $finder->specialization ?? 'Not specified' }}</span>
                                </div>

                                <div class="flex items-center text-sm text-blue-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1 text-blue-400"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span>{{ $finder->userAddress ?? 'Location Not Set' }}</span>
                                </div>
                            </div>


                            <div class="flex items-center pt-3 space-x-2 border-t border-blue-100">


                                <div class="flex">
                                    <a href="{{ route('profile.user-listing', $finder->id) }}"
                                        class="px-3 py-1 text-lg text-blue-500 transition border border-blue-500 rounded-full hover:bg-blue-50">
                                        View Profile
                                    </a>

                                    @auth
                                        @if (Auth::user() != $finder)
                                            <button wire:click="message({{ $finder->id }})"
                                                class="px-3 py-1 text-lg text-white transition bg-blue-500 rounded-full hover:bg-blue-600">
                                                Message
                                            </button>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="py-8 text-center col-span-full">
                        <p class="text-gray-500">
                            @if ($search)
                                No finders found matching "{{ $search }}".
                            @else
                                No finders available.
                            @endif
                        </p>
                    </div>
                @endforelse
            </div>
            <div class="mt-2">
                {{ $finders->links() }}
            </div>
        </div>
    </div>
</div>
