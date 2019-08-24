<?php

	// Categories
	Route::put('/categories/status','CategoryController@switchStatus')->name('category_status');
	Route::post('/categories/removeBulk','CategoryController@destroyBulk');
	Route::put('/categories/statusBulk','CategoryController@switchStatusBulk');
	Route::resource('/categories','CategoryController');

    // Suppliers
	Route::put('/suppliers/status','SupplierController@switchStatus')->name('supplier_status');
	Route::post('/suppliers/removeBulk','SupplierController@destroyBulk');
	Route::put('/suppliers/statusBulk','SupplierController@switchStatusBulk');
	Route::resource('/suppliers','SupplierController');

	// Config
	Route::get('/config/edit', 'ConfigController@edit')->name('config.edit');
	Route::put('/config/update', 'ConfigController@update')->name('config.update');

	// Purchases orders
	Route::post('/orders/removeBulk','PurchaseOrderController@destroyBulk');
	Route::get('/orders/{id}/detail', 'PurchaseOrderController@indexDetail')->name('orders.detail.index');
	Route::get('/orders/{id}/detail/{detail}', 'PurchaseOrderController@showDetail')->name('orders.detail.show');
	Route::put('/orders/{id}/detail/{detail}', 'PurchaseOrderController@updateDetail')->name('orders.detail.update');
	Route::post('/orders/{id}/detail', 'PurchaseOrderController@storeDetail')->name('orders.detail.update');
	Route::delete('/orders/{id}/detail/{detail}', 'PurchaseOrderController@destroyDetail')->name('orders.detail.update');
	Route::get('/orders/{id}/process', 'PurchaseOrderController@process')->name('orders.process');
	Route::get('/orders/{id}/reverse', 'PurchaseOrderController@reverse')->name('orders.reverse');
	Route::get('/orders/{id}/cancel', 'PurchaseOrderController@cancel')->name('orders.cancel');
	Route::resource('/orders','PurchaseOrderController');

	// Price list type
	Route::put('/price_list_types/status','PriceListTypeController@switchStatus');
	Route::post('/price_list_types/removeBulk','PriceListTypeController@destroyBulk');
	Route::put('/price_list_types/statusBulk','PriceListTypeController@switchStatusBulk');
	Route::resource('/price_list_types','PriceListTypeController');







