<div class="input-field col s12 @if($input->isAdvancedOption()) advanced-option @endif">
    <i class="material-icons prefix">{{ $input->getIcon() }}</i>
    {{-- <input type="text" id="{{ $input->getName() }}" name="{{ $input->getName() }}" value="{{ old($input->getName())  ?: $input->getValue() }}" @if($input->isDisabled()) disabled="disabled" style="font-weight: 600; background-color: #f5f4f4 !important;"  @endif>  --}}
    <input id="date-{{ $input->getName() }}" type="text" class="datetime-box" @if($input->isDisabled()) disabled="disabled" style="font-weight: 600; background-color: #f5f4f4 !important;"  @endif>

    <input type="hidden" id="{{ $input->getName() }}" name="{{ $input->getName() }}" value="{{ old($input->getName())  ?: $input->getValue() }}">

    <label for="{{ $input->getName() }}">{{ $input->getText() }}</label>
    @if (isset($errors) && $errors->has($input->getName()))
        <span class="help-block" style="margin-left: 45px; color: red; font-size: small; margin-top: -18px;">
            <strong>{{ $errors->first($input->getName()) }}</strong>
        </span>
    @endif

    @section('js-datebox')
	    <script>
	    	$(document).ready(function() {
		    	$("{{ '#date-' . $input->getName() }}").on('apply.daterangepicker', function(ev, picker) {
		    	  $("{{ '#' . $input->getName() }}").val(picker.startDate.format('YYYY-MM-DD HH:mm:ss'));
				  //console.log(picker.startDate.format('YYYY-MM-DD HH:mm:ss'));
				  //console.log(picker.endDate.format('YYYY-MM-DD'));
				});

				$("{{ '#date-' . $input->getName() }}").data('daterangepicker').setStartDate(moment("{{ old($input->getName())  ?: $input->getValue() }}", "YYYY-MM-DD HH:mm:ss").format('DD/MM/YYYY hh:mm A'));
			});
	    </script>
    @endsection
</div>
