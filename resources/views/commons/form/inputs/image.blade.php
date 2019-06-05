<div class="input-field col s12">
    {{-- <img-fileinput imgsrc="{{ $default }}"></img-fileinput> --}}
    <img-fileinput imgsrc="/images/square/admin.png"></img-fileinput>
    @if (isset($errors) && $errors->has($input->getName()))
        <span class="help-block">
            <strong>{{ $errors->first($input->getName()) }}</strong>
        </span>
    @endif
</div>