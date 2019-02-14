<div class="input-field col s12">
    <img-fileinput imgsrc="{{ $default }}"></img-fileinput>
    @if ($errors->has($name))
        <span class="help-block">
            <strong>{{ $errors->first($name) }}</strong>
        </span>
    @endif
</div>