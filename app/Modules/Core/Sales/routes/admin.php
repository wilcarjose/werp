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
	Route::put('/price_list_types/status','PriceListTypeController@switchStatus');
	Route::post('/price_list_types/removeBulk','PriceListTypeController@destroyBulk');
	Route::put('/price_list_types/statusBulk','PriceListTypeController@switchStatusBulk');
	Route::resource('/price_list_types','PriceListTypeController');

	// Customers
	Route::put('/customers/status','CustomerController@switchStatus');
	Route::post('/customers/removeBulk','CustomerController@destroyBulk');
	Route::put('/customers/statusBulk','CustomerController@switchStatusBulk');
	Route::resource('/customers','CustomerController');

	// Categories
	Route::put('/categories/status','CategoryController@switchStatus');
	Route::post('/categories/removeBulk','CategoryController@destroyBulk');
	Route::put('/categories/statusBulk','CategoryController@switchStatusBulk');
	Route::resource('/categories','CategoryController');

	// Payment method
	Route::put('/payment_methods/status','PaymentMethodController@switchStatus');
	Route::post('/payment_methods/removeBulk','PaymentMethodController@destroyBulk');
	Route::put('/payment_methods/statusBulk','PaymentMethodController@switchStatusBulk');
	Route::resource('/payment_methods','PaymentMethodController');

	// Sales channels
	Route::put('/sales_channels/status','SaleChannelController@switchStatus');
	Route::post('/sales_channels/removeBulk','SaleChannelController@destroyBulk');
	Route::put('/sales_channels/statusBulk','SaleChannelController@switchStatusBulk');
	Route::resource('/sales_channels','SaleChannelController');

	// Taxs
	Route::put('/taxs/status','TaxController@switchStatus');
	Route::post('/taxs/removeBulk','TaxController@destroyBulk');
	Route::put('/taxs/statusBulk','TaxController@switchStatusBulk');
	Route::resource('/taxs','TaxController');

	// Discounts
	Route::put('/discounts/status','DiscountController@switchStatus');
	Route::post('/discounts/removeBulk','DiscountController@destroyBulk');
	Route::put('/discounts/statusBulk','DiscountController@switchStatusBulk');
	Route::resource('/discounts','DiscountController');

	// Sales orders
	Route::post('/orders/removeBulk','SaleOrderController@destroyBulk');
	Route::get('/orders/{id}/detail', 'SaleOrderController@indexDetail')->name('orders.detail.index');
	Route::get('/orders/{id}/detail/{detail}', 'SaleOrderController@showDetail')->name('orders.detail.show');
	Route::put('/orders/{id}/detail/{detail}', 'SaleOrderController@updateDetail')->name('orders.detail.update');
	Route::post('/orders/{id}/detail', 'SaleOrderController@storeDetail')->name('orders.detail.update');
	Route::delete('/orders/{id}/detail/{detail}', 'SaleOrderController@destroyDetail')->name('orders.detail.update');
	Route::get('/orders/{id}/process', 'SaleOrderController@process')->name('orders.process');
	Route::get('/orders/{id}/reverse', 'SaleOrderController@reverse')->name('orders.reverse');
	Route::get('/orders/{id}/cancel', 'SaleOrderController@cancel')->name('orders.cancel');
	Route::resource('/orders','SaleOrderController');

