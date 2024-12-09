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

            @media (max-width: 991.98px) {
                #chatSidebar {
                    width: 100%;
                    max-width: 350px;
                }
            }

            #chatSidebar {
                transition: transform 0.3s ease-in-out;
            }

            .list-group-item.active {
                background-color: #f8f9fa;
                color: #007bff;
            }
        </style>
    </head>



    <body class="bg-light">
        <div class="p-0 container-fluid p-sm-4 mobile-screen">
            <div class="bg-white shadow h-100 d-flex flex-column">
                {{-- START OF CHAT LISTS --}}
                <div x-data="chatApp()" x-init="showUsers()"
                    class="overflow-hidden d-flex flex-grow-1 position-relative">
                    <!-- Sidebar Toggle Button -->
                    <button class="top-0 m-2 btn btn-primary d-lg-none position-absolute start-0 z-3" type="button"
                        data-bs-toggle="offcanvas" data-bs-target="#chatSidebar" aria-controls="chatSidebar">
                        <i class="bi bi-chat-left-text"></i>
                    </button>

                    <!-- Chat Sidebar -->
                    <div class="bg-white offcanvas-lg offcanvas-start border-end" tabindex="-1" id="chatSidebar"
                        aria-labelledby="chatSidebarLabel" style="width: 320px;">

                        <!-- Sidebar Header -->
                        <div class="p-3 offcanvas-header border-bottom">
                            <div class="d-flex align-items-center w-100">
                                <h5 class="mb-0 offcanvas-title me-auto" id="chatSidebarLabel">
                                    <i class="bi bi-chat-dots text-primary me-2"></i>Chats
                                </h5>

                                <!-- Quick Actions -->
                                <div class="d-flex align-items-center">
                                    <a href="{{ route('home') }}" class="text-muted me-2" data-bs-toggle="tooltip"
                                        title="Home">
                                        <i class="bi bi-house-fill"></i>
                                    </a>

                                </div>

                                <!-- Close button for mobile -->
                                <button type="button" class="btn-close d-lg-none ms-2" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                        </div>


                        <!-- User List -->
                        <div class="list-group list-group-flush">
                            <template x-if="users.length === 0">
                                <div class="py-10 d-flex justify-content-center align-items-center h-100">
                                    <small class="text-muted">No Chat Yet</small>
                                </div>
                            </template>

                            <!-- In the User List section -->
                            <template x-for="user in users" :key="user.id">
                                <div class="list-group-item list-group-item-action position-relative user-list-item"
                                    :class="{ 'active': selectedUserId === user.id }">
                                    <div class="d-flex align-items-center w-100">
                                        <!-- Profile Photo -->
                                        <div class="flex-shrink-0 me-3"
                                            style="width: 50px; height: 50px; overflow: hidden; border-radius: 50%;">
                                            <img :src="user.profile_photo_url || 'https://via.placeholder.com/50'"
                                                alt="User avatar" class="w-100 h-100 object-fit-cover"
                                                style="object-position: center; cursor: pointer;"
                                                @click="openUserProfile(user)">
                                        </div>

                                        <!-- User Info - Flex Column -->
                                        <div class="overflow-hidden flex-grow-1 me-2" @click="showMessages(user.id)">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <!-- Username Container -->
                                                <div class="overflow-hidden d-flex flex-column"
                                                    style="flex-grow: 1; min-width: 0;">
                                                    <h6 class="mb-0 text-truncate fw-bold"
                                                        style="max-width: 100%; cursor: pointer;" x-text="user.name"
                                                        @click="openUserProfile(user)" :title="user.name">
                                                    </h6>

                                                    <!-- Latest Message -->
                                                    <p class="mb-0 text-muted small text-truncate"
                                                        x-text="user.created_at?.message || 'No messages yet'"
                                                        style="max-width: 100%;">
                                                    </p>
                                                </div>

                                                <!-- Timestamp Container -->
                                                <small class="flex-shrink-0 text-muted ms-2 text-nowrap"
                                                    style="font-size: 0.75rem;">
                                                    <span
                                                        x-text="user.created_at ? diffForHumans(user.created_at) : ''"></span>
                                                </small>
                                            </div>
                                        </div>

                                        <!-- Dropdown Menu -->
                                        <div class="flex-shrink-0 dropdown position-static">
                                            <button class="p-0 btn btn-link text-muted" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end"
                                                style="position: absolute; z-index: 1050;">
                                                <li>
                                                    <a class="dropdown-item" href="#"
                                                        @click.prevent="openUserProfile(user)">
                                                        <i class="bi bi-person me-2"></i>View Profile
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
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
                                        <a class="m-2 btn btn-outline-primary" href="{{ route('login') }}">Go To
                                            Login</a>
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
                                        <template x-for="(message, index) in messages" :key="message.id">
                                            <div class="mb-3 message-wrapper d-flex align-items-start"
                                                :class="{
                                                    'flex-row-reverse': message.user_id === currentUserId,
                                                }">
                                                <!-- User Profile Image -->
                                                <img x-show="index === messages.length - 1 || messages[index+1].user_id !== message.user_id"
                                                    :src="message.user_id === currentUserId ?
                                                        '{{ auth()->user()->profile_photo_url }}' :
                                                        users.find(u => u.id === message.user_id)
                                                        ?.profile_photo_url ||
                                                        'https://via.placeholder.com/40'"
                                                    class="mx-2 rounded-circle object-fit-cover"
                                                    style="width: 40px; height: 40px;" width="40" height="40"
                                                    alt="User avatar">

                                                <div class="message-content">
                                                    <div class="p-2 px-2 py-2 rounded d-inline-block"
                                                        :class="{
                                                            'bg-primary text-white': message.user_id ===
                                                                currentUserId,
                                                            'bg-light': message.user_id !== currentUserId
                                                        }">

                                                        <!-- Message Text -->
                                                        <p class="mb-1" x-text="message.messages || 'No message content'">
                                                        </p>
                                                        <!-- Timestamp -->
                                                        <small class="text-muted d-block"
                                                            :class="{
                                                                'text-white-50': message.user_id === currentUserId
                                                            }">
                                                            <span x-text="diffForHumans(message.created_at)"></span>
                                                            <span
                                                                x-text="message.user_id === currentUserId ? ' • You' : ' • ' + (users.find(u => u.id === message.user_id)?.name || 'User')"></span>
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
                                <input type="text" class="form-control" placeholder="Type a message..."
                                    x-model="newMessage" @keyup.enter="sendMessage"
                                    :disabled="!selectedUserId || isLoading">
                                <button class="btn btn-primary" type="button" @click="sendMessage"
                                    :disabled="!selectedUserId || !newMessage.trim() || isLoading">
                                    <span x-show="!isLoading">
                                        <i class="bi bi-send"></i>
                                    </span>
                                    <span x-show="isLoading" class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
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
                    newMessage: '',
                    isLoading: false,
                    searchQuery: '',
                    filteredUsers: [],


                    showUsers() {
                        axios.get('/users')
                            .then(response => {
                                this.users = response.data;
                                this.filteredUsers = [...this.users];
                            })
                            .catch(error => {
                                console.error('Error fetching users:', error);
                            });
                    },

                    filterUsers() {
                        this.filteredUsers = this.users.filter(user =>
                            user.name.toLowerCase().includes(this.searchQuery.toLowerCase())
                        );
                    },

                    openUserProfile(user) {
                        window.open(`/marketplace/user/${user.id}/listings`, '_blank');

                        this.showMessages(user.id);
                    },


                    sendMessage() {
                        // Validate message and selected user
                        if (!this.selectedUserId || !this.newMessage.trim()) {
                            console.error('Invalid message or no user selected');
                            return;
                        }
                        this.isLoading = true;

                        // Send message via axios
                        axios.post('/send-message', {
                                receiver_id: this.selectedUserId,
                                message: this.newMessage
                            })
                            .then(response => {
                                // Add the new message to the messages array
                                this.messages.push(response.data.message);
                                this.newMessage = '';

                                // Scroll to bottom
                                this.$nextTick(() => {
                                    const messageBox = document.getElementById('messageBox');
                                    messageBox.scrollTop = messageBox.scrollHeight;
                                });
                            })
                            .catch(error => {
                                // error logging
                                console.error('Error sending message:', error.response ? error.response.data : error);

                                alert('Failed to send message. Please try again.');
                            })
                            .finally(() => {
                                this.isLoading = false;
                            });
                    },

                    showMessages(userId) {
                        this.selectedUserId = userId;
                        const user = this.users.find(u => u.id === userId);
                        this.selectedUserName = user ? user.name : '';

                        axios.get(`/messages/user/${userId}`)
                            .then(response => {
                                this.messages = response.data.map(message => {
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
                    },



                }
            }

            // Initialize tooltips
            document.addEventListener('DOMContentLoaded', function() {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl)
                });
            });
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
