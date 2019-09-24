@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url'),"class"=>"header-top-bordered"])
            <div class="header-center">
                <span class="no-float">Notificación de stock</span>
            </div>
        @endcomponent
    @endslot

    {{-- Body --}}
    <div>
        <p class="mail-body-text">
            Notificación de stock  
        </p>

        <p class="mail-body-text">
            La cantidad del producto: <strong>{{ $product }} </strong> @if ($warehouse) en el almacén: <strong>{{ $warehouse }}</strong> @endif {{ $min ? 'es menor o igual al mínimo configurado' : 'es mayor o igual al máximo configurado' }}.
        </p>
        <p>
            Existencia: <strong>{{ $qty }}</strong>
        </p>
        <p>
            {{ $min ? 'Mínimo: ' : 'Máximo: ' }} <strong>{{ $max_min_qty }}</strong>
        </p>
    </div>
    {{-- Subcopy --}}

        @slot('subcopy')
            @component('mail::subcopy')
                <p>
                    Administrador
                </p>
            @endcomponent
        @endslot


    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
           &copy; {{ date('Y') }}. All rights reserved.
        @endcomponent
    @endslot
@endcomponent
