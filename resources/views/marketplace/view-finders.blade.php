<div class="min-h-screen py-6 bg-gradient-to-br from-gray-100 to-indigo-100">
    <div class="container px-4 mx-auto">
        <div class="flex items-center justify-between mb-4"
            style="
        padding-left: 18px;
        border-left: 3px solid #477CDB
    ">
            <div>
                <h2 class="text-xl font-bold text-indigo-500 md:text-2xl">Available Finders</h2>
                <span class="text-sm text-muted ">Looking for a finder?</span>

            </div>
            <a href="{{ route('users.finder') }}"
                class="bg-blue-600 text-white px-3 py-1.5 md:px-4 md:py-2 text-sm md:text-base rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-search me-2"></i> View All
            </a>
        </div>

        <div class="grid grid-cols-2 gap-3 md:grid-cols-3 lg:grid-cols-4 md:gap-4">
            <!-- View Finder Card -->

            @foreach ($finders as $finder)
                <div class="overflow-hidden bg-white border rounded-lg shadow-md border-blue-50">
                    <div class="relative flex items-center justify-center p-4 bg-blue-50/50">
                        <div class="relative">
                            <img src="{{ $finder->profile_photo_url }}" alt="{{ $finder->name }}"
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
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                <span>Specialized: [Category]</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-3 border-t border-blue-100">
                            <div class="flex items-center text-sm text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1 text-blue-400"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>
                                    {{ Str::limit($finder->userAddress, 20, '...') }}

                                </span>
                            </div>
                            <a href="{{ route('profile.user-listing', $finder->id) }}"
                                class="text-sm font-medium text-blue-500 hover:text-blue-600">
                                View Profile
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
            @if ($finders->isEmpty())
                <div class="py-8 text-center col-span-full">
                    <p class="text-gray-500">
                        No finders available.
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>
