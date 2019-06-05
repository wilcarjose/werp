<div class="input-field col s12">
    <i class="material-icons prefix">{{ $input->getIcon() }}</i>
    <input class="validate" type="email" id="{{ $input->getName() }}" name="{{ $input->getName() }}" value="{{ old($input->getName()) ?: $input->getValue() }}">
    <label for="{{ $input->getName() }}">{{ $input->getText() }}</label>
    @if (isset($errors) && $errors->has($input->getName()))
        <span class="help-block">
            <strong>{{ $errors->first($input->getName()) }}</strong>
        </span>
    @endif
</div>