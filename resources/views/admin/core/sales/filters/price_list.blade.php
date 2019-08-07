<div class="col s12" style="margin-left: 3rem; margin-top: 15px;">
  <h5 style="font-size: 20px;">Filtros:</h5>
</div>

<div class="select2-input col s12" style="margin-left: 43px; width: 97%;margin-bottom: 14px;">
 {{--   <i class="material-icons prefix">{{ $input->getIcon() }}</i> --}}
    <label for="filter">Filtro</label>
	<select name="filter" id="filter" class="select2_select">
	  	<option value="" disabled selected="selected">Seleccione ...</option>
	  		<option value="0">{{ trans('view.none') }}</option>
	  		<option value="1">Opción 1</option>
	</select>
  {{-- 
    @if (isset($errors) && $errors->has($input->getName()))
        <span class="help-block" style="margin-left: 2px; color: red; font-size: small; margin-top: 2px;">
            <strong>{{ $errors->first($input->getName()) }}</strong>
        </span>
    @endif
  --}}
</div>

<div class="row">
  <div class="input-field col s12 m4 l4">
    <input type="checkbox" id="cb2" checked="checked"/>
    <label for="cb2">Checked</label>
  </div>
  <div class="input-field col s12 m6 l6">
    <input type="text" id="box-input2" placeholder="" class="validate box-input"/>
    <label for="box-input2">.col.s12.m6.l6</label>
  </div>
  <div class="input-field col s12 m2 l2">
    <input type="text" id="box-input3" placeholder="" class="validate box-input"/>
    <label for="box-input3">.col.s12.m2.l2</label>
  </div>
</div>

<button style="margin-left: 3rem; margin-top: 15px; margin-bottom: 15px;" class="btn waves-effect waves-set" type="submit" name="filert" value="filter"> Cargar productos
    <i class="material-icons left"></i>
</button>


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