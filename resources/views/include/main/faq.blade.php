@php
    $faqs = getFaqs(5);
@endphp

<div class="flex-center-between border-bottom border-gray200 pb-16 mb-8">
    <h3 class="text-primary">FAQ's</h3><a href="/faq">View All</a>
</div>
<div class="accordion-01" id="accordionFaq">
    @foreach ($faqs as $index => $item)
        <div class="accordion-item py-24">
            <h2 class="accordion-header" id="headingOne{{$item->item}}">
                <button class="btn accordion-btn" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$item->id}}" aria-expanded="{{$index == 0? 'true' : 'false'}}" aria-controls="collapse{{$item->id}}">
                    <h6>{{$item->question}}</h6>
                </button></h2>
            <div class="accordion-collapse collapse {{$index == 0? 'show' : ''}}" aria-labelledby="headingOne{{$item->item}}" data-bs-parent="#accordionFaq" id="collapse{{$item->id}}">
                <div class="accordion-body">
                    <p class="text-cGray700">{{$item->answer}}</p>
                </div>
            </div>
        </div>
    @endforeach
</div>