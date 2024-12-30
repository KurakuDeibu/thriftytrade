    <div x-data="{ type: 'all', query: @entangle('query') }" x-init="setTimeout(() => {

        conversationElement = document.getElementById('conversation-' + query);

        {{-- scroll to the element --}}
        if (conversationElement) {
            conversationElement.scrollIntoView({ 'behavior': 'smooth' });
        }
    }, 200);

    {{-- Echo to  --}}
    Echo.private('users.{{ auth()->user()->id }}')
        .notification((notification) => {
            if (notification['type'] == 'App\\Notifications\\MessageRead' || notification['type'] == 'App\\Notifications\\MessageSent') {

                Livewire.dispatch('refresh');
            }
        });" class="flex flex-col h-full overflow-hidden transition-all">

        <header class="sticky z-10 w-full px-3 py-2 bg-white top-5 pt-5">
            <div class="flex items-center justify-between pb-2 border-b pt-4">
                <div class="flex items-center gap-2">
                    <a href="{{ route('home') }}" class="text-2xl font-extrabold me-2">Chats <i
                            class="bi bi-house-fill"></i></a>
                </div>
                <button>

                </button>
            </div>

            {{-- Filters --}}
            <div class="flex items-center gap-3 p-2 overflow-x-scroll bg-white">
                <button @click="type='all'" :class="{ 'bg-blue-100 border-0 text-black': type == 'all' }"
                    class="inline-flex justify-center items-center rounded-full gap-x-1 text-xs font-medium px-3 lg:px-5 py-1  lg:py-2.5 border ">
                    All
                </button>
                {{-- <button @click="type='deleted'" :class="{ 'bg-blue-100 border-0 text-black': type == 'deleted' }"
                    class="inline-flex justify-center items-center rounded-full gap-x-1 text-xs font-medium px-3 lg:px-5 py-1  lg:py-2.5 border ">
                    Deleted
                </button> --}}

            </div>

        </header>


        <main class="relative h-full overflow-hidden overflow-y-scroll grow" style="contain:content">

            {{-- chatlist  --}}

            <ul class="grid w-full p-2 spacey-y-2">

                @if ($conversations)

                    @foreach ($conversations as $key => $conversation)
                        <li id="conversation-{{ $conversation->id }}" wire:key="{{ $conversation->id }}"
                            class="p-4 py-2 px-4 hover:bg-gray-50 rounded-2xl flex gap-3 relative w-full cursor-pointer {{ $conversation->id == $selectedConversation?->id ? 'bg-gray-100/70' : '' }}">
                            <a href="#" class="shrink-0">
                                <img src="{{ $conversation->getReceiver()->profile_photo_url }}" alt="Profile Picture"
                                    class="mb-3 rounded-circle" style="width: 55px; height: 55px; object-fit: cover;">
                            </a>

                            <aside class="grid w-full grid-cols-12 p-2">

                                <a href="{{ route('chat', $conversation->id) }}"
                                    class="relative w-full col-span-11 p-1 pb-2 overflow-hidden leading-5 truncate border-b border-gray-200 flex-nowrap">

                                    {{-- name and date  --}}
                                    <div class="flex items-center justify-between w-full">

                                        <h6 class="font-medium tracking-wider text-gray-900 truncate">
                                            {{ $conversation->getReceiver()->name }}
                                        </h6>

                                        <small
                                            class="text-gray-700">{{ $conversation->messages?->last()?->created_at?->shortAbsoluteDiffForHumans() }}
                                        </small>

                                    </div>

                                    {{-- Message body --}}


                                    <div class="flex items-center gap-x-2">

                                        @if ($conversation->messages?->last()?->sender_id == auth()->id())
                                            @if ($conversation->isLastMessageReadByUser())
                                                {{-- double tick  --}}
                                                <span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                        height="16" fill="currentColor" class="bi bi-check2-all"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M12.354 4.354a.5.5 0 0 0-.708-.708L5 10.293 1.854 7.146a.5.5 0 1 0-.708.708l3.5 3.5a.5.5 0 0 0 .708 0l7-7zm-4.208 7-.896-.897.707-.707.543.543 6.646-6.647a.5.5 0 0 1 .708.708l-7 7a.5.5 0 0 1-.708 0z" />
                                                        <path
                                                            d="m5.354 7.146.896.897-.707.707-.897-.896a.5.5 0 1 1 .708-.708z" />
                                                    </svg>
                                                </span>
                                            @else
                                                {{-- single tick  --}}
                                                <span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                        height="16" fill="currentColor" class="bi bi-check2"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z" />
                                                    </svg>
                                                </span>
                                            @endif
                                        @endif




                                        <p class="grow truncate text-sm font-[100]">
                                            {{ $conversation->messages?->last()?->body ?? ' ' }}
                                        </p>

                                        {{-- unread count --}}
                                        @if ($conversation->unreadMessagesCount() > 0)
                                            <span
                                                class="p-px px-2 text-xs font-bold text-white bg-blue-500 rounded-full shrink-0">
                                                {{ $conversation->unreadMessagesCount() }}
                                            </span>
                                        @endif


                                    </div>



                                </a>

                                {{-- Dropdown --}}

                                <div class="flex flex-col col-span-1 my-auto text-center z-1">

                                    <x-dropdown align="right" width="48">
                                        <x-slot name="trigger">
                                            <button>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor"
                                                    class="text-gray-700 bi bi-three-dots-vertical w-7 h-7"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                                                </svg>
                                            </button>
                                        </x-slot>

                                        <x-slot name="content">
                                            <div class="w-full p-1">
                                                <button
                                                    class="flex items-center w-full gap-3 px-4 py-2 text-sm leading-5 text-left text-gray-500 transition-all duration-150 ease-in-out hover:bg-gray-100 focus:outline-none focus:bg-gray-100">

                                                    <span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" fill="currentColor"
                                                            class="bi bi-person-circle" viewBox="0 0 16 16">
                                                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                                            <path fill-rule="evenodd"
                                                                d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                                                        </svg>
                                                    </span>
                                                    <a
                                                        href="{{ route('profile.user-listing', $conversation->getReceiver()->id) }}">View
                                                        Profile</a>
                                                </button>

                                                <button
                                                    onclick="confirm('Are you sure?')||event.stopImmediatePropagation()"
                                                    wire:click="deleteByUser('{{ encrypt($conversation->id) }}')"
                                                    class="flex items-center w-full gap-3 px-4 py-2 text-sm leading-5 text-left text-gray-500 transition-all duration-150 ease-in-out hover:bg-gray-100 focus:outline-none focus:bg-gray-100">

                                                    <span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" fill="currentColor" class="bi bi-trash-fill"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
                                                        </svg>
                                                    </span>

                                                    Delete

                                                </button>



                                            </div>

                                        </x-slot>
                                    </x-dropdown>



                                </div>


                            </aside>

                        </li>
                    @endforeach
                @else
                @endif

            </ul>

        </main>
    </div>
