<div class="file-field input-field col {{ $input->width() }} @if($input->isAdvancedOption()) advanced-option @endif" id="{{ $input->getName() }}-box" style="{{ $input->hide() ? 'display: none;' : '' }}">
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

@if (!is_null($input->hide()))

    @push('show-hide')

        <script>

            $(document).ready(function() {            	
                @foreach ($input->showInputs() as $showInput)                	
	                $('#{{ $showInput }}').click(function() {
	                    if($(this).prop("checked") == false){
	                        $('#{{ $input->getName() }}-box').hide(200);
	                        $('#{{ $input->getName() }}-box').hide(200);
	                    }
	                    else if($(this).prop("checked") == true){
	                        $('#{{ $input->getName() }}-box').show(200);
	                        $('#{{ $input->getName() }}-box').show(200);
	                    }
	                });
                @endforeach

                @foreach ($input->hideInputs() as $hideInput)                	
	                $('#{{ $hideInput }}').click(function() {
	                    if($(this).prop("checked") == false){
	                        $('#{{ $input->getName() }}-box').show(200);
	                        $('#{{ $input->getName() }}-box').show(200);
	                    }
	                    else if($(this).prop("checked") == true){
	                        $('#{{ $input->getName() }}-box').hide(200);
	                        $('#{{ $input->getName() }}-box').hide(200);
	                    }
	                });
                @endforeach
            })

        </script>

    @endpush

@endif