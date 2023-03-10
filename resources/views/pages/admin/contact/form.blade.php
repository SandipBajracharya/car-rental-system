<div class="offcanvas-body">
    <div class="row gap-16-row">
        <div class="col-12">
            <label class="form-label">Address</label> <span class="text-danger">*</span>
            <input class="form-control @error('address') is-invalid @enderror" id="{{$operation}}-contact_address" name="address" type="text" value="{{ old('address') }}" oninput="onFieldInput(event)" required>
            @error('address')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-12">
            <label class="form-label">Phone</label> <span class="text-danger">*</span>
            <input class="form-control @error('phone') is-invalid @enderror" id="{{$operation}}-contact_phone" name="phone" type="text" value="{{ old('phone') }}" oninput="onFieldInput(event)" placeholder="example: +08-8948161 / 0451143988" required>
            @error('phone')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-12">
            <label class="form-label">Email</label> <span class="text-danger">*</span>
            <input class="form-control @error('email') is-invalid @enderror" name="email" id="{{$operation}}-contact_email" oninput="onFieldInput(event)" value="{{ old('email') }}" required/>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-12">
            <label class="form-label">Facebook link</label>
            <input class="form-control @error('facebook_link') is-invalid @enderror" name="facebook_link" id="{{$operation}}-contact_facebook_link" oninput="onFieldInput(event)" value="{{ old('facebook_link') }}" placeholder="example: https://www.facebook.com/" />
            @error('facebook_link')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-12">
            <label class="form-label">Twitter link</label>
            <input class="form-control @error('twitter_link') is-invalid @enderror" name="twitter_link" id="{{$operation}}-contact_twitter_link" oninput="onFieldInput(event)" value="{{ old('twitter_link') }}" placeholder="example: https://www.twitter.com/"/>
            @error('twitter_link')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-12">
            <label class="form-label">Instagram link</label>
            <input class="form-control @error('insta_link') is-invalid @enderror" name="insta_link" id="{{$operation}}-contact_insta_link" oninput="onFieldInput(event)" value="{{ old('insta_link') }}" placeholder="example: https://www.instagram.com/"/>
            @error('insta_link')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-12">
            <label class="form-label">Embedded map link</label>
            <input class="form-control @error('map') is-invalid @enderror" name="map" id="{{$operation}}-contact_map" oninput="onFieldInput(event)" value="{{ old('map') }}" placeholder="example: https://www.google.com/maps/embed?..."/>
            @error('map')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>
