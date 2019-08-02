
<div class="input-field col s12 @if($input->isAdvancedOption()) advanced-option @endif">
    <i class="material-icons prefix">{{ $input->getIcon() }}</i>
    <input type="text" id="{{ $input->getAddressName1() }}" name="{{ $input->getAddressName1() }}" value="{{ old($input->getAddressName1())  ?: $input->getAddressValue1() }}" @if($input->isDisabled()) disabled="disabled" style="font-weight: 600; background-color: rgb(251, 251, 251) !important;"  @endif>
    <input type="text" id="{{ $input->getAddressName2() }}" name="{{ $input->getAddressName2() }}" value="{{ old($input->getAddressName2())  ?: $input->getAddressValue2() }}" @if($input->isDisabled()) disabled="disabled" style="font-weight: 600; background-color: rgb(251, 251, 251) !important;"  @endif>
    <label for="{{ $input->getAddressName2() }}">{{ $input->getText() }}</label>
    @if (isset($errors) && $errors->has($input->getAddressName1()))
        <span class="help-block" style="margin-left: 45px; color: red; font-size: small; margin-top: -18px;">
            <strong>{{ $errors->first($input->getAddressName1()) }}</strong>
        </span>
    @endif
</div>
