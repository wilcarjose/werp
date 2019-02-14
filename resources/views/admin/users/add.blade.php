@extends('admin.layout.default')

@section('content')
    <div class="main-header">
        <div class="sec-page">
          <div class="page-title">
            <h2>User</h2>
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
                <a class="breadcrumb" href="{{ url('admin/') }}">Home</a>
                <a class="breadcrumb" href="{{ url('admin/user') }}">Users</a>
                <a class="breadcrumb" href="#">Add</a>
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
            <form class="col m8 push-m2 s12 profile-info-form" role="form" method="POST" action="{{ url('/admin/user') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card-panel profile-form-cardpanel">
                    <div class="row box-title">
                        <div class="col s12">
                            <h5>Add User</h5>
                        </div>
                    </div>
                    <div class="row">

                        @foreach($form['inputs'] as $item)
                            @include('commons.form.'.$item['type'], $item['attr'])
                        @endforeach

                    </div>
                    <div class="row">
                        <div class="input-field col s12 right-align">
                            <button class="btn waves-effect waves-set" type="submit" name="update_profile"> User
                                <i class="material-icons left">add</i>
                            </button>
                            <a type="button" href="{{ url('/admin/user') }}" class="btn waves-effect waves-set info-bg">
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
