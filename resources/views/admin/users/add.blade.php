@extends('admin.layout.default')

@section('content')
    <div class="main-header">
        <div class="sec-page">
          <div class="page-title">
            <h2>{{ $form['title'] }}</h2>
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
                  @foreach($form['breadcrumb'] as $breadcrumb)
                      @include('commons.elements.breadcrumb', $breadcrumb)
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
            <form class="col m8 push-m2 s12 profile-info-form" role="form" method="POST" action="{{ $form['edit'] ? route($form['route'].'.update', $form['data']['id']) : route($form['route'].'.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                @if ($form['edit']) {{ method_field('PUT') }} @endif
                <div class="card-panel profile-form-cardpanel">
                    <div class="row box-title">
                        <div class="col s12">
                            <h5>{{ $form['action'] }}</h5>
                        </div>
                    </div>
                    <div class="row">

                        @foreach($form['inputs'] as $item)
                            @include('commons.form.inputs.'.$item['type'], $item['attr'])
                        @endforeach

                    </div>
                    <div class="row">
                        <div class="input-field col s12 right-align">
                            @foreach($form['actions'] as $action)
                                @include('commons.form.actions.'.$action['type'], $action['attr'])
                            @endforeach
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
