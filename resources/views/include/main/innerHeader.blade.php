<div class="website-inner-header">
    <div class="img-background"><img src="/images/product4.jpg" alt="" /></div>
    <div class="container">
        <div class="flex-center-between mb-sm-40 mb-24">
            <div class="img"><img src="/images/logo-light.svg" alt="" /></div>
            <ul class="gap-32 align-center">
                <li><a class="ic-burger-menu text-white h4" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions"></a>
                </li>
                @guest
                    <li><a class="text-white h6" href="/login">Login</a></li>
                @else
                    <li class="dropdown">
                        <a class="align-center small" id="dropdownMenua" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            @if (!empty(auth()->user()->social_id))
                                <div class="avatar-xl">    
                                    <img  src="{{auth()->user()->image}}" alt="profile pic">
                                </div>
                            @else
                                @if (!empty(auth()->user()->image))
                                    <div class="avatar-xl">
                                        <img src="/images/profilePictures/{{auth()->user()->image}}" alt="profile pic">
                                    </div>
                                @else
                                    <div class="avatar-initial-xl">{{auth()->user()->initials}}</div>
                                @endif
                            @endif
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                            <div class="p-24"><small class="text-cGray600 mb-12">Logged in as</small>
                                <div class="align-center">
                                    @if (!empty(auth()->user()->social_id))
                                    <div class="avatar-xxl">
                                        <img src="{{auth()->user()->image}}" alt="profile pic">
                                    </div>    
                                    @else
                                        @if (!empty(auth()->user()->image))
                                        <div class="avatar-xxl">
                                            <img src="/images/profilePictures/{{auth()->user()->image}}" alt="profile pic">
                                        </div>    
                                        @else
                                            <div class="avatar-initial-xxl">{{auth()->user()->initials}}</div>
                                        @endif
                                    @endif
                                    <div class="ml-16">
                                        <h5 class="mb-4">{{ auth()->user()->first_name .' '. auth()->user()->last_name }}</h5><small
                                            class="text-cGray600">{{ auth()->user()->email }}</small>
                                    </div>
                                </div>
                            </div>
                            <p class="text-cGray600 mb-8 px-24">More options</p>
                            <ul class="px-16 pb-16">
                                @if (auth()->user()->role->id == 1)
                                    <li><a class="dropdown-item" href="/admin/dashboard">Dashboard</a></li>
                                @endif
                                <li><a class="dropdown-item" href="/booking-history">History</a></li>
                                <li><a class="dropdown-item" href="/profile-setting">Profile Settings</a></li>
                                {{-- <li><a class="dropdown-item" href="Faq.html">Faq</a></li> --}}
                                {{-- <li><a class="dropdown-item" href="Privacy.html">Terms & Conditions</a></li> --}}
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
                    </li>
                @endguest
            </ul>
        </div>
        <div class="flex-center-between flex-wrap gap-16">
            <h3 class="text-white">{{array_key_last($breadcrumb_arr)}}</h3>
            @include('include.main.breadcrumb', ['breadcrumb' => $breadcrumb_arr])
        </div>
    </div>
</div>