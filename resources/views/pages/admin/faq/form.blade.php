<div class="offcanvas-body">
    <div class="row gap-16-row">
        <div class="col-12">
            <label class="form-label" for="formFile">Question</label> <span class="text-danger">*</span>
            <input class="form-control @error('question') is-invalid @enderror" id="{{$operation}}-faq_question" name="question" type="text" value="{{ old('question') }}" oninput="onFieldInput(event)" required>
            @error('question')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-12">
            <label class="form-label">Answer</label> <span class="text-danger">*</span>
            <textarea class="form-control @error('answer') is-invalid @enderror" name="answer" id="{{$operation}}-faq_answer" oninput="onFieldInput(event)" required>{{ old('answer') }}</textarea>
            @error('answer')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>
