@php
    $reservationLog = getRerservationLog();
@endphp
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
                        href="/admin/reservation-notifications">View all</a>
                </li>
                @foreach ($reservationLog as $log)
                    <li class="notification-new">
                        <a class="dropdown-item">
                            <div>
                                <p class="fw-semibold mb-2">{{$log->title}}</p>
                                <p class="mb-8">{{$log->description}}</p>
                                <ul class="list-separator">
                                    {{-- <li class="small">5th May 2021</li> --}}
                                    <li class="small">{{date("jS M Y", strtotime($log->created_at))}}</li>
                                    <li class="small">{{date("h:i A", strtotime($log->created_at))}}</li>
                                </ul>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        @if (!empty(auth()->user()->social_id))
            <div class="avatar-lg">
                <img src="{{auth()->user()->image}}" alt="profile pic">
            </div>
            @else
            @if (!empty(auth()->user()->image))
                <div class="avatar-lg">
                    <img src="/images/profilePictures/{{auth()->user()->image}}" alt="profile pic">
                </div>
            @else
                <div class="avatar-initial-lg">{{auth()->user()->initials}}</div>
            @endif
        @endif
        <div class="dropdown"><a class="align-center small" id="dropdownMenua" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">{{auth()->user()->first_name . ' '. auth()->user()->last_name}}<i
                    class="ic-chevron-down ml-2"></i></a>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                <li><a class="dropdown-item" href="/profile-setting">My Profile</a></li>
                {{-- <li><a class="dropdown-item" href="#">Change Password</a></li> --}}
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