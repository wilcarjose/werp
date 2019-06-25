@extends('admin.layout.auth')

@section('content')

    <div id="preloader">
      <div class="preloader-center">
        <div class="dots-loader dot-circle"></div>
      </div>
    </div>
    <!-- ============================-->
    <!-- CONTENT AREA-->
    <!-- ============================-->
    <div class="signin-wrapper auth-wrap transparent">
      <div class="signup-form card-dash grey-transparent">
        <div class="card-header primary-bg z-depth-2"><a class="animated app-logo" href="javascript:void(0)"><i class="material-icons app-icon left white-text">layers</i><span class="left" style="margin-left:25px;">{{ config('app.name') }}</span></a></div>
        <div class="row">
          <form class="col s12" role="form" method="POST" action="{{ url('/admin/login') }}">
            {{ csrf_field() }}

            <div class="row">

              <div class="input-field col s12"><i class="material-icons prefix">person</i>
                <input class="validate black-text lowercase-text" type="email" id="email" name="email" value="{{ old('email') }}" autofocus>
                <label for="email">Email</label>
                @if ($errors->has('email'))
                    <span class="help-block error-text">
                        {{ $errors->first('email') }}
                    </span>
                @endif
              </div>

              <div class="input-field col s12"><i class="material-icons prefix">vpn_key</i>
                <input class="validate black-text" type="password" id="password" name="password">
                <label for="password">Password</label>
                @if ($errors->has('password'))
                    <span class="help-block error-text">
                        {{ $errors->first('password') }}
                    </span>
                @endif
              </div>

              {{--  REMEMBER ME  --}}
              @if (false)
              <div class="input-field col s6 no-mrpd">
                <input class="cb-secondary" type="checkbox" id="remember_me">
                <label for="remember_me">Remember Me</label>
              </div>
              @endif

              {{--   FORGOT PASSWORD  --}}
              @if (false)
              <div class="input-field col s6 no-mrpd right-align">
                <label class="forgot-password" for="label-label">
                    <a class="grey-text" href="{{ url('/admin/password/reset') }}">forgot password?</a>
                </label>
              </div>
              @endif

              {{--  SUBMIT BUTTON  --}}
              <div class="input-field col s12 center">
                <button class="btn mm-btn waves-effect waves-light sigin-submit" type="submit" name="login" data-preloader="blue" data-text="Login" data-icon="send" data-redirection="home.html">Login<i class="material-icons right white-text">send</i></button>
              </div>

              @if (false)
                <div class="col s12 center nav-link"><a class="switchVisibility" href="javascript:void(0)" data-ref="signup-wrapper">Create account</a></div>
              @endif

            </div>
          </form>
        </div>
      </div>
    </div>

@endsection
