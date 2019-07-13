<div class="input-field col s12 @if($input->isAdvancedOption()) advanced-option @endif">
    <i class="material-icons prefix">{{ $input->getIcon() }}</i>
    <input class="validate" type="email" id="{{ $input->getName() }}" name="{{ $input->getName() }}" value="{{ old($input->getName()) ?: $input->getValue() }}" @if($input->isDisabled()) disabled="disabled" style="font-weight: 600; background-color: #f5f4f4 !important;"  @endif>
    <label for="{{ $input->getName() }}">{{ $input->getText() }}</label>
    @if (isset($errors) && $errors->has($input->getName()))
        <span class="help-block" style="margin-left: 45px; color: red; font-size: small; margin-top: -18px;">
            <strong>{{ $errors->first($input->getName()) }}</strong>
        </span>
    @endif
</div>