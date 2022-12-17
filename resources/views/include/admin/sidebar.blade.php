<aside class="sidebar">
    <div class="p-12">
        <div class="sidebar__logo"><img class="img-contain" src="{{asset('images/logo-light.svg')}}" alt=""></div>
    </div>
    <div class="position-relative flex-grow-1">
        <div class="app-absolute-layout scrollable p-12">
            <ul class="sidebar__list">
                <li><a class="sidebar__link active" href="#" aria-current="page">Dashboard</a></li>
                <li class="sub-menu">
                    <a class="sidebar__link sub-menu__title" data-bs-toggle="collapse" href="#subMenu-02" role="button" aria-expanded="false" aria-controls="collapseExample">
                        <span class="text-white">Reservations</span>
                        <i class="ic-chevron-right"></i><i class="ic-chevron-up"></i>
                    </a>
                    <div class="collapse bg-primary900" id="subMenu-02">
                        <div class="gap-8-vertical px-16 pb-16">
                            <a class="sidebar__link" href="ActiveReservation.html">Active</a>
                            <a class="sidebar__link" href="CancelledReservation.html">Cancelled</a>
                            <a class="sidebar__link" href="CompletedReservation.html">Completed</a>
                        </div>
                    </div>
                </li>
                <li><a class="sidebar__link" href="/admin/vehicle" aria-current="page">Vehicles</a></li>
                <li><a class="sidebar__link" href="/admin/promo-code" aria-current="page">Promo Codes</a></li>
                <li><a class="sidebar__link" href="#" aria-current="page">Client</a></li>
                <li class="sub-menu">
                    <a class="sidebar__link sub-menu__title" data-bs-toggle="collapse" href="#subMenu-06" role="button" aria-expanded="false" aria-controls="collapseExample">
                        <span class="text-white">Customer Portal CMS</span>
                        <i class="ic-chevron-right"></i><i class="ic-chevron-up"></i>
                    </a>
                    <div class="collapse bg-primary900" id="subMenu-06">
                        <div class="gap-8-vertical px-16 pb-16">
                            <a class="sidebar__link" href="/admin/home-slider">Landing Page</a>
                            <a class="sidebar__link" href="FaqCms.html">FAQ's</a>
                            <a class="sidebar__link" href="ContactCms.html">Contact</a>
                            <a class="sidebar__link" href="AboutCms.html">About</a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</aside>
