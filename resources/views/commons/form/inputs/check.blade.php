<div class="input-field col s12 m4 l4 @if($input->isAdvancedOption()) advanced-option @endif" style="margin-bottom: 30px; margin-left: 32px; margin-top: 0px;">
    <input type="checkbox" id="{{ $input->getName() }}" name="{{ $input->getName() }}" @if ($input->isChecked()) checked="checked" @endif @if($input->isDisabled()) disabled="disabled" @endif />
    <label for="{{ $input->getName() }}">{{ $input->getText() }}</label>
</div>
