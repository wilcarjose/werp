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
	Route::get('/orders/{id}/lines', 'PurchaseOrderController@indexLine')->name('orders.lines.index');
	Route::get('/orders/{id}/lines/{line_id}', 'PurchaseOrderController@showLine')->name('orders.lines.show');
	Route::put('/orders/{id}/lines/{line_id}', 'PurchaseOrderController@updateLine')->name('orders.lines.update');
	Route::post('/orders/{id}/lines', 'PurchaseOrderController@storeLine')->name('orders.lines.update');
	Route::delete('/orders/{id}/lines/{line_id}', 'PurchaseOrderController@destroyLine')->name('orders.lines.update');
	Route::get('/orders/{id}/process', 'PurchaseOrderController@process')->name('orders.process');
	Route::get('/orders/{id}/reverse', 'PurchaseOrderController@reverse')->name('orders.reverse');
	Route::get('/orders/{id}/cancel', 'PurchaseOrderController@cancel')->name('orders.cancel');
	Route::resource('/orders','PurchaseOrderController');

	// Price list type
	/*
	Route::put('/price_list_types/status','PriceListTypeController@switchStatus');
	Route::post('/price_list_types/removeBulk','PriceListTypeController@destroyBulk');
	Route::put('/price_list_types/statusBulk','PriceListTypeController@switchStatusBulk');
	Route::resource('/price_list_types','PriceListTypeController');
	*/

    // Purchases orders
    Route::post('/invoices/removeBulk','InvoiceController@destroyBulk');
    Route::get('/invoices/{id}/lines', 'InvoiceController@indexLine')->name('invoices.lines.index');
    Route::get('/invoices/{id}/lines/{line_id}', 'InvoiceController@showLine')->name('invoices.lines.show');
    Route::put('/invoices/{id}/lines/{line_id}', 'InvoiceController@updateLine')->name('invoices.lines.update');
    Route::post('/invoices/{id}/lines', 'InvoiceController@storeLine')->name('invoices.lines.update');
    Route::delete('/invoices/{id}/lines/{line_id}', 'InvoiceController@destroyLine')->name('invoices.lines.update');
    Route::get('/invoices/{id}/process', 'InvoiceController@process')->name('invoices.process');
    Route::get('/invoices/{id}/reverse', 'InvoiceController@reverse')->name('invoices.reverse');
    Route::get('/invoices/{id}/cancel', 'InvoiceController@cancel')->name('invoices.cancel');
    Route::resource('/invoices','InvoiceController');







