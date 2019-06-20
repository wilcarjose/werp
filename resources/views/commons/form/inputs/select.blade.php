<div class="input-field col s12 @if($input->isAdvancedOption()) advanced-option @endif">
    <i class="material-icons prefix">{{ $input->getIcon() }}</i>
    
	<select name="{{ $input->getName() }}" id="{{ $input->getName() }}" class="basic-select" @if($input->isDisable()) disabled="disabled" style="font-weight: 600; background-color: #f5f4f4 !important;" @endif>
	  	<option value="" disabled="disabled" selected="selected">Seleccione ...</option>
		@if ($input->hasNone())
	  		<option value="0">{{ trans('view.none') }}</option>
	  	@endif
	  	@foreach($input->getData() as $option)
	  		<option value="{{ $option->id }}" @if ($input->isValue($option->id)) selected="selected" @endif>{{ $option->name }}</option>
	  	@endforeach
	</select>

	<label for="{{ $input->getName() }}">{{ $input->getText() }}</label>
    
    @if (isset($errors) && $errors->has($input->getName()))
        <span class="help-block">
            <strong>{{ $errors->first($input->getName()) }}</strong>
        </span>
    @endif
</div>
