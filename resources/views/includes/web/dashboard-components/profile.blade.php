<div class="dashboard-user-profile">
    <div class="media">
        <div class="pull-left text-center" href="#!">
            <img class="media-object user-img" src="{{ $user?->avatar ?? asset('assets/web/images/no-user.png') }}"
                alt="Image">
        </div>
        <div class="media-body">
            <ul class="user-profile-list">
                <li><span>Full Name:</span> <span
                        id="profile-name">{{ $user->first_name . " " . $user->last_name }}</span></li>
                <li><span>Phone:</span> <span id="profile-phone">{{ $user->phone }}</span></li>
                <li><span>Email:</span> <span id="profile-email">{{ $user->email }}</span></li>
                <li><span>Address:</span> <span id="profile-address">{{ $user->address }}</span></li>
                <li><span>Date of Birth:</span> DD/MM/YYYY</li>
            </ul>
        </div>
        <!-- Edit Profile Button -->
        <a href="#" class="btn btn-small" data-toggle="modal" data-target="#editProfileModal">
            Edit Profile
        </a>
    </div>
</div> 
