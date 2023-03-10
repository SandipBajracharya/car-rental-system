<div class="offcanvas-body">
    <div class="row gap-16-row">
        <div class="col-12">
            <label class="form-label" for="formFile">Image</label>
            <input class="form-control @error('image') is-invalid @enderror" id="{{$operation}}-about_image" name="image" type="file" onchange="onFieldInput(event, true)" >
            @error('image')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-12" id="{{$operation}}-about_image_list" style="display: none;">
            <ul class="list-uploaded-file">
                <li>
                    <div class="align-center mr-2">
                        <i class="ic-file"></i>
                        <span class="p" id="{{$operation}}-about_image_item"></span>
                    </div>
                </li>
            </ul>
        </div>
        <div class="col-12">
            <label class="form-label">Heading1</label> <span class="text-danger">*</span>
            <input class="form-control @error('heading1') is-invalid @enderror" name="heading1" id="{{$operation}}-about_heading1" value="{{ old('heading1') }}" oninput="onFieldInput(event)" required/>
            @error('heading1')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-12">
            <label class="form-label">Description1</label> <span class="text-danger">*</span>
            <textarea class="form-control @error('description1') is-invalid @enderror" name="description1" id="{{$operation}}-about_description1" oninput="onFieldInput(event)" rows="7" required> {{ old('description1') }} </textarea>
            @error('description1')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-12">
            <label class="form-label">Heading2</label>
            <input class="form-control @error('heading2') is-invalid @enderror" name="heading2" id="{{$operation}}-about_heading2" value="{{ old('heading2') }}" oninput="onFieldInput(event)"/>
            @error('heading2')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-12">
            <label class="form-label">Description2</label>
            <textarea class="form-control @error('description2') is-invalid @enderror" name="description2" id="{{$operation}}-about_description2" oninput="onFieldInput(event)" rows="7"> {{ old('description2') }} </textarea>
            @error('description2')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>
