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
        <users headline='User' v-bind:config="{{$page->getConfig()}}"></users>
    </div>
@endsection


