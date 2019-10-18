<div class="input-field col {{ $input->width() }} @if($input->isAdvancedOption()) advanced-option @endif">
    @if ($input->hasIcon()) <i class="material-icons prefix">{{ $input->getIcon() }}</i> @endif
    {{-- <input type="text" id="{{ $input->getName() }}" name="{{ $input->getName() }}" value="{{ old($input->getName())  ?: $input->getValue() }}" @if($input->isDisabled()) disabled="disabled" style="font-weight: 600; background-color: #f5f4f4 !important;"  @endif>  --}}
    <input id="date-{{ $input->getName() }}" type="text" class="datetime-box" @if($input->isDisabled()) disabled="disabled" style="margin: 0 !important; font-weight: 600; background-color: rgb(251, 251, 251) !important;"  @else style="margin: 0 0 20px 0 !important;" @endif>

    <input type="hidden" id="{{ $input->getName() }}" name="{{ $input->getName() }}" value="{{ old($input->getName())  ?: $input->getValue() }}">

    <label for="{{ $input->getName() }}">{{ $input->getText() }}</label>
    @if (isset($errors) && $errors->has($input->getName()))
        <span class="help-block" style="color: red; font-size: small; margin-top: -18px;">
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
