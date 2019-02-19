<div class="input-field col s12">
    <i class="material-icons prefix">{{ $input->getIcon() }}</i>
    <input type="text" id="{{ $input->getName() }}" name="{{ $input->getName() }}" value="{{ old($input->getName())  ?: $input->getValue() }}">
    <label for="name">{{ $input->getText() }}</label>
    @if ($errors->has($input->getName()))
        <span class="help-block">
            <strong>{{ $errors->first($input->getName()) }}</strong>
        </span>
    @endif
</div>