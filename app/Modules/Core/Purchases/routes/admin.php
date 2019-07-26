<?php

	// Categories
	Route::put('/categories/status','\Werp\Modules\Core\Purchases\Controllers\CategoryController@switchStatus')->name('category_status');
	Route::post('/categories/removeBulk','\Werp\Modules\Core\Purchases\Controllers\CategoryController@destroyBulk');
	Route::put('/categories/statusBulk','\Werp\Modules\Core\Purchases\Controllers\CategoryController@switchStatusBulk');
	Route::resource('/categories','\Werp\Modules\Core\Purchases\Controllers\CategoryController');

    // Suppliers
	Route::put('/suppliers/status','\Werp\Modules\Core\Purchases\Controllers\SupplierController@switchStatus')->name('supplier_status');
	Route::post('/suppliers/removeBulk','\Werp\Modules\Core\Purchases\Controllers\SupplierController@destroyBulk');
	Route::put('/suppliers/statusBulk','\Werp\Modules\Core\Purchases\Controllers\SupplierController@switchStatusBulk');
	Route::resource('/suppliers','\Werp\Modules\Core\Purchases\Controllers\SupplierController');


	// Config
	Route::get('/config/edit', '\Werp\Modules\Core\Purchases\Controllers\ConfigController@edit')->name('config.edit');
	Route::put('/config/update', '\Werp\Modules\Core\Purchases\Controllers\ConfigController@update')->name('config.update');






