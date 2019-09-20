<div class="col {{ $input->width() }} @if($input->isAdvancedOption()) advanced-option @endif" style="margin-bottom: 25px;">
	@foreach ($input->options() as $option)
		<p class="col {{ $option->width() }}">
			<input type="radio" name="{{ $input->getName() }}" id="{{ $option->id() }}" value="{{ $option->id() }}" @if ($option->isChecked()) checked="checked" @endif class="with-gap" @if($option->isDisabled()) disabled="disabled" @endif/>
			<label for="{{ $option->id() }}">{{ $option->label() }}</label>
		</p>
	@endforeach
</div>