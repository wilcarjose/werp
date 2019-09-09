<form class="{{ $form->ignoreWidth() ? '' : 'col '. $form->width() }} profile-info-form" role="form" method="POST" action="{{ $form->getSaveRoute() }}" enctype="multipart/form-data" id="{{ $form->getId() }}">

    {{ csrf_field() }}

    @if ($form->edit()) {{ method_field('PUT') }} @endif

    
    
    <div class="card-panel profile-form-cardpanel">

        @if ($form->getState())
        <div class="row">
            <div class="col s12 m6 l8">
            </div>
            <div class="col s12 m6 l4 right" style="margin: -35px 15px 0px;">

                    <span class="z-depth-2 caption right" style="background: {{ $form->getStateColor() }}; padding: 5px 40px; border-radius: 3px; color: white; font-weight: 300; text-transform: uppercase;">{{ $form->getState() }} </span>

            </div>
        </div>
        @endif

        <div class="row box-title">
            <div class="col s9">
                <span style="
                    display: block;
                    line-height: 32px;
                    margin-bottom: 8px;
                    font-size: 24px;
                    font-weight: 300;">
                        {{ $form->getAction() }}
                </span>
            </div>
            <div class="col s3 right-align">
                <a class="dropdown-button page-opt-dropBtn btn-floating btn-flat waves-effect waves-set setWave" href="javascript:void(0)" data-activates="supportTicket" data-beloworigin="true" data-alignment="right" data-position="bottom" data-constrainwidth="false" data-delay="50" data-gutter="25"><i class="material-icons grey-text text-darken-2">menu</i></a>
            </div>
            
        </div>

        <div class="row">
            <div class="col s12">
                <div class="divider" style="margin-bottom: 15px; height: 2px;"></div>
            </div>
        </div>

        <div class="row">
            <div class="col s10">
              
            </div>
            <div class="col s2">
                @if (false && $form->hasPrintAction())
                    @include('commons.form.actions.'.$form->getPrintAction()->getType(), ['action' => $form->getPrintAction()])

                    <div class="fixed-action-btn horizontal click-to-toggle" style="bottom: 45px; right: 24px;">
                      <a class="btn-floating btn-large red">
                        <i class="material-icons">menu</i>
                      </a>
                      <ul>
                        <li><a class="btn-floating red"><i class="material-icons">insert_chart</i></a></li>
                        <li><a class="btn-floating yellow darken-1"><i class="material-icons">format_quote</i></a></li>
                        <li><a class="btn-floating green"><i class="material-icons">publish</i></a></li>
                        <li><a class="btn-floating blue"><i class="material-icons">attach_file</i></a></li>
                        @if ($form->hasPrintAction())
                            <li><a class="btn tooltipped btn-floating grey" data-position="top" data-delay="50" data-tooltip="Imprimir" href="{{ $form->getPrintAction()->getRoute() }}"><i class="material-icons">print</i></a></li>
                        @endif
                      </ul>
                    </div>

                @endif
            </div>
        </div>

        <div class="row">

            @foreach($form->getInputs() as $input)
                @include('commons.form.inputs.'.$input->getType(), compact('input'))
            @endforeach

            @if ($form->advancedOption())
              <div class="col s12">
                <a type="link" href="#" onclick="showAdvancedOption(); return false;">
                    {{ trans('view.advanced_options') }}
                </a>
              </div>
            @endif

            @if (false)
              @if ($form->hasFilter())
                  @include($form->getFilter(), ['input' => ''])
              @endif

              @foreach($form->getFilters() as $input)
                  @include('commons.form.inputs.'.$input->getType(), compact('input'))
              @endforeach
            @endif

            @if ($form->hasList())
                @include('commons.form.inputs.list', ['input' => $form->getList()])
            @endif

        </div>
        
        <div class="row">
            <div class="input-field col s12 right-align">
                @if (true && $form->hasPrintAction())
                    @include('commons.form.actions.'.$form->getPrintAction()->getType(), ['action' => $form->getPrintAction()])
                @endif

                @foreach($form->getActions() as $action)
                    @include('commons.form.actions.'.$action->getType(), compact('action'))
                @endforeach
            </div>
        </div>
        
    </div>

</form>