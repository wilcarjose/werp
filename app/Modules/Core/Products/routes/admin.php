<?php

    // Categories
	Route::put('/categories/status','\Werp\Modules\Core\Products\Controllers\CategoryController@switchStatus')->name('category_status');
	Route::post('/categories/removeBulk','\Werp\Modules\Core\Products\Controllers\CategoryController@destroyBulk');
	Route::put('/categories/statusBulk','\Werp\Modules\Core\Products\Controllers\CategoryController@switchStatusBulk');
	Route::get('/categories/{id}/cellar','\Werp\Modules\Core\Products\Controllers\CategoryController@showCategoryCellar');
	Route::resource('/categories','\Werp\Modules\Core\Products\Controllers\CategoryController');

	// Products
	Route::put('/products/status','\Werp\Modules\Core\Products\Controllers\ProductController@switchStatus')->name('product_status');
	Route::post('/products/removeBulk','\Werp\Modules\Core\Products\Controllers\ProductController@destroyBulk');
	Route::put('/products/statusBulk','\Werp\Modules\Core\Products\Controllers\ProductController@switchStatusBulk');
	Route::get('/products/{id}/cellar','\Werp\Modules\Core\Products\Controllers\ProductController@showProductCellar');
	Route::resource('/products','\Werp\Modules\Core\Products\Controllers\ProductController');

	// Warehouses
	Route::put('/warehouses/status','\Werp\Modules\Core\Products\Controllers\WarehouseController@switchStatus')->name('warehouse_status');
	Route::post('/warehouses/removeBulk','\Werp\Modules\Core\Products\Controllers\WarehouseController@destroyBulk');
	Route::put('/warehouses/statusBulk','\Werp\Modules\Core\Products\Controllers\WarehouseController@switchStatusBulk');
	Route::get('/warehouses/{id}/cellar','\Werp\Modules\Core\Products\Controllers\WarehouseController@showWarehouseCellar');
	Route::resource('/warehouses','\Werp\Modules\Core\Products\Controllers\WarehouseController');




