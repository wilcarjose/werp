@extends('admin.layout.default')

@section('title')
{{ $page->getTitle() }}
@endsection

@section('css')
    <link href="{{ asset('plugins/sweetalert/sweetalert.css') }}" rel="stylesheet" />
    <link href="{{ asset('plugins/select2/select2.css') }}" rel="stylesheet" />
  {{-- <link href="{{ asset('plugins/easyui/easyui.css') }}" rel="stylesheet"> --}}  
    <link href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet"/>

    <style type="text/css">

      .daterangepicker .calendar-table th, .daterangepicker .calendar-table td {
          white-space: nowrap;
          text-align: center;
          vertical-align: middle;
          min-width: 32px;
          width: 32px;
          height: 24px;
          line-height: 0px;
          font-size: 12px;
          border-radius: 4px;
          border: 1px solid transparent;
          white-space: nowrap;
          cursor: pointer;
      }

      .monthselect, .yearselect, .hourselect, .minuteselect, .ampmselect {
          display: inline-block !important;
          background-color: rgba(255, 255, 255, 0.9) !important;
          width: 100%;
          padding: 5px;
          border: 1px solid #f2f2f2 !important;
          border-radius: 2px !important;
          height: 24px !important;
      }

      .daterangepicker .drp-buttons .btn {
          margin-left: 8px;
          font-size: 12px;
          font-weight: bold;
          padding: 0px 8px;
      }

      .select2-container--default .select2-selection--single {
          background-color: #fff;
          border: 0px solid #aaa;
          border-radius: 0px;
          border-bottom: 1px solid #757575;
      }

      .select2-container--default.select2-container--disabled .select2-selection--single {
          background-color: #fbfbfb !important;
      }

    </style>
@endsection

@section('content')
    <div class="main-header">
        <div class="sec-page">
          <div class="page-title">
            <h2>{{ $page->getTitle() }}</h2>
          </div>

          @if(config('werp.show_elements'))
          <div class="page-options">
            <a class="waves-effect waves-set page-opt-dropBtn setWave btn-floating" href="#"><i class="material-icons">perm_data_setting</i></a>
            <a class="waves-effect waves-set page-opt-dropBtn setWave btn-floating" href="#"><i class="material-icons">chat_bubble_outline</i></a>
          </div>
          @endif

        </div>
        <!-- ============================-->
        <!-- breadcrumb-->
        <!-- ============================-->
        <div class="sec-breadcrumb">
          <nav class="breadcrumbs-nav left">
            <div class="nav-wrapper">
              <div class="col s12">
                  @foreach($page->getBreadcrumbs() as $breadcrumb)
                      @include('commons.elements.breadcrumb', compact('breadcrumb'))
                  @endforeach
              </div>
            </div>
          </nav>
        </div>
    </div>
    <div class="main-container">
        <div class="row" style="margin-top:10px !important;">

            @if ($page->hasTabs())
                <div class="col m8 push-m2  " style="margin-bottom: 15px;">
                    <ul class="tabs tab-demo z-depth-1">
                        @foreach ($page->getTabs() as $tab) 
                          <li class="tab col s3 @if ($tab->isDisable()) disabled @endif">
                            <a @if ($tab->isActive()) class="active" @endif href="#{{ $tab->getId() }}" style="text-align: left; color: {{ $tab->getColor() }}">
                              <i class="material-icons {{ $tab->getIconPosition() }}" style="line-height: 48px;">
                                {{ $tab->getIcon() }}
                              </i>
                              {{ $tab->getName() }}
                            </a>
                          </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{--  Flash Message  --}}
            <div class="col m12">
                @include('flash')
            </div>

            @foreach ($page->getForms() as $form)

                <form class="col @if ($form->maxWidth()) m12 @endif @if ($form->midWidth()) m8 push-m2 @endif @if ($form->middleWidth()) m6 @endif  s12 profile-info-form" role="form" method="POST" action="{{ $form->getSaveRoute() }}" enctype="multipart/form-data" id="{{ $form->getId() }}">
                    {{ csrf_field() }}
                    @if ($form->edit()) {{ method_field('PUT') }} @endif
                    <div class="card-panel profile-form-cardpanel">
                        <div class="row box-title">
                            <div class="col s9">
                                <h5>{{ $form->getAction() }}</h5>
                            </div>
                            <div class="col s3">
                                @if ($form->getState())
                                  <h5 style="background: {{ $form->getStateColor() }}; text-align: center; border-radius: 9px; padding: 3px 0px; font-weight: 300;">{{ $form->getState() }}</h5>
                                @endif
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
                                <a type="link" href="#" onclick="showAdvancedOption(); return false;" style="margin-left: 45px;">
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
            @endforeach
        </div>
    </div>

@endsection


@section('jsPostApp')

  <script>

    function formatState (state) {
      if (state.id != 'new') { return state.text; }
      var $state = $(
        '<span><img src="/images/icons/new.png" class="img-flag" /> ' + state.text + ' </span>'
     );
     return $state;
    };
    
    function confirmAction(route) {
      var result = confirm("¿Está seguro?");
      if (result == true) {
        window.location=route;
      }
    };

    var showAdvanced = false;
    function showAdvancedOption() {
      if (showAdvanced) {
        showAdvanced = false;
        $('.advanced-option').hide(500);
      } else {
        showAdvanced = true;
        $('.advanced-option').show(500);
      }
    }

    $(document).ready(function() {

        $('.datetime-box').daterangepicker({
          timePicker: true,
          singleDatePicker: true,
          showDropdowns: true,
          minYear: 1901,
          autoApply: false,
          autoUpdateInput: true,
          maxYear: parseInt(moment().format('YYYY'),10),
          locale: {
            format: 'DD/MM/YYYY hh:mm A',
            cancelLabel: 'Cancelar',
            applyLabel: 'Ok'
          }
        }, function(start, end, label) {
          //var years = moment().diff(start, 'years');
          //alert("You are " + years + " years old!");
        });

        $('ul.tabs').tabs();

        

    });

    $(window).on("load", function(){

    if ($(".number-input").length > 0) {
      new AutoNumeric('.number-input', {
        digitGroupSeparator        : '.',
        decimalCharacter           : ',',
        unformatOnSubmit           : true
      });
    }    

      $('.tooltipped').tooltip({delay: 50});

    })

  </script>

  @stack('selects')

  @yield('js-datebox')

  <script type="text/javascript" src={{ asset('plugins/autonumeric/autonumeric.min.js') }}></script>
  <script type="text/javascript" src={{ asset('plugins/momentjs/moment.min.js') }}></script>
  <script type="text/javascript" src={{ asset('plugins/daterangepicker/daterangepicker.min.js') }}></script>

@endsection