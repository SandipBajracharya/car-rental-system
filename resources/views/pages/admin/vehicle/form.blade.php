<div class="offcanvas-body">
    <div class="row gap-16-row">
        <div class="col-12">
            <label class="form-label" for="formFileMultiple">Multiple images</label>
            <input class="form-control @error('images.*') is-invalid @enderror" id="{{$operation}}-vehicle_images" type="file" multiple="multiple" name="images[]" onchange="onFieldInput(event, true)" />
            @error('images.*')
                <span class="invalid-feedback" role="alert">
                    <strong>Images must be an image</strong>
                </span>
            @enderror
        </div>
        <div class="col-12" id="{{$operation}}-vehicle_image_list" style="display: none;">
            <ul class="list-uploaded-file" id="{{$operation}}-vehicle_image_item">
            </ul>
        </div>
        <div class="col-12">
            <label class="form-label">Description</label>
            <textarea class="form-control @error('description') is-invalid @enderror" placeholder="Vehicle Description" name="description" id="{{$operation}}-vehicle_description" oninput="onFieldInput(event)" >{{old('description')}}</textarea>
            @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-12">
            <label class="form-label">Features</label>
            <textarea class="form-control @error('features') is-invalid @enderror" placeholder="Vehicle features" name="features" id="{{$operation}}-vehicle_features" oninput="onFieldInput(event)" >{{old('features')}}</textarea>
            @error('features')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
            <div class="mt-4"><small><strong class="text-danger">Note: </strong> Separate features with comma. Example: Comfortable, AC</small></div>
        </div>
        <div class="col-6">
            <label class="form-label">Model</label>
            <input class="form-control @error('model') is-invalid @enderror" placeholder="Vehicle Model" name="model" id="{{$operation}}-vehicle_model" value="{{ old('model') }}" oninput="onFieldInput(event)" />
            @error('model')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-6">
            <label class="form-label">Plate No.</label>
            <input class="form-control @error('plate_number') is-invalid @enderror" name="plate_number" id="{{$operation}}-vehicle_plate_number" value="{{ old('plate_number') }}" oninput="onFieldInput(event)" />
            @error('plate_number')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-6">
            <label class="form-label">Mileage</label>
            <input class="form-control @error('mileage') is-invalid @enderror" name="mileage" id="{{$operation}}-vehicle_mileage" value="{{ old('mileage') }}" oninput="onFieldInput(event)" />
            @error('mileage')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-6">
            <label class="form-label">Fuel Vol.</label>
            <input class="form-control @error('fuel_volume') is-invalid @enderror" name="fuel_volume" id="{{$operation}}-vehicle_fuel_volume" value="{{ old('fuel_volume') }}" oninput="onFieldInput(event)" />
            @error('fuel_volume')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-6">
            <label class="form-label">Ocupancy</label>
            <input class="form-control @error('occupancy') is-invalid @enderror" name="occupancy" id="{{$operation}}-vehicle_occupancy" value="{{ old('occupancy') }}" oninput="onFieldInput(event)" />
            @error('occupancy')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-6">
            <label class="form-label">Pricing</label>
            <input class="form-control @error('pricing') is-invalid @enderror" name="pricing" id="{{$operation}}-vehicle_pricing" value="{{ old('pricing') }}" oninput="onFieldInput(event)" />
            @error('pricing')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-6">
            <label class="form-label">Status</label>
            {{-- <input class="form-check-input @error('is_reserved_now') is-invalid @enderror" type="checkbox" name="is_reserved_now" id="{{$operation}}-vehicle_is_reserved_now" value="{{ old('is_reserved_now') }}" oninput="onFieldInput(event)"/> --}}
            <select class="form-control @error('is_reserved_now') is-invalid @enderror" name="is_reserved_now" id="{{$operation}}-vehicle_is_reserved_now" oninput="onFieldInput(event)" >
                <option value="">Select car status</option>
                <option value="1" id="{{$operation}}-vehicle_reserved">Reserved</option>
                <option value="0" id="{{$operation}}-vehicle_not_reserved">Not reserved</option>
            </select>
            @error('is_reserved_now')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>
