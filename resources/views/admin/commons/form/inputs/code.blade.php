<div class="input-field col {{ $input->width() }} @if($input->isAdvancedOption()) advanced-option @endif">
    @if ($input->hasIcon()) <i class="material-icons prefix">{{ $input->getIcon() }}</i> @endif
    <input type="text" id="{{ $input->getName() }}" name="{{ $input->getName() }}" value="{{ old($input->getName())  ?: $input->getValue() }}" disabled="disabled" style="font-weight: 400; font-size: 2rem; background-color: #fff;">
    <label for="{{ $input->getName() }}">{{ $input->getText() }}</label>
    @if (isset($errors) && $errors->has($input->getName()))
        <span class="help-block" style="margin-left: 45px; color: red; font-size: small; margin-top: -18px;">
            <strong>{{ $errors->first($input->getName()) }}</strong>
        </span>
    @endif
</div>
