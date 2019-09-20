<div class="input-field col {{ $input->width() }} @if($input->isAdvancedOption()) advanced-option @endif">
    @if ($input->hasIcon()) <i class="material-icons prefix">{{ $input->getIcon() }}</i> @endif
    <textarea name="{{ $input->getName() }}" id="{{ $input->getName() }}" placeholder="Escribe aquí" class="materialize-textarea" @if($input->isDisabled()) disabled="disabled" style="font-weight: 600; background-color: rgb(251, 251, 251) !important;"  @endif>{{ old($input->getName())  ?: $input->getValue() }}</textarea>
    <label for="{{ $input->getName() }}">{{ $input->getText() }}</label>
    @if (isset($errors) && $errors->has($input->getName()))
        <span class="help-block" style="margin-left: 45px; color: red; font-size: small; margin-top: -18px;">
            <strong>{{ $errors->first($input->getName()) }}</strong>
        </span>
    @endif
</div>