<?php

// Prices
	Route::put('/price_lists/status','PriceListController@switchStatus')->name('price_list_status');
	Route::post('/price_lists/removeBulk','PriceListController@destroyBulk');
	Route::put('/price_lists/statusBulk','PriceListController@switchStatusBulk');
	Route::get('/price_lists/{id}/lines', 'PriceListController@indexLine')->name('price_lists.lines.index');
	Route::resource('/price_lists','PriceListController');
	Route::get('/price_lists/{id}/lines/{line_id}', 'PriceListController@showLine')->name('price_lists.lines.show');
	Route::put('/price_lists/{id}/lines/{line_id}', 'PriceListController@updateLine')->name('price_lists.lines.update');
	Route::post('/price_lists/{id}/lines', 'PriceListController@storeLine')->name('price_lists.lines.update');
	Route::delete('/price_lists/{id}/lines/{line_id}', 'PriceListController@destroyLine')->name('price_lists.lines.update');
	Route::post('/price_lists/{id}/lines/removeBulk','PriceListController@destroyLinesBulk');

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
	Route::get('/orders/{id}/lines', 'SaleOrderController@indexLine')->name('orders.lines.index');
	Route::get('/orders/{id}/lines/{line_id}', 'SaleOrderController@showLine')->name('orders.lines.show');
	Route::put('/orders/{id}/lines/{line_id}', 'SaleOrderController@updateLine')->name('orders.lines.update');
	Route::post('/orders/{id}/lines', 'SaleOrderController@storeLine')->name('orders.lines.update');
	Route::delete('/orders/{id}/lines/{line_id}', 'SaleOrderController@destroyLine')->name('orders.lines.update');
	Route::get('/orders/{id}/process', 'SaleOrderController@process')->name('orders.process');
	Route::get('/orders/{id}/reverse', 'SaleOrderController@reverse')->name('orders.reverse');
	Route::get('/orders/{id}/cancel', 'SaleOrderController@cancel')->name('orders.cancel');
	Route::resource('/orders','SaleOrderController');

