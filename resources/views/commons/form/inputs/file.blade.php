<div class="file-field input-field col s12 @if($input->isAdvancedOption()) advanced-option @endif">
	<div class="btn">
		<span>{{ $input->getText() }}</span>
		<input type="file" id="{{ $input->getName() }}" name="{{ $input->getName() }}" value="{{ old($input->getName())  ?: $input->getValue() }}" @if($input->isDisabled()) disabled="disabled" style="font-weight: 600; background-color: rgb(251, 251, 251) !important;"  @endif>
	</div>
	<div class="file-path-wrapper">
		<input class="file-path validate" type="text" placeholder="{{ $input->getPlaceholder() }}">
	</div>
	@if (isset($errors) && $errors->has($input->getName()))
        <span class="help-block" style="margin-left: 45px; color: red; font-size: small; margin-top: -18px;">
            <strong>{{ $errors->first($input->getName()) }}</strong>
        </span>
    @endif
</div>