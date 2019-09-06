<div class="input-field col s12 @if($input->isAdvancedOption()) advanced-option @endif">
    <i class="material-icons prefix">{{ $input->getIcon() }}</i> 
    <input type="text" id="{{ $input->getName() }}" name="{{ $input->getName() }}" value="{{ old($input->getName())  ?: $input->getValue() }}" @if($input->isDisabled()) disabled="disabled" style="font-weight: 600; background-color: rgb(251, 251, 251) !important;"  @endif class="number-input">
    <label for="{{ $input->getName() }}">{{ $input->getText() }}</label>
    @if (isset($errors) && $errors->has($input->getName()))
        <span class="help-block" style="margin-left: 45px; color: red; font-size: small; margin-top: -18px;">
            <strong>{{ $errors->first($input->getName()) }}</strong>
        </span>
    @endif
</div>
