<?php

// Prices
	Route::put('/price_lists/status','\Werp\Modules\Core\Sales\Controllers\PriceListController@switchStatus')->name('price_list_status');
	Route::post('/price_lists/removeBulk','\Werp\Modules\Core\Sales\Controllers\PriceListController@destroyBulk');
	Route::put('/price_lists/statusBulk','\Werp\Modules\Core\Sales\Controllers\PriceListController@switchStatusBulk');
	Route::get('/price_lists/{id}/detail', '\Werp\Modules\Core\Sales\Controllers\PriceListController@indexDetail')->name('price_lists.detail.index');
	Route::resource('/price_lists','\Werp\Modules\Core\Sales\Controllers\PriceListController');
	Route::get('/price_lists/{id}/detail/{detail}', '\Werp\Modules\Core\Sales\Controllers\PriceListController@showDetail')->name('price_lists.detail.show');
	Route::put('/price_lists/{id}/detail/{detail}', '\Werp\Modules\Core\Sales\Controllers\PriceListController@updateDetail')->name('price_lists.detail.update');
	Route::post('/price_lists/{id}/detail', '\Werp\Modules\Core\Sales\Controllers\PriceListController@storeDetail')->name('price_lists.detail.update');
	Route::delete('/price_lists/{id}/detail/{detail}', '\Werp\Modules\Core\Sales\Controllers\PriceListController@destroyDetail')->name('price_lists.detail.update');
	Route::get('/price_lists/{id}/process', '\Werp\Modules\Core\Sales\Controllers\PriceListController@process')->name('price_lists.process');
	Route::get('/price_lists/{id}/reverse', '\Werp\Modules\Core\Sales\Controllers\PriceListController@reverse')->name('price_lists.reverse');

	// Price list type
	Route::put('/price_list_types/status','\Werp\Modules\Core\Sales\Controllers\PriceListTypeController@switchStatus')->name('price_list_types_status');
	Route::post('/price_list_types/removeBulk','\Werp\Modules\Core\Sales\Controllers\PriceListTypeController@destroyBulk');
	Route::put('/price_list_types/statusBulk','\Werp\Modules\Core\Sales\Controllers\PriceListTypeController@switchStatusBulk');
	Route::resource('/price_list_types','\Werp\Modules\Core\Sales\Controllers\PriceListTypeController');

	// Customers
	Route::put('/customers/status','\Werp\Modules\Core\Sales\Controllers\CustomerController@switchStatus')->name('supplier_status');
	Route::post('/customers/removeBulk','\Werp\Modules\Core\Sales\Controllers\CustomerController@destroyBulk');
	Route::put('/customers/statusBulk','\Werp\Modules\Core\Sales\Controllers\CustomerController@switchStatusBulk');
	Route::resource('/customers','\Werp\Modules\Core\Sales\Controllers\CustomerController');