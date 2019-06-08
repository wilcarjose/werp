<div class="input-field col s12">
    <i class="material-icons prefix">{{ $input->getIcon() }}</i>
    
	<select name="{{ $input->getName() }}" id="{{ $input->getName() }}" class="basic-select">
	  	<option value="" disabled="disabled" selected="selected">Seleccione ...</option>
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

@section('jsPostApp')

<script>

	$(document).ready(function() {
	  $('select').material_select();
	});
	
</script>

@endsection