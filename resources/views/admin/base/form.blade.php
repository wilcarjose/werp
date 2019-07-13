@extends('admin.layout.default')

@section('title')
{{ $page->getTitle() }}
@endsection

@section('css')
    <link href="{{ asset('plugins/sweetalert/sweetalert.css') }}" rel="stylesheet" />
    <link href="{{ asset('plugins/select2/select2.css') }}" rel="stylesheet" />
    <link href="{{ asset('plugins/easyui/easyui.css') }}" rel="stylesheet">
    <style type="text/css">

      .textbox {
          width: 669px;
          border: 0;
          border-radius: 0;
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
          margin-left: 3rem !important;
          /*width: 92%;*/
          width: calc(100% - 3rem) !important;
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
                        <div class="col s10">
                            <h5>{{ $page->getAction() }}</h5>
                        </div>
                        <div class="col s2">
                            @if ($page->getState())
                              <h5 style="background: {{ $page->getStateColor() }}; text-align: center; border-radius: 9px; padding: 3px 0px; font-weight: 300;">{{ $page->getState() }}</h5>
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
                    @if (count($page->getActions()) > 0)
                    <div class="row">
                        <div class="input-field col s12 right-align">
                            @foreach($page->getActions() as $action)
                                @include('commons.form.actions.'.$action->getType(), compact('action'))
                            @endforeach
                        </div>
                    </div>
                    @endif 
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

    $( document ).ready(function() {
        
    });

    $(window).on("load", function(){
      $(".textbox .textbox-text").focus(function() {
          
            $(this).parent().next().addClass('active');
            $(this).parent().next().css("color", "#e91e63")          
      });

      $(".textbox .textbox-text").blur(function() {
          if ( $(this).val() == '' ) {
            $(this).parent().next().removeClass('active');            
          }
          $(this).parent().next().css("color", "#757575")
      });

      $('input[type="text"].textbox-text').each(function () {
          console.log($(this).val());
          if ($(this).val() != '') {
            $(this).parent().next().addClass('active');
          }
      });

    })
    
  </script>

  <script type="text/javascript" src={{ asset('plugins/easyui/jquery.easyui.min.js') }}></script>

@endsection