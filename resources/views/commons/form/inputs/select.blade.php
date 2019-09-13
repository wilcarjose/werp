
<div class="select2-input col {{ $input->width() }} @if($input->isAdvancedOption()) advanced-option @endif" id="{{ $input->getName() }}-box" style="margin-bottom: 14px; {{ $input->hide() ? 'display: none;' : '' }}">
 {{--   <i class="material-icons prefix">{{ $input->getIcon() }}</i> --}}
  <label for="{{ $input->getName() }}">{{ $input->getText() }}</label>
	<select name="{{ $input->getName() }}" id="{{ $input->getName() }}" class="select2_select" @if($input->isDisable()) disabled="disabled" style="font-weight: 600; background-color: #f5f4f4 !important;" @endif>
	  	<option value="" disabled selected="selected">Seleccione ...</option>
      @if ($input->allowNew())
        <option value="new">Crear nuevo </option>
      @endif
		  @if ($input->hasNone())
	  		<option value="{{ null }}">{{ trans('view.none') }}</option>
	  	@endif
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

@if ($input->allowNew())
    <div id="new-{{ $input->getName() }}-modal" class="modal modal-fixed-footer" style="width: 50%">
        <div class="modal-content">
            <div class="row">
              <div class="col s12">
                <div class="card card-dash">
                  <div class="card-header primary-bg z-depth-2"><i class="material-icons left">add</i>
                    <span class="caption">{{ $input->getModal()->getTitle() }}</span>
                  </div>
                  <div class="card-content">
                    
                    <div class="row">

                        <div class="col s12" style="color: #3d3d3d">

                            @foreach($input->getModal()->getInputs() as $formInput)
                                <div class="row">
                                  <div class="input-field col s12">
                                    <input type="text" id="add-{{ $input->getName() }}-{{ $formInput->getName() }}" name="add-{{ $input->getName() }}-{{ $formInput->getName() }}" placeholder="{{ $formInput->getText() }}" class="validate">
                                    <label for="document" class="active">{{ $formInput->getText() }}</label>
                                  </div>
                                </div>
                            @endforeach

                            <div class="row" id='add-new-button'>
                              <button class="btn waves-effect waves-light" type="button" name="action" id="add-new-{{ $input->getName() }}">Guardar
                                <i class="material-icons right">add</i>
                              </button>

                              <div class="preloader-wrapper small active" id="add-new-{{ $input->getName() }}-saving" style="display: none;">
                                <div class="spinner-layer spinner-green-only">
                                  <div class="circle-clipper left">
                                    <div class="circle"></div>
                                  </div><div class="gap-patch">
                                    <div class="circle"></div>
                                  </div><div class="circle-clipper right">
                                    <div class="circle"></div>
                                  </div>
                                </div>
                              </div>

                            </div>
                            
                        </div>
                      
                    </div>
                  </div>
                  <div class="card-footer">
                    <div class="stats"><i class="material-icons red-text">new</i><a href="#">
                    </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
        <div class="modal-footer">
          <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Cerrar</a>
        </div>
    </div>

@endif

@push('selects')

    <script>

      $('#{{ $input->getName() }}' ).select2({
          templateResult: formatState
      });

      @if ($input->allowNew())

        $(document).ready(function() {
          // the "href" attribute of . must specify the modal ID that wants to be triggered
          $('#new-{{ $input->getName() }}-modal').modal({
              dismissible: true, // Modal can be dismissed by clicking outside of the modal
              opacity: .5, // Opacity of modal background
              inDuration: 300, // Transition in duration
              outDuration: 200, // Transition out duration
              startingTop: '4%', // Starting top style attribute
              endingTop: '10%', // Ending top style attribute
              ready: function(modal, trigger) { // Callback for Modal open. Modal and trigger parameters available.
                  //console.log(modal, trigger);
              },
              complete: function() {
                  $("#add-new-{{ $input->getName() }}").show();
                  $("#add-new-{{ $input->getName() }}-saving").hide();

                  @foreach($input->getModal()->getInputs() as $formInput)
                    $('#add-{{ $input->getName() }}-{{ $formInput->getName() }}').val('');
                  @endforeach
              } // Callback for Modal close
          });

          $('#{{ $input->getName() }}').on('select2:select', function (e) {

            if (e.params.data.id == 'new') {
                $('#{{ $input->getName() }}').val('').trigger('change');
                $('#new-{{ $input->getName() }}-modal').modal('open');
            }

          });

          $('#add-new-{{ $input->getName() }}').click(function(e) {

              e.preventDefault();

              var data = {_token: $('meta[name="csrf-token"]').attr("content")};

              @foreach($input->getModal()->getInputs() as $formInput)
                data['{{ $formInput->getName() }}'] = $('#add-{{ $input->getName() }}-{{ $formInput->getName() }}').val();
              @endforeach

              $.ajax({
                url: "{{ $input->getModal()->getEndpoint() }}",
                type: "POST",
                dataType: "json",
                data: data,
                beforeSend: function (xhr) {
                  $("#add-new-{{ $input->getName() }}").hide();
                  $("#add-new-{{ $input->getName() }}-saving").show();
                }
              }).done(function(response) {
                var newOption = new Option(response.data['{{ $input->getModal()->getLabel() }}'], response.data.id, true, true);
                $('#{{ $input->getName() }}').append(newOption).trigger('change');
                $('#new-{{ $input->getName() }}-modal').modal('close');
              }).done(function(error) {
                console.log(error);
              });

          })

        })

      @endif

    </script>

@endpush


@if (!is_null($input->hide()))

  @push('show-hide')

    <script>
      
      $(document).ready(function() {

        $('#{{ $input->showInput() }}').click(function() {
              if($(this).prop("checked") == false){
                $('#{{ $input->getName() }}-box').hide(200);
                $('#{{ $input->getName() }}-box').hide(200);
              }
              else if($(this).prop("checked") == true){
                $('#{{ $input->getName() }}-box').show(200);
                $('#{{ $input->getName() }}-box').show(200);
              }
        });
      })

    </script>

  @endpush

@endif