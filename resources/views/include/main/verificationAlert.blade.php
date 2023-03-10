<div class="alert alert-primary mb-24">
    <span class="text-danger"><strong>Note</strong></span>:  {{$message ?? ''}}
    @if (isset($link) && !empty($link))
        <a href="{{$link}}" class="text-primary px-4"><strong>Click here</strong></a> to proceed.
    @endif
</div>
