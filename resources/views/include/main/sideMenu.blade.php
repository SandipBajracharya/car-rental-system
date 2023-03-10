<div class="offcanvas offcanvas-start offcanvas-website-nav" id="offcanvasWithBothOptions" data-bs-scroll="true"
    tabindex="-1" aria-labelledby="offcanvasWithBothOptionsLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">{{config('app.name')}}</h5><button
            class="btn btn-red btn-sm" type="button" data-bs-dismiss="offcanvas" aria-label="Close"><i
                class="ic-close"></i></button>
    </div>
    <div class="offcanvas-body">
        <ul class="gap-32-vertical">
            <li><a href="/">Home</a></li>
            <li><a href="{{getCarListUrl()}}">Our Cars</a></li>
            <li><a href="/contact-us">Contact</a></li>
            <li><a href="/faq">FAQs</a></li>
            <li><a href="/about-us">About Us</a></li>
        </ul>
    </div>
</div>
