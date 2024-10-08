<div class="offcanvas-body">
    <div class="row gap-16-row">
        <div class="col-12">
            <label class="form-label" for="formFile">Slide Image</label>
            <input class="form-control @error('image') is-invalid @enderror" id="{{$operation}}-home_slider_image" name="image" type="file" onchange="onFieldInput(event, true)" >
            @error('image')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-12" id="{{$operation}}-home_slider_image_list" style="display: none;">
            <ul class="list-uploaded-file">
                <li>
                    <div class="align-center mr-2">
                        <i class="ic-file"></i>
                        <span class="p" id="{{$operation}}-home_slider_image_item"></span>
                    </div>
                </li>
            </ul>
        </div>
        <div class="col-12">
            <label class="form-label">Heading</label>
            <input class="form-control @error('heading') is-invalid @enderror" name="heading" id="{{$operation}}-home_slider_heading" value="{{ old('heading') }}" oninput="onFieldInput(event)"/>
            @error('heading')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>
