<div class="input-field col {{ $input->width() }} @if($input->isAdvancedOption()) advanced-option @endif">
    @if ($input->hasIcon()) <i class="material-icons prefix">{{ $input->getIcon() }}</i> @endif
    <span>{{ $input->getText() }}</span>
    <input type="text" id="{{ $input->getName() }}" name="{{ $input->getName() }}" value="{{ old($input->getName())  ?: $input->getValue() }}" @if($input->isDisabled()) disabled="disabled" style="font-weight: 600; background-color: rgb(251, 251, 251) !important;"  @endif class="color-box">
    @if (isset($errors) && $errors->has($input->getName()))
        <span class="help-block" style="color: red; font-size: small; margin-top: -18px;">
            <strong>{{ $errors->first($input->getName()) }}</strong>
        </span>
    @endif
</div>