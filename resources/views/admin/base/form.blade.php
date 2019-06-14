@extends('admin.layout.default')
@section('css')
    <link href="{{ asset('plugins/sweetalert/sweetalert.css') }}" rel="stylesheet" />
@endsection
@section('content')
    <div class="main-header">
        <div class="sec-page">
          <div class="page-title">
            <h2>{{ $page->getTitle() }}</h2>
          </div>
          <div class="page-options">
            <a class="waves-effect waves-set page-opt-dropBtn setWave btn-floating" href="#"><i class="material-icons">perm_data_setting</i></a>
            <a class="waves-effect waves-set page-opt-dropBtn setWave btn-floating" href="#"><i class="material-icons">chat_bubble_outline</i></a>
          </div>
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
                        <div class="col s12">
                            <h5>{{ $page->getAction() }}</h5>
                        </div>
                    </div>
                    <div class="row">

                        @foreach($page->getInputs() as $input)
                            @include('commons.form.inputs.'.$input->getType(), compact('input'))
                        @endforeach

                    </div>
                    <div class="row">
                        <div class="input-field col s12 right-align">
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
