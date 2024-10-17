@extends('layouts.app')

@section('content')
    <div class="container mt-4">


        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" id="profileTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="profileinfo-tab" data-bs-toggle="tab"
                            data-bs-target="#profileinfo" type="button" role="tab" aria-controls="profileinfo"
                            aria-selected="true">Profile Information</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="updatepassword-tab" data-bs-toggle="tab"
                            data-bs-target="#updatepassword" type="button" role="tab" aria-controls="updatepassword"
                            aria-selected="false">Update Password</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="deleteaccount-tab" data-bs-toggle="tab" data-bs-target="#deleteaccount"
                            type="button" role="tab" aria-controls="deleteaccount" aria-selected="false">Delete
                            Account</button>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="profileTabsContent">
                    <div class="tab-pane fade show active" id="profileinfo" role="tabpanel"
                        aria-labelledby="profileinfo-tab">
                        @livewire('profile.update-profile-information-form')
                    </div>
                    <div class="tab-pane fade" id="updatepassword" role="tabpanel" aria-labelledby="updatepassword-tab">
                        @livewire('profile.update-password-form')
                    </div>
                    <div class="tab-pane fade" id="deleteaccount" role="tabpanel" aria-labelledby="deleteaccount-tab">
                        @livewire('profile.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var triggerTabList = [].slice.call(document.querySelectorAll('#profileTabs button'))
                triggerTabList.forEach(function(triggerEl) {
                    var tabTrigger = new bootstrap.Tab(triggerEl)

                    triggerEl.addEventListener('click', function(event) {
                        event.preventDefault()
                        tabTrigger.show()
                    })
                })
            });
        </script>
    @endpush
@endsection
