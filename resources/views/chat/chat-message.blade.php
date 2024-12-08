@extends('layouts.app')

@section('content')

    <head>
        <style>
            @media (max-width: 768px) {
                .mobile-screen {
                    height: calc(100vh - 56px);
                    overflow-y: auto;
                }
            }

            .message-box {
                height: calc(100vh - 16rem);
                width: 100%;
            }

            @media (max-width: 768px) {
                .message-box {
                    height: calc(100vh - 19rem);
                }
            }

            .message-wrapper {
                display: flex;
                align-items: flex-start;
                margin-bottom: 1rem;
            }

            .message-content {
                max-width: 70%;
            }

            .message-wrapper.flex-row-reverse .message-content {
                text-align: right;
            }
        </style>
    </head>



    <body class="bg-light">
        <div class="p-0 container-fluid p-sm-4 mobile-screen">
            <div class="bg-white shadow h-100 d-flex flex-column">

                {{-- START OF CHAT LISTS --}}
                <div x-data="chatApp()" x-init="showUsers()" class="overflow-hidden d-flex flex-grow-1">
                    <!-- CHAT Sidebar -->
                    <div class="collapse d-lg-block bg-light border-end" id="sidebar"
                        style="width: 280px; height: calc(100vh - 56px); overflow-y: auto;">
                        <div class="p-3 border-bottom d-flex align-items-center">
                            <h3 class="p-2 mb-0 h5"> Chats </h3>
                            <a href="{{ route('home') }}" class="text-decoration-none me-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-house" viewBox="0 0 16 16">
                                    <path
                                        d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z" />
                                </svg>
                            </a>
                        </div>

                        <!-- User List -->
                        <div class="list-group list-group-flush">
                            <template x-if="users.length === 0">
                                <div class="py-10 d-flex justify-content-center align-items-center h-100">
                                    <small class="text-muted">No Chat Yet</small>
                                </div>
                            </template>

                            <template x-for="user in users" :key="user.id">
                                <a href ="#" class="list-group-item list-group-item-action"
                                    :class="{ 'active': selectedUserId === user.id }"
                                    @click.prevent="showMessages(user.id)">
                                    <div class="d-flex w-100 justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <!-- Profile Photo -->
                                            <img :src="user.profile_photo_url || 'https://via.placeholder.com/50'"
                                                alt="User  avatar" class="rounded-circle me-3" width="50"
                                                height="50">

                                            <div>
                                                <!-- User Name -->
                                                <h6 class="mb-1 fw-bold" x-text="user.name"></h6>

                                                <!-- Latest Message -->
                                                <p class="mb-1 text-muted small"
                                                    x-text="user.created_at?.message || 'No messages yet'"></p>
                                            </div>
                                        </div>

                                        <!-- Timestamp of Latest Message -->
                                        <small class="text-muted"
                                            x-text="user.created_at ? diffForHumans(user.created_at) : ''">
                                        </small>
                                    </div>
                                </a>
                            </template>
                        </div>
                    </div>

                    <!-- Chat Area -->
                    <div class="overflow-hidden flex-grow-1 d-flex flex-column">
                        <div class="p-3 overflow-auto flex-grow-2 message-box" id="messageBox">
                            @if (!auth()->check())
                                <div class="d-flex justify-content-center align-items-center" style="height: 100%;">
                                    <div class="text-center">
                                        <h4>You must login first to view your messages.</h4>
                                        <a class="m-2 btn btn-outline-primary" href="{{ route('login') }}">Go To Login</a>
                                    </div>
                                </div>
                            @else
                                <!-- Show messages when a user is selected -->
                                <template x-if="!selectedUserId">
                                    <div class="d-flex justify-content-center align-items-center h-100">
                                        <p class="text-muted">Select a chat to start messaging</p>
                                    </div>
                                </template>

                                <template x-if="selectedUserId">
                                    <div class="gap-3 d-flex flex-column">
                                        <template x-for="message in messages" :key="message.id">
                                            <div class="mb-3 message-wrapper d-flex align-items-start"
                                                :class="{
                                                    'flex-row-reverse': message.user_id === currentUserId,
                                                }">
                                                <!-- User Profile Image -->
                                                <img :src="message.user_id === currentUserId ?
                                                    '{{ auth()->user()->profile_photo_url }}' :
                                                    users.find(u => u.id === message.user_id)?.profile_photo_url ||
                                                    'https://via.placeholder.com/40'"
                                                    class="mx-2 rounded-circle" width="40" height="40"
                                                    alt="User avatar">

                                                <div class="message-content">
                                                    <div class="p-2 rounded d-inline-block"
                                                        :class="{
                                                            'bg-primary text-white': message.user_id === currentUserId,
                                                            'bg-light': message.user_id !== currentUserId
                                                        }">

                                                        <!-- Message Text -->
                                                        <p class="mb-1" x-text="message.messages || 'No message content'">
                                                        </p>
                                                        <!-- Timestamp -->
                                                        <small class="text-muted d-block"
                                                            :class="{ 'text-white-50': message.user_id === currentUserId }"
                                                            x-text="diffForHumans(message.created_at)">
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </template>
                            @endif
                        </div>

                        <!-- Message Input -->
                        <div class="p-3 bg-white border-top">
                            <div class="input-group">
                                <input type="text" class="form-control rounded-pill" placeholder="Type your message..."
                                    x-model="newMessage" @keyup.enter="sendMessage"
                                    :disabled="!selectedUserId || !{{ auth()->check() ? 'true' : 'false' }}">
                                <button class="btn btn-primary rounded-circle ms-2" type="button" @click="sendMessage"
                                    :disabled="!selectedUserId || !{{ auth()->check() ? 'true' : 'false' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-send" viewBox="0 0 16 16">
                                        <path
                                            d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function chatApp() {
                return {
                    users: [],
                    messages: [],
                    selectedUserId: null,
                    selectedUserName: '',
                    currentUserId: {{ auth()->id() }},

                    showUsers() {
                        axios.get('/users')
                            .then(response => {
                                this.users = response.data;
                            })
                            .catch(error => {
                                console.error('Error fetching users:', error);
                            });
                    },

                    showMessages(userId) {
                        this.selectedUserId = userId;
                        const user = this.users.find(u => u.id === userId);
                        this.selectedUserName = user ? user.name : '';

                        axios.get(`/messages/user/${userId}`)
                            .then(response => {
                                this.messages = response.data.map(message => {
                                    // Optionally, you can add additional processing here
                                    return {
                                        ...message,
                                        user_profile_image: this.getUserProfileImage(message.user_id)
                                    };
                                });

                                // Scroll to bottom after loading messages
                                this.$nextTick(() => {
                                    const messageBox = document.getElementById('messageBox');
                                    messageBox.scrollTop = messageBox.scrollHeight;
                                });
                            })
                            .catch(error => {
                                console.error('Error fetching messages:', error);
                            });
                    },
                    getUserProfileImage(userId) {
                        const user = this.users.find(u => u.id === userId);
                        return user ? user.profile_photo_url : 'https://via.placeholder.com/40';
                    }
                };
            }
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const messageBox = document.getElementById('messageBox');
                messageBox.scrollTop = messageBox.scrollHeight;
            });

            function diffForHumans(timestamp) {
                const now = new Date();
                const past = new Date(timestamp);
                const diffInSeconds = Math.floor((now - past) / 1000);

                if (diffInSeconds < 60) {
                    return 'just now';
                } else if (diffInSeconds < 3600) {
                    const minutes = Math.floor(diffInSeconds / 60);
                    return `${minutes} minute${minutes > 1 ? 's' : ''} ago`;
                } else if (diffInSeconds < 86400) {
                    const hours = Math.floor(diffInSeconds / 3600);
                    return `${hours} hour${hours > 1 ? 's' : ''} ago`;
                } else if (diffInSeconds < 604800) {
                    const days = Math.floor(diffInSeconds / 86400);
                    return `${days} day${days > 1 ? 's' : ''} ago`;
                } else {
                    return new Date(timestamp).toLocaleDateString();
                }
            }
        </script>


    </body>
@endsection
