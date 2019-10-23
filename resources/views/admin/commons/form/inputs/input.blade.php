<div class="input-field col {{ $input->width() }} @if($input->isAdvancedOption()) advanced-option @endif" id="{{ $input->getName() }}-box" style={{ $input->hide() ? 'display: none;' : '' }}">
    @if ($input->hasIcon()) <i class="material-icons prefix">{{ $input->getIcon() }}</i> @endif
    <input type="text" id="{{ $input->getName() }}" name="{{ $input->getName() }}" value="{{ old($input->getName())  ?: $input->getValue() }}" @if($input->isDisabled()) disabled="disabled" style="font-weight: 600; background-color: rgb(251, 251, 251) !important;"  @endif>
    <label for="{{ $input->getName() }}">{{ $input->getText() }}</label>
    @if (isset($errors) && $errors->has($input->getName()))
        <span class="help-block" style="color: red; font-size: small; margin-top: -18px;">
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
                        $('#{{ $input->getName() }}').hide(200);
                        $('#{{ $input->getName() }}').hide(200);
                    }
                    else if($(this).prop("checked") == true){
                        $('#{{ $input->getName() }}').show(200);
                        $('#{{ $input->getName() }}').show(200);
                    }
                });
                @endforeach

                @foreach ($input->hideInputs() as $hideInput)
                $('#{{ $hideInput }}').click(function() {
                    if($(this).prop("checked") == false){
                        $('#{{ $input->getName() }}').show(200);
                        $('#{{ $input->getName() }}').show(200);
                    }
                    else if($(this).prop("checked") == true){
                        $('#{{ $input->getName() }}').hide(200);
                        $('#{{ $input->getName() }}').hide(200);
                    }
                });
                @endforeach
            })

        </script>

    @endpush

@endif
