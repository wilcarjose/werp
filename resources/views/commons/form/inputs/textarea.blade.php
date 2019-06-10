<div class="input-field col s12">
    <i class="material-icons prefix">{{ $input->getIcon() }}</i>
    <textarea name="{{ $input->getName() }}" id="{{ $input->getName() }}" placeholder="Escribe aquí" class="materialize-textarea">{{ old($input->getName())  ?: $input->getValue() }}</textarea>
    <label for="{{ $input->getName() }}">{{ $input->getText() }}</label>
    @if (isset($errors) && $errors->has($input->getName()))
        <span class="help-block">
            <strong>{{ $errors->first($input->getName()) }}</strong>
        </span>
    @endif
</div>