<?php

    // Categories
	Route::put('/suppliers/status','\Werp\Modules\Core\Purchases\Controllers\SupplierController@switchStatus')->name('supplier_status');
	Route::post('/suppliers/removeBulk','\Werp\Modules\Core\Purchases\Controllers\SupplierController@destroyBulk');
	Route::put('/suppliers/statusBulk','\Werp\Modules\Core\Purchases\Controllers\SupplierController@switchStatusBulk');
	//Route::get('/suppliers/{id}/cellar','\Werp\Modules\Core\Purchases\Controllers\SupplierController@showCellar');
	Route::resource('/suppliers','\Werp\Modules\Core\Purchases\Controllers\SupplierController');


	// Config
	Route::get('/config/edit', '\Werp\Modules\Core\Purchases\Controllers\ConfigController@edit')->name('config.edit');
	Route::put('/config/update', '\Werp\Modules\Core\Purchases\Controllers\ConfigController@update')->name('config.update');






