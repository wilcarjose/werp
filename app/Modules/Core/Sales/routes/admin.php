<?php

// Prices
	Route::put('/price_lists/status','PriceListController@switchStatus')->name('price_list_status');
	Route::post('/price_lists/removeBulk','PriceListController@destroyBulk');
	Route::put('/price_lists/statusBulk','PriceListController@switchStatusBulk');
	Route::get('/price_lists/{id}/detail', 'PriceListController@indexDetail')->name('price_lists.detail.index');
	Route::resource('/price_lists','PriceListController');
	Route::get('/price_lists/{id}/detail/{detail}', 'PriceListController@showDetail')->name('price_lists.detail.show');
	Route::put('/price_lists/{id}/detail/{detail}', 'PriceListController@updateDetail')->name('price_lists.detail.update');
	Route::post('/price_lists/{id}/detail', 'PriceListController@storeDetail')->name('price_lists.detail.update');
	Route::delete('/price_lists/{id}/detail/{detail}', 'PriceListController@destroyDetail')->name('price_lists.detail.update');
	Route::get('/price_lists/{id}/process', 'PriceListController@process')->name('price_lists.process');
	Route::get('/price_lists/{id}/reverse', 'PriceListController@reverse')->name('price_lists.reverse');

	// Price list type
	Route::put('/price_list_types/status','PriceListTypeController@switchStatus')->name('price_list_types_status');
	Route::post('/price_list_types/removeBulk','PriceListTypeController@destroyBulk');
	Route::put('/price_list_types/statusBulk','PriceListTypeController@switchStatusBulk');
	Route::resource('/price_list_types','PriceListTypeController');

	// Customers
	Route::put('/customers/status','CustomerController@switchStatus')->name('supplier_status');
	Route::post('/customers/removeBulk','CustomerController@destroyBulk');
	Route::put('/customers/statusBulk','CustomerController@switchStatusBulk');
	Route::resource('/customers','CustomerController');

	// Categories
	Route::put('/categories/status','CategoryController@switchStatus')->name('category_status');
	Route::post('/categories/removeBulk','CategoryController@destroyBulk');
	Route::put('/categories/statusBulk','CategoryController@switchStatusBulk');
	Route::resource('/categories','CategoryController');