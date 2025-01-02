<div x-data="{
    height: 0,
    conversationElement: document.getElementById('conversation'),
    markAsRead: null
}" x-init="height = conversationElement.scrollHeight;
$nextTick(() => conversationElement.scrollTop = height);


Echo.private('users.{{ Auth()->User()->id }}')
    .notification((notification) => {
        if (notification['type'] == 'App\\Notifications\\MessageRead' && notification['conversation_id'] == {{ $this->selectedConversation->id }}) {

            markAsRead = true;
        }
    });"
    @scroll-bottom.window="
            $nextTick(()=>
            conversationElement.scrollTop= conversationElement.scrollHeight
            );
            "
    class="w-full overflow-hidden">

    <div class="flex flex-col h-full pt-2 overflow-y-scroll border-b grow">


        {{-- header --}}
        <header class="w-full sticky inset-x-0 flex pb-[5px] pt-[5px] top-0 z-10 bg-white border-b ">

            <div class="flex items-center w-full gap-2 px-2 lg:px-4 md:gap-5">

                <a class="shrink-0 lg:hidden" href="{{ route('chat.index') }}">


                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 12h-15m0 0l6.75 6.75M4.5 12l6.75-6.75" />
                    </svg>


                </a>


                {{-- USER-PROFILE-AVATAR --}}


                <div class="shrink-0">
                    <img src="{{ $selectedConversation->getReceiver()->profile_photo_url }}" alt="Profile Picture"
                        class="mb-3 rounded-circle" style="width: 55px; height: 55px; object-fit: cover;">
                </div>




                <ul class="m-2 list-unstyled">

                    <li><a href="{{ route('profile.user-listing', $selectedConversation->getReceiver()->id) }}">
                            <h6 class="font-bold truncate"> {{ $selectedConversation->getReceiver()->name }} </h6>
                        </a>
                    </li>

                    <li>
                        <h6> {{ $selectedConversation->getReceiver()->email }} </h6>
                    </li>
                </ul>
            </div>


        </header>


        {{-- body- CHATBOX --}}
        <main
            @scroll=" scropTop = $el.scrollTop;

            if(scropTop <= 0)
            {
                Livewire.dispatch('loadMore');
            }"
            @update-chat-height.window="newHeight= $el.scrollHeight;
            oldHeight= height;
            $el.scrollTop= newHeight- oldHeight;
            height=newHeight;"
            id="conversation"
            class="flex flex-col gap-3 p-2.5 overflow-y-auto  flex-grow overscroll-contain overflow-x-hidden w-full my-auto">

            @if ($loadedMessages)

                @php
                    $previousMessage = null;
                @endphp


                @foreach ($loadedMessages as $key => $message)
                    {{-- keep track of the previous message --}}

                    @if ($key > 0)
                        @php
                            $previousMessage = $loadedMessages->get($key - 1);
                        @endphp
                    @endif


                    <div wire:key="{{ time() . $key }}" @class([
                        'max-w-[85%] md:max-w-[78%] flex w-auto gap-2 relative mt-2',
                        'ml-auto' => $message->sender_id === auth()->id(),
                    ])>

                        {{-- avatar --}}

                        <div @class([
                            'shrink-0',
                            'invisible' => $previousMessage?->sender_id == $message->sender_id,
                            'hidden' => $message->sender_id === auth()->id(),
                        ])>

                            <img src="{{ $selectedConversation->getReceiver()->profile_photo_url }}"
                                alt="Profile Picture" class="mb-3 rounded-circle"
                                style="width: 40px; height: 40px; object-fit: cover;">


                        </div>
                        {{-- messsage body --}}

                        <div @class([
                            'flex flex-wrap text-[15px]  rounded-xl p-2.5 flex flex-col text-black bg-[#f6f6f8fb]',
                            'rounded-bl-none border  border-gray-200/40 ' => !(
                                $message->sender_id === auth()->id()
                            ),
                            'rounded-br-none bg-blue-500/80 text-white' =>
                                $message->sender_id === auth()->id(),
                        ])>



                            <p class="text-sm tracking-wide truncate whitespace-normal md:text-base lg:tracking-normal">
                                {{ $message->body }}
                            </p>


                            <div class="flex gap-2 ml-auto">
                                <p @class([
                                    'text-xsm ',
                                    'text-gray-500' => !($message->sender_id === auth()->id()),
                                    'text-white' => $message->sender_id === auth()->id(),
                                ])>
                                    {{ $message->created_at->format('M d, Y @ h:i A') }}
                                </p>
                                {{-- message status , only show if message belongs auth --}}

                                @if ($message->sender_id === auth()->id())
                                    <div x-data="{ markAsRead: @json($message->isRead()) }">

                                        {{-- double ticks is Read/Seen --}}

                                        <span x-cloak x-show="markAsRead" @class('text-gray-200')>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-check2-all" viewBox="0 0 16 16">
                                                <path
                                                    d="M12.354 4.354a.5.5 0 0 0-.708-.708L5 10.293 1.854 7.146a.5.5 0 1 0-.708.708l3.5 3.5a.5.5 0 0 0 .708 0l7-7zm-4.208 7-.896-.897.707-.707.543.543 6.646-6.647a.5.5 0 0 1 .708.708l-7 7a.5.5 0 0 1-.708 0z" />
                                                <path
                                                    d="m5.354 7.146.896.897-.707.707-.897-.896a.5.5 0 1 1 .708-.708z" />
                                            </svg>
                                            Seen
                                        </span>

                                        {{-- single ticks is Unread --}}
                                        <span x-show="!markAsRead" @class('text-gray-200')>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                                                <path
                                                    d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z" />
                                            </svg>
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </main>


        {{-- send message  --}}

        <footer class="inset-x-0 z-10 bg-white shrink-0">
            <div class="p-4 border-t">
                <form x-data="{
                    body: @entangle('body')
                }" @submit.prevent="$wire.sendMessage" method="POST" autocapitalize="off">
                    @csrf
                    <input type="hidden" autocomplete="false" style="display:none">
                    <div class="grid grid-cols-12">
                        <input x-model="body" type="text" autocomplete="off" autofocus
                            placeholder="Send your message here" maxlength="1700"
                            :class="{
                                'bg-gray-100 border-0': true,
                                'border-red-500': @error('body') true @else false @enderror
                            }"
                            class="col-span-10 rounded-lg me-2 outline-0 focus:border-0 focus:ring-0 hover:ring-0 focus:outline-none">
                        <button x-bind:disabled="!body || body.trim() === ''"
                            class="col-span-2 btn btn-outline-primary" type='submit'>
                            <i class="fas fa-paper-plane me-2"></i> Send
                        </button>
                    </div>
                </form>

                @error('body')
                    <p class="text-sm text-red-500"> {{ $message }} </p>
                @enderror
            </div>
        </footer>

    </div>

</div>
