<header class="header">
    <div class="align-center"><a class="ic-bento-menu h3 mr-12" id="sidebar-toggler" type="button"></a>
        <h6 class="d-none d-sm-block">Welcome to Everest Rental Dashboard</h6>
    </div>
    <div class="align-center gap-8">
        <div class="dropdown dropdown-notification mr-8"><a class="new" id="dropdownMenua" role="button"
                data-bs-toggle="dropdown" aria-expanded="false"><i class="ic-bell text-cGray500 h4"></i></a>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenua">
                <li>
                    <h6 class="text-primary">Notifications</h6><a class="text-primary small"
                        href="NotificationList.html">View all</a>
                </li>
                <li class="notification-new"><a class="dropdown-item">
                        <div>
                            <p class="fw-semibold mb-2">Reservation Cancelled</p>
                            <p class="mb-8">Ayush Dangol has cancelled reservation for Sept 10th 2022</p>
                            <ul class="list-separator">
                                <li class="small">5th May 2021</li>
                                <li class="small">7:00 PM</li>
                            </ul>
                        </div>
                    </a></li>
                <li class="notification-new"><a class="dropdown-item">
                        <div>
                            <p class="fw-semibold mb-2">New Reservation Made</p>
                            <p class="mb-8">Ashra Dangol has cancelled reservation for Sept 10th 2022</p>
                            <ul class="list-separator">
                                <li class="small">12th May 2021</li>
                                <li class="small">5:00 PM</li>
                            </ul>
                        </div>
                    </a></li>
                <li class="notification-new"><a class="dropdown-item">
                        <div>
                            <p class="fw-semibold mb-2">New Reservation Made</p>
                            <p class="mb-8">Sanjay Shrestha has cancelled reservation for Sept 10th 2022</p>
                            <ul class="list-separator">
                                <li class="small">12th May 2021</li>
                                <li class="small">5:00 PM</li>
                            </ul>
                        </div>
                    </a></li>
                <li class="notification-new"><a class="dropdown-item">
                        <div>
                            <p class="fw-semibold mb-2">Reservation Cancelled</p>
                            <p class="mb-8">Ayush Dangol has cancelled reservation for Sept 10th 2022</p>
                            <ul class="list-separator">
                                <li class="small">5th May 2021</li>
                                <li class="small">7:00 PM</li>
                            </ul>
                        </div>
                    </a></li>
                <li class="notification-new"><a class="dropdown-item">
                        <div>
                            <p class="fw-semibold mb-2">New Reservation Made</p>
                            <p class="mb-8">Ashra Dangol has cancelled reservation for Sept 10th 2022</p>
                            <ul class="list-separator">
                                <li class="small">12th May 2021</li>
                                <li class="small">5:00 PM</li>
                            </ul>
                        </div>
                    </a></li>
                <li class="notification-new"><a class="dropdown-item">
                        <div>
                            <p class="fw-semibold mb-2">New Reservation Made</p>
                            <p class="mb-8">Sanjay Shrestha has cancelled reservation for Sept 10th 2022</p>
                            <ul class="list-separator">
                                <li class="small">12th May 2021</li>
                                <li class="small">5:00 PM</li>
                            </ul>
                        </div>
                    </a></li>
            </ul>
        </div>
        @if (!empty(auth()->user()->social_id))
            <img class="avatar-initial-lg" src="{{auth()->user()->image}}" alt="profile pic">
        @else
            @if (!empty(auth()->user()->image))
                <img class="avatar-initial-lg" src="/images/profilePictures/{{auth()->user()->image}}" alt="profile pic">
            @else
                <div class="avatar-initial-lg">{{auth()->user()->initials}}</div>
            @endif
        @endif
        <div class="dropdown"><a class="align-center small" id="dropdownMenua" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">{{auth()->user()->first_name . ' '. auth()->user()->last_name}}<i
                    class="ic-chevron-down ml-2"></i></a>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                <li><a class="dropdown-item" href="#">My Profile</a></li>
                <li><a class="dropdown-item" href="#">Change Password</a></li>
                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li> 
            </ul>
        </div>
    </div>
</header>