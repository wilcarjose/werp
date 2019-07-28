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






