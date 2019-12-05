<template>
	
	<div class="row">
	    <div class="col m10 push-m1 s12" style="margin-top: 3rem!important;">
	      <div class="card-panel z-depth-2 br-6">
	        <h4 class="card-title">
	        </h4>
	        <div class="card-contents">
	        	<div class="row">
	        		<div class="col m6 s12">
	        			<!-- <img src="/images/products/xiaomi-mi-9-lite.jpg"> -->
	        			<div data-indicators="true" class="carousel carousel-slider" >
							<a class="carousel-item" :href="'#' + image.order + '!'" v-for="image in product.images">
								<img :src="image.url">
							</a>
						</div>

	        		</div>
	        		<div class="col m6 s12">
	        			<div class="row no-mp">
						    <div class="col s12 hoverable br-6" style="padding: 30px;">
						    
						     	<h3 class="no-mp black-text">{{ product.name }}</h3>
						     	
						     	<blockquote>
						     		<span class="caption clamp-line-2 black-text" v-bind:class="{ truncate: short_description }">{{ product.description }}</span>
						     		<button class="btn" v-on:click="short_description = short_description ? false : true">Ver más</button>
						     	</blockquote>
						    
						    </div>
						    <div class="col s12 hoverable br-6" style="padding: 30px; margin-top: 1rem!important;">
						     	<h5 class="no-mp black-text">Características principales</h5>
						     	<blockquote>
							     	<i class="fa-li fa fa-mobile fa-lg"></i>
							     	<ul class="collection">

							     		<li v-for="feature in product.main_features" class="collection-item dismissable">
							     			<div><i class="setting-icon material-icons">{{ feature.icon }}</i>{{ feature.name }}: {{ feature.value }}</div>
							     		</li>

									</ul>
								</blockquote>								
						     
						    </div>
						    
						 </div>
	        		</div>
	        	</div>
	        </div>
	      </div>
	    </div>

	    <div class="col m10 push-m1 s12" style="margin-top: 3rem!important;">
	        <div class="card-panel z-depth-2 br-6">
	            <h5 class="card-title">
	            	Disponible en las siguientes tiendas:
	            </h5>
	            <div class="card-contents">
		        	<div class="row">
		        		<div class="col s12">
		        			<table>
								<tbody>
									<tr v-for="store in product.stores" class="hoverable br-10">
										<td style="padding: 20px;"><img style="height: 90px;" :src="store.logo" alt="" class="circle responsive-img"></td>
										<td><h5>{{ store.name }}</h5></td>
										<td style="font-size: 18px;">{{ store.state }}</td>
										<td>{{ store.address }}</td>
										<td v-if="show_prices"><span class="product-amount">${{ store.price }}</span></td>
									</tr>
								</tbody>
							</table>
		        		</div>
		        	</div>
	        	</div>
	    	</div>
	    </div>
	</div>

</template>

<script>
    export default {

        props: ['type'],

        data() {

            return {
                
                show_prices:true,

                short_description: true,

                product: {

                	id: 1,
                	name: 'Xiaomi Mi 9 Lite',
                	slug: 'xiaomi-mi-9-lite',
                	description: 'El Xiaomi Mi 9 Lite es una variante del flagship de Xiaomi, con una pantalla Super AMOLED FHD+ de 6.39 pulgadas y potenciado por un procesador Snapdragon 710 de ocho núcleos, acompañado de 6GB de memoria RAM y 64GB o 128GB de almacenamiento interno. La cámara posterior del Xiaomi Mi 9 Lite es triple, con sensores de 48 MP + 8 MP + 2 MP, mientras que su cámara selfie es de 32 MP, integrada mediante un notch en el borde superior de la pantalla. Completando las características del Xiaomi Mi 9 Lite encontramos un lector de huellas integrado en la pantalla, una batería de 4030 mAh con carga rápida, y corre MIUI 10 basado en Android 9 Pie.',
                	images: [
                		{
                			order: 1,
                			title: '',
                			url: '/images/products/xiaomi-mi-9-lite.jpg'
                		},
                		{
                			order: 2,
                			title: '',
                			url: '/images/products/xiaomi-mi-9-lite2.jpg'
                		},
                		{
                			order: 3,
                			title: '',
                			url: '/images/products/xiaomi-mi-9-lite3.jpg'
                		},
                		{
                			order: 4,
                			title: '',
                			url: '/images/products/xiaomi-mi-9-lite4.jpg'
                		}
                	],

                	main_features: [
                		{
                			icon: 'stay_current_portrait',
                			name: 'Pantalla',
                			value: '6.39", 1080 x 2340 pixels'
                		},
                		{
                			icon: 'show_chart',
                			name: 'Procesador',
                			value: 'Snapdragon 710 2.2GHz'
                		},
                		{
                			icon: 'settings',
                			name: 'RAM',
                			value: '6GB'
                		},
                		{
                			icon: 'storage',
                			name: 'Almacenamiento',
                			value: '64GB/128GB'
                		},
                		{
                			icon: 'sd_storage',
                			name: 'Expansión',
                			value: 'microSD'
                		},
                		{
                			icon: 'camera_alt',
                			name: 'Cámara',
                			value: 'Triple, 48MP+8MP+2MP'
                		},
                		{
                			icon: 'battery_charging_full',
                			name: 'Batería',
                			value: '4030 mAh'
                		},
                		{
                			icon: 'android',
                			name: 'OS',
                			value: 'Android 9.0'
                		},
                		{
                			icon: 'aspect_ratio',
                			name: 'Perfil',
                			value: '8.7 mm'
                		},
                		{
                			icon: 'clear_all',
                			name: 'Peso',
                			value: '179 g'
                		},
                		{
                			icon: 'attach_money',
                			name: 'Precio',
                			value: '319$'
                		}
                		
                	],

                	stores: [
	                	{
	                		id: 1,
	                		branch_id: 1,
	                		logo: '/images/parties/logos/daka.png',
	                		name: 'Tiendas Daka',
	                		state: 'Lara',
	                		address: 'Avenida Venezuela, Barquisimeto 3001, Lara',
	                		available: true,
	                		price: 310.00
	                	},
	                	{
	                		id: 2,
	                		branch_id: 2,
	                		logo: '/images/parties/logos/ivoo.png',
	                		name: 'Ivoo',
	                		state: 'Miranda',
	                		address: 'Tienda de electrodomésticos en Naguanagua, Venezuela',
	                		available: true,
	                		price: 320.00
	                	},
	                	{
	                		id: 3,
	                		branch_id: 3,
	                		logo: '/images/parties/logos/townrecord.jpg',
	                		name: 'Town Record',
	                		state: 'Lara',
	                		address: 'Centro Comercial Arca, Barquisimeto, Lara',
	                		available: true,
	                		price: 305.00
	                	}
	                ]
                },
            };
        },

        computed:{
        }

    }
</script>