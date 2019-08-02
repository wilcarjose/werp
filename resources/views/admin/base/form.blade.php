@extends('admin.layout.default')

@section('title')
{{ $page->getTitle() }}
@endsection

@section('css')
    <link href="{{ asset('plugins/sweetalert/sweetalert.css') }}" rel="stylesheet" />
    <link href="{{ asset('plugins/select2/select2.css') }}" rel="stylesheet" />
    <link href="{{ asset('plugins/easyui/easyui.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <style type="text/css">

      .textbox {
          width: 669px;
          border: 0;
          border-radius: 0;
          margin-left: 3rem,
      }

      .textbox .textbox-text {
          font-size: 16px;
          border: 0;
          margin: 0;
          padding: 0 4px;
          white-space: normal;
          vertical-align: top;
          outline-style: none;
          resize: none;
          -moz-border-radius: 0 !important;
          -webkit-border-radius: 0 !important;
          border-radius: 0 !important;
          height: 28px;
          line-height: 28px;
          border-bottom: 1px solid #757575;
          margin-left: 3rem;
          /*width: 92%;*/
          width: calc(100% - 3rem);
      }

      .textbox:focus {
          outline: -webkit-focus-ring-color auto 1px;
      }

      .textbox-focused {
        border-color: #fff;
        box-shadow: 0 0 0 0 #fff;
        -webkit-box-shadow: 0 0 0 0 #fff;
        -moz-box-shadow: 0 0 0 0 #fff;
      }

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
            {{--  Flash Message  --}}
            <div class="col s12">
                @include('flash')
            </div>

            {{--  PROFILE UPDATE  --}}
            <form class="col @if ($page->maxWidth()) m12 @endif @if ($page->midWidth()) m8 push-m2 @endif s12 profile-info-form" role="form" method="POST" action="{{ $page->getSaveRoute() }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                @if ($page->edit()) {{ method_field('PUT') }} @endif
                <div class="card-panel profile-form-cardpanel">
                    <div class="row box-title">
                        <div class="col s9">
                            <h5>{{ $page->getAction() }}</h5>
                        </div>
                        <div class="col s3">
                            @if ($page->getState())
                              <h5 style="background: {{ $page->getStateColor() }}; text-align: center; border-radius: 9px; padding: 3px 0px; font-weight: 300;">{{ $page->getState() }}</h5>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s10">
                          
                        </div>
                        <div class="col s2">
                            @if (false && $page->hasPrintAction())
                                @include('commons.form.actions.'.$page->getPrintAction()->getType(), ['action' => $page->getPrintAction()])

                                <div class="fixed-action-btn horizontal click-to-toggle" style="bottom: 45px; right: 24px;">
                                  <a class="btn-floating btn-large red">
                                    <i class="material-icons">menu</i>
                                  </a>
                                  <ul>
                                    <li><a class="btn-floating red"><i class="material-icons">insert_chart</i></a></li>
                                    <li><a class="btn-floating yellow darken-1"><i class="material-icons">format_quote</i></a></li>
                                    <li><a class="btn-floating green"><i class="material-icons">publish</i></a></li>
                                    <li><a class="btn-floating blue"><i class="material-icons">attach_file</i></a></li>
                                    @if ($page->hasPrintAction())
                                        <li><a class="btn tooltipped btn-floating grey" data-position="top" data-delay="50" data-tooltip="Imprimir" href="{{ $page->getPrintAction()->getRoute() }}"><i class="material-icons">print</i></a></li>
                                    @endif
                                  </ul>
                                </div>

                            @endif
                        </div>
                    </div>

                    <div class="row">

                        @foreach($page->getInputs() as $input)
                            @include('commons.form.inputs.'.$input->getType(), compact('input'))
                        @endforeach

                        @if ($page->advancedOption())
                          <div class="col s12">
                            <a type="link" href="#" onclick="showAdvancedOption(); return false;" style="margin-left: 45px;">
                                {{ trans('view.advanced_options') }}
                            </a>
                          </div>
                        @endif

                        @if ($page->hasList())
                            @include('commons.form.inputs.list', ['input' => $page->getList()])
                        @endif
                    </div>
                    
                    <div class="row">
                        <div class="input-field col s12 right-align">
                            @if (true && $page->hasPrintAction())
                                @include('commons.form.actions.'.$page->getPrintAction()->getType(), ['action' => $page->getPrintAction()])
                            @endif

                            @foreach($page->getActions() as $action)
                                @include('commons.form.actions.'.$action->getType(), compact('action'))
                            @endforeach
                        </div>
                    </div>
                    
                </div>
            </form>
        </div>
    </div>

@endsection


@section('jsPostApp')

  <script>
    
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

    $('select.select2_select').select2();
    $('select.select2-placeholder').select2({
      placeholder: "Select a state",
      allowClear: true
    });

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

        
    });

    $(window).on("load", function(){

      $('.tooltipped').tooltip({delay: 50});

      $(".textbox .textbox-text").focus(function() {
          $(this).parent().next().addClass('active');
          $(this).parent().next().css("color", "#e91e63");          
      });

      $(".textbox .textbox-text").blur(function() {

          if ( $(this).val() == '' ) {
            $(this).parent().next().removeClass('active');            
          }

          $(this).parent().next().css("color", "#757575");
      });

      $('input[type="text"].textbox-text').each(function () {

          if ($(this).val() != '') {
            $(this).parent().next().addClass('active');
          }

          if ($(this).parent().prev().hasClass('custom-numberbox')) {
            var id = $(this).attr("id");
            $('#'+id).css({
              "background-color": "#fafafa",
              "margin-left": "0px",
              "width": "100%"
            });
          }

          if ($(this).parent().prev().hasClass('easyui-numberbox')) {
            var id = $(this).attr("id");
            $('#'+id).css({
              "margin-left": "3rem",
              "width": "calc(100% - 3rem)"
            });
            /*
            $(this).parent().css({
              "width": "calc(100% - 3rem)",
              "margin-left": "3rem"
            })
            */
          }

      });

    })

  </script>

  @yield('js-datebox')

  <script type="text/javascript" src={{ asset('plugins/easyui/jquery.easyui.min.js') }}></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>


@endsection