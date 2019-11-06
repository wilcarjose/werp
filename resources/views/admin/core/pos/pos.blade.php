@extends('admin.layout.default')

@section('title')
    Punto de venta
@endsection

@section('css')

    <link href="{{ asset('plugins/select2/select2.css') }}" rel="stylesheet" />

    <style>
        .invoice-lines {
            padding: 8px 5px;
            font-size: 12px;
            font-weight: 500;
        }

        .btn-invoice-line {
            height: 24px;
            line-height: 24px;
            padding: 0 5px;
        }

        .invoice-lines tfoot tr th {
            padding: 0px;
            font-weight: 600;
            font-size: 14px;
        }

        .btn-invoice-line i {
            font-size: 12px;
            line-height: inherit;
            font-weight: 700;
        }

        .invoice-lines tbody tr td {
            padding: 5px 5px;
        }

    </style>

@endsection

@stack('extra-css')

@section('content')

    {{-- 
    <div class="main-header">
        <div class="sec-page">
          <div class="page-title">
            <h2>Punto de Venta</h2>
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
                  <a class="breadcrumb" href="{{ route('admin.home') }}">Inicio</a>
                  <a class="breadcrumb" href="{{ route('admin.pos.pos.view')  }}">Punto de venta</a>
              </div>
            </div>
          </nav>
        </div>
    </div>

     --}}

    <div class="main-container">
        <pos headline='Pos'></pos>
    </div>


@endsection


@section('jsPostApp')

  @stack('extra-js')

@endsection
