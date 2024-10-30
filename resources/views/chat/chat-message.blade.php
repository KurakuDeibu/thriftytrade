<html>

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
        </style>
    </head>

    <body class="bg-light">
        <div class="p-0 container-fluid p-sm-4 mobile-screen">
            <div class="bg-white shadow h-100 d-flex flex-column">

                <!-- CHAT HEADER -->
                <div class="p-3 bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="mb-1 h4">[Product Title] <small>Posted By: USERNAME</small></h2>
                            <div class="flex-wrap gap-2 d-flex align-items-center">
                                <span class="fs-4 fw-bold text-success">₱[Price]</span>
                                <span class="small text-muted">[Address]</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <button class="btn btn-primary me-2">View Details</button>
                            <button class="btn btn-outline-primary d-lg-none" type="button" data-bs-toggle="collapse"
                                data-bs-target="#sidebar" aria-expanded="false" aria-controls="sidebar">
                                ☰
                            </button>
                        </div>
                    </div>
                </div>
                {{-- END OF CHAT HEADER --}}

                <div class="overflow-hidden d-flex flex-grow-1">
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
                        <div class="list-group list-group-flush">
                            {{-- <div class="py-10 d-flex justify-content-center align-items-center h-100">
                                <small class="text-muted">No Chat Yet</small>
                            </div> --}}
                            <a href="#" class="list-group-item list-group-item-action active">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">Laptop Acer 69th Edition...</h6>
                                </div>
                                <small>Posted by: Shan R.</small>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">iPhone 15 Pro Max</h6>
                                </div>
                                <small>Posted by: John D.</small>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">Sony PlayStation 5</h6>
                                </div>
                                <small>Posted by: Emma W.</small>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">Samsung 4K QLED TV</h6>
                                </div>
                                <small>Posted by: Mike T.</small>
                            </a>
                        </div>
                    </div>

                    <!-- Chat Area -->
                    <div class="overflow-hidden flex-grow-1 d-flex flex-column">
                        <div class="p-3 overflow-auto flex-grow-2 message-box" id="messageBox">

                            {{-- SHOW THIS IF USER IS NOT AUTHENTICATED --}}
                            @if (!auth()->check())
                                <div class="d-flex justify-content-center align-items-center" style="height: 100%;">
                                    <div class="text-center">
                                        <h4>You must login first to view your messages.</h4>
                                        <a class="m-2 btn btn-outline-primary" href="{{ route('login') }}">Go To Login</a>
                                    </div>
                                </div>
                            @else
                                <div class="gap-3 d-flex flex-column">
                                    <div class="d-flex align-items-end">
                                        <img src="https://via.placeholder.com/40" alt="User avatar"
                                            class="rounded-circle me-2" width="32" height="32">
                                        <div class="d-flex flex-column">
                                            <div class="p-2 mb-1 rounded bg-light">
                                                <p class="mb-0">Yooo, I found this item nearby my area. we can have a
                                                    deal.
                                                    lmk if you are intereYooo, .</p>
                                            </div>
                                            <small class="text-muted">20 minutes ago</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-end">
                                        <div class="d-flex flex-column align-items-end">
                                            <div class="p-2 mb-1 text-white rounded bg-primary">
                                                <p class="mb-0">Hey Shan! That's great news. Can you tell me more about
                                                    the
                                                    condition of the laptop?</p>
                                            </div>
                                            <small class="text-muted">15 minutes ago</small>
                                        </div>
                                        <img src="https://via.placeholder.com/40" alt="My avatar"
                                            class="rounded-circle ms-2" width="32" height="32">
                                    </div>
                                    <div class="d-flex align-items-end">
                                        <img src="https://via.placeholder.com/40" alt="User avatar"
                                            class="rounded-circle me-2" width="32" height="32">
                                        <div class="d-flex flex-column">
                                            <div class="p-2 mb-1 rounded bg-light">
                                                <p class="mb-0">Sure thing! The laptop is in excellent condition. It's
                                                    barely
                                                    been used and still has the original packaging.</p>
                                            </div>
                                            <small class="text-muted">10 minutes ago</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-end">
                                        <div class="d-flex flex-column align-items-end">
                                            <div class="p-2 mb-1 text-white rounded bg-primary">
                                                <p class="mb-0">Sounds promising! What are the specs? And does it come
                                                    with a
                                                    warranty?</p>
                                            </div>
                                            <small class="text-muted">5 minutes ago</small>
                                        </div>
                                        <img src="https://via.placeholder.com/40" alt="My avatar"
                                            class="rounded-circle ms-2" width="32" height="32">
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="p-3 bg-white border-top">
                            <div class="input-group">
                                <input type="text" class="form-control rounded-pill" placeholder="Type your message..."
                                    aria-label="Type your message" aria-describedby="button-send"
                                    @if (!auth()->check()) disabled @endif>
                                <button class="btn btn-primary rounded-circle ms-2" type="button" id="button-send"
                                    @if (!auth()->check()) disabled @endif>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-send" viewBox="0 0 16 16">
                                        <path
                                            d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z" />
                                    </svg>
                                </button>
                            </div>
                            @if (!auth()->check())
                                <div class="mt-2 text-center text-danger">
                                    <small>You must login first to send messages.</small>
                                </div>
                            @endif
                        </div>
                    </div>
                    {{-- END OF CHAT AREA --}}
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const messageBox = document.getElementById('messageBox');
                messageBox.scrollTop = messageBox.scrollHeight;
            });
        </script>
    </body>
@endsection

</html>
