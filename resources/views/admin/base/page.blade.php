@extends('admin.layout.default')

@section('title')
{{ $page->getTitle() }}
@endsection

@section('css')
    <link href="{{ asset('plugins/sweetalert/sweetalert.css') }}" rel="stylesheet" />
    <link href="{{ asset('plugins/select2/select2.css') }}" rel="stylesheet" />
  {{-- <link href="{{ asset('plugins/easyui/easyui.css') }}" rel="stylesheet"> --}}  
    <link href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet"/>
    <link href="{{ asset('plugins/pickers/spectrum/spectrum.css') }}" rel="stylesheet"/>

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

      .select2-container {
          width: 100% !important;
      }

      .select2-container--default .select2-selection--single {
          background-color: #fff;
          border: 0px solid #aaa;
          border-radius: 0px;
          border-bottom: 1px solid #757575;
          height: 39px;
      }

      .select2-container--default.select2-container--disabled .select2-selection--single {
          background-color: #fbfbfb !important;
      }

      .datetime-box {
        margin: 0 !important;
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

            <div class="col {{ $page->width() }}">

                @include('admin.base.partials.messages')

                @include('admin.base.partials.tabs')

                @include('admin.base.partials.forms')

                @include('admin.base.partials.rows')

            </div>

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

        $(".color-box").spectrum({
          showPaletteOnly: true,
          togglePaletteOnly: true,
          togglePaletteMoreText: 'more',
          togglePaletteLessText: 'less',
          color: 'blanchedalmond',
          palette: [
            ["#000","#444","#666","#999","#ccc","#eee","#f3f3f3","#fff"],
            ["#f00","#f90","#ff0","#0f0","#0ff","#00f","#90f","#f0f"],
            ["#f4cccc","#fce5cd","#fff2cc","#d9ead3","#d0e0e3","#cfe2f3","#d9d2e9","#ead1dc"],
            ["#ea9999","#f9cb9c","#ffe599","#b6d7a8","#a2c4c9","#9fc5e8","#b4a7d6","#d5a6bd"],
            ["#e06666","#f6b26b","#ffd966","#93c47d","#76a5af","#6fa8dc","#8e7cc3","#c27ba0"],
            ["#c00","#e69138","#f1c232","#6aa84f","#45818e","#3d85c6","#674ea7","#a64d79"],
            ["#900","#b45f06","#bf9000","#38761d","#134f5c","#0b5394","#351c75","#741b47"],
            ["#600","#783f04","#7f6000","#274e13","#0c343d","#073763","#20124d","#4c1130"]
          ]
        });


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
  <script type="text/javascript" src={{ asset('plugins/pickers/spectrum/spectrum.js') }}></script>

@endsection