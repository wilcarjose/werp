<?php

    // Categories
	Route::put('/categories/status','\Werp\Modules\Core\Products\Controllers\CategoryController@switchStatus')->name('category_status');
	Route::post('/categories/removeBulk','\Werp\Modules\Core\Products\Controllers\CategoryController@destroyBulk');
	Route::put('/categories/statusBulk','\Werp\Modules\Core\Products\Controllers\CategoryController@switchStatusBulk');
	//Route::get('/categories/{id}/cellar','\Werp\Modules\Core\Products\Controllers\CategoryController@showCellar');
	Route::resource('/categories','\Werp\Modules\Core\Products\Controllers\CategoryController');

	// Products
	Route::put('/products/status','\Werp\Modules\Core\Products\Controllers\ProductController@switchStatus')->name('product_status');
	Route::post('/products/removeBulk','\Werp\Modules\Core\Products\Controllers\ProductController@destroyBulk');
	Route::put('/products/statusBulk','\Werp\Modules\Core\Products\Controllers\ProductController@switchStatusBulk');
	//Route::get('/products/{id}/cellar','\Werp\Modules\Core\Products\Controllers\ProductController@showCellar');
	Route::resource('/products','\Werp\Modules\Core\Products\Controllers\ProductController');

	// Warehouses
	Route::put('/warehouses/status','\Werp\Modules\Core\Products\Controllers\WarehouseController@switchStatus')->name('warehouse_status');
	Route::post('/warehouses/removeBulk','\Werp\Modules\Core\Products\Controllers\WarehouseController@destroyBulk');
	Route::put('/warehouses/statusBulk','\Werp\Modules\Core\Products\Controllers\WarehouseController@switchStatusBulk');
	//Route::get('/warehouses/{id}/cellar','\Werp\Modules\Core\Products\Controllers\WarehouseController@showCellar');
	Route::resource('/warehouses','\Werp\Modules\Core\Products\Controllers\WarehouseController');

	// Inventories
	Route::post('/inventories/removeBulk','\Werp\Modules\Core\Products\Controllers\InventoryController@destroyBulk');
	Route::get('/inventories/{id}/detail', '\Werp\Modules\Core\Products\Controllers\InventoryController@indexDetail')->name('inventories.detail.index');
	Route::get('/inventories/{id}/detail/{detail}', '\Werp\Modules\Core\Products\Controllers\InventoryController@showDetail')->name('inventories.detail.show');
	Route::put('/inventories/{id}/detail/{detail}', '\Werp\Modules\Core\Products\Controllers\InventoryController@updateDetail')->name('inventories.detail.update');
	Route::post('/inventories/{id}/detail', '\Werp\Modules\Core\Products\Controllers\InventoryController@storeDetail')->name('inventories.detail.update');
	Route::delete('/inventories/{id}/detail/{detail}', '\Werp\Modules\Core\Products\Controllers\InventoryController@destroyDetail')->name('inventories.detail.update');
	Route::get('/inventories/{id}/process', '\Werp\Modules\Core\Products\Controllers\InventoryController@process')->name('inventories.process');
	Route::get('/inventories/{id}/reverse', '\Werp\Modules\Core\Products\Controllers\InventoryController@reverse')->name('inventories.reverse');
	Route::resource('/inventories','\Werp\Modules\Core\Products\Controllers\InventoryController');




