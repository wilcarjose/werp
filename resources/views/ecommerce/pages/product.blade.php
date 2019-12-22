@extends('ecommerce.layouts.default')

@section('title')
    E-commerce
@endsection

@section('css')

	
    {{-- <link href="#" rel="stylesheet" /> --}}

    <style>
        
        .carousel .indicators .indicator-item {
            background-color: lightgray;
        }

        .carousel .indicators .indicator-item.active {
            background-color: darkgrey;
        }

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

		.carousel {
		  overflow: hidden;
		  position: relative;
		  width: 100%;
		  height: 400px;
		  -webkit-perspective: 500px;
		          perspective: 500px;
		  -webkit-transform-style: preserve-3d;
		          transform-style: preserve-3d;
		  -webkit-transform-origin: 0% 50%;
		          transform-origin: 0% 50%;
		}

		.carousel.carousel-slider {
		  top: 0;
		  left: 0;
		  height: 500px;
		}

		.carousel.carousel-slider .carousel-fixed-item {
		  position: absolute;
		  left: 0;
		  right: 0;
		  bottom: 20px;
		  z-index: 1;
		}

		.carousel.carousel-slider .carousel-fixed-item.with-indicators {
		  bottom: 68px;
		}

		.carousel.carousel-slider .carousel-item {
		  width: 100%;
		  height: 100%;
		  min-height: 400px;
		  position: absolute;
		  top: 0;
		  left: 0;
		}

		.carousel.carousel-slider .carousel-item h2 {
		  font-size: 24px;
		  font-weight: 500;
		  line-height: 32px;
		}

		.carousel.carousel-slider .carousel-item p {
		  font-size: 15px;
		}

		.carousel .carousel-item {
		  display: none;
		  width: 200px;
		  height: 200px;
		  position: absolute;
		  top: 0;
		  left: 0;
		}

		.carousel .carousel-item > img {
		  width: 100%;
		}

		.carousel .indicators {
		  position: absolute;
		  text-align: center;
		  left: 0;
		  right: 0;
		  bottom: 0;
		  margin: 0;
		}

		.carousel .indicators .indicator-item {
		  display: inline-block;
		  position: relative;
		  cursor: pointer;
		  height: 8px;
		  width: 8px;
		  margin: 24px 4px;
		  background-color: rgba(255, 255, 255, 0.5);
		  -webkit-transition: background-color .3s;
		  transition: background-color .3s;
		  border-radius: 50%;
		}

		.carousel .indicators .indicator-item.active {
		  background-color: #fff;
		}

		.carousel.scrolling .carousel-item .materialboxed,
		.carousel .carousel-item:not(.active) .materialboxed {
		  pointer-events: none;
		}


    </style>

@endsection

@section('content')

	<e-product></e-product>

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
