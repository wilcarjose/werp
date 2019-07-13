<div class="input-field col s12 @if($input->isAdvancedOption()) advanced-option @endif" style="margin-bottom: 15px; margin-top: 25px;">
    <i class="material-icons prefix">{{ $input->getIcon() }}</i> 
    {{--  <input type="number" id="{{ $input->getName() }}" name="{{ $input->getName() }}" value="{{ old($input->getName())  ?: $input->getValue() }}" @if($input->isDisabled()) disabled="disabled" style="font-weight: 600; background-color: #f5f4f4 !important;"  @endif> --}}
    <input class="easyui-numberbox" id="{{ $input->getName() }}" name="{{ $input->getName() }}" value="{{ old($input->getName())  ?: $input->getValue() }}" @if($input->isDisabled()) disabled="disabled" style="font-weight: 600; background-color: #f5f4f4 !important;"  @endif data-options="label:'',labelPosition:'top',precision:2,groupSeparator:'.',decimalSeparator:',',width:'100%'">
    <label for="{{ $input->getName() }}" style="margin-left: 3rem; margin-top: -13px;">{{ $input->getText() }}</label>
    @if (isset($errors) && $errors->has($input->getName()))
        <span class="help-block" style="margin-left: 45px; color: red; font-size: small; margin-top: -18px;">
            <strong>{{ $errors->first($input->getName()) }}</strong>
        </span>
    @endif
</div>
