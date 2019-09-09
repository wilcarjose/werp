
<div class="select2-input col {{ $input->width() }} @if($input->isAdvancedOption()) advanced-option @endif" style="margin-bottom: 14px;">
 {{--   <i class="material-icons prefix">{{ $input->getIcon() }}</i> --}}
  <label for="{{ $input->getName() }}">{{ $input->getText() }}</label>
	<select name="{{ $input->getName() }}" id="{{ $input->getName() }}" class="select2_select" @if($input->isDisable()) disabled="disabled" style="font-weight: 600; background-color: #f5f4f4 !important;" @endif multiple="multiple">
	  	@foreach($input->getData() as $option)
	  		@if ($input->isArrayItem())
	  			<option value="{{ $option[$input->getIdKey()] }}" @if ($input->isValue($option[$input->getIdKey()])) selected @endif>{{ $option[$input->getLabelKey()] }}</option>
	  		@else
	  			<option value="{{ $option->{$input->getIdKey()} }}" @if ($input->isValue($option->{$input->getIdKey()})) selected @endif>{{ $option->{$input->getLabelKey()} }}</option>
	  		@endif
	  	@endforeach
	</select>
    @if (isset($errors) && $errors->has($input->getName()))
        <span class="help-block" style="margin-left: 2px; color: red; font-size: small; margin-top: 2px;">
            <strong>{{ $errors->first($input->getName()) }}</strong>
        </span>
    @endif
</div>


<!--
  <div class="select2-input col s12" style="margin-left: 45px; width: 97%;">
  	<label for="single-select">Ciudades</label>
    <select class="select2_select" id="single-select" name="single-select">
      <option value="United States">United States</option>
      <option value="United Kingdom">United Kingdom</option>
      <option value="Afghanistan">Afghanistan</option>
      <option value="" disabled>Sun Bear</option>
      <option value="Aland Islands" selected>Aland Islands</option>
    </select>
  </div>
-->