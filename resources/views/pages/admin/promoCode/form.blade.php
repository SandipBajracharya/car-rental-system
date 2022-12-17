<div class="offcanvas-body">
    <div class="row gap-16-row">
        <div class="col-12">
            <label class="form-label">Promo Name</label>
            <input class="form-control @error('promo_name') is-invalid @enderror" name="promo_name" id="{{$operation}}-promo_promo_name" value="{{ old('promo_name') }}" oninput="onFieldInput(event)" />
            @error('promo_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-12">
            <label class="form-label">Promo Code</label>
            <input class="form-control @error('promo_code') is-invalid @enderror"  name="promo_code" id="{{$operation}}-promo_promo_code" value="{{ old('promo_code') }}" oninput="onFieldInput(event)" />
            @error('promo_code')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-12">
            <label class="form-label">Discount Percentage</label>
            <input class="form-control @error('discount_percentage') is-invalid @enderror" name="discount_percentage" id="{{$operation}}-promo_discount_percentage" value="{{ old('discount_percentage') }}" oninput="onFieldInput(event)" />
            @error('discount_percentage')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-12">
            <label class="form-label">Max Discount</label>
            <input class="form-control @error('max_discount') is-invalid @enderror" name="max_discount" id="{{$operation}}-promo_max_discount" value="{{ old('max_discount') }}" oninput="onFieldInput(event)" />
            @error('max_discount')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>