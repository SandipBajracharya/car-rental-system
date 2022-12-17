<div class="website-inner-header">
    <div class="img-background"><img src="/images/product4.jpg" alt="" /></div>
    <div class="container">
        <div class="flex-center-between mb-sm-40 mb-24">
            <div class="img"><img src="/images/logo-light.svg" alt="" /></div>
            <ul class="gap-32 align-center">
                <li><a class="ic-burger-menu text-white h4" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions"></a>
                </li>
                <li><a class="text-white h6" href="/login">Login</a></li>
            </ul>
        </div>
        <div class="flex-center-between flex-wrap gap-16">
            <h3 class="text-white">{{array_key_last($breadcrumb_arr)}}</h3>
            @include('include.main.breadcrumb', ['breadcrumb' => $breadcrumb_arr])
        </div>
    </div>
</div>