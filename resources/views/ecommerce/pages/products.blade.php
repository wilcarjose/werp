@extends('ecommerce.layouts.default')

@section('title')
    E-commerce
@endsection

@section('css')

	
    {{-- <link href="#" rel="stylesheet" /> --}}

    <style>
        
        .setting-icon {
		    float: left;
		    color: #2196f3;
		    margin-right: 10px;
		}

		.product-amount {
			 background: #4caf50 !important;
		    border-radius: 3px;
		    color: #FFF;
		    padding: 5px 8px;
		    font-size: 18px;
		    font-weight: 700;
		}

		.br-2 {
			border-radius: 2px;
		}

		.br-6 {
			border-radius: 6px;
		}

		.br-10 {
			border-radius: 10px;
		}

		.collection {
		    border: 0px;
		}

		.collection .collection-item {
		    border-bottom: 0px;
		}

    </style>

@endsection

@section('content')

	{{--
	<e-products></e-products>
	--}}

	@include('ecommerce.partials.examples.products')

@endsection


@section('jsPostApp')

	<script type="text/javascript">

		$('.carousel.carousel-slider').carousel(
			{
				fullWidth: false
			}
		);
	</script>

@endsection
