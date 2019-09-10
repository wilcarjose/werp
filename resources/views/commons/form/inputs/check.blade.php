<div class="input-field col {{ $input->width() }} @if($input->isAdvancedOption()) advanced-option @endif" style="margin-bottom: 30px; margin-top: 0px;">
    <input type="checkbox" id="{{ $input->getName() }}" name="{{ $input->getName() }}" @if ($input->isChecked()) checked="checked" @endif @if($input->isDisabled()) disabled="disabled" @endif />
    <label for="{{ $input->getName() }}">{{ $input->getText() }}</label>
</div>
