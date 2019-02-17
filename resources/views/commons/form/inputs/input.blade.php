<div class="input-field col s12">
    <i class="material-icons prefix">{{$icon}}</i>
    <input type="text" id="{{$name}}" name="{{$name}}" value="{{ old($name)  ?: $value}}">
    <label for="name">{{$text}}</label>
    @if ($errors->has($name))
        <span class="help-block">
            <strong>{{ $errors->first($name) }}</strong>
        </span>
    @endif
</div>