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

	// Brands
	Route::put('/brands/status','\Werp\Modules\Core\Products\Controllers\BrandController@switchStatus')->name('brand_status');
	Route::post('/brands/removeBulk','\Werp\Modules\Core\Products\Controllers\BrandController@destroyBulk');
	Route::put('/brands/statusBulk','\Werp\Modules\Core\Products\Controllers\BrandController@switchStatusBulk');
	Route::resource('/brands','\Werp\Modules\Core\Products\Controllers\BrandController');

	// Uom
	Route::put('/uom/status','\Werp\Modules\Core\Products\Controllers\UomController@switchStatus')->name('brand_status');
	Route::post('/uom/removeBulk','\Werp\Modules\Core\Products\Controllers\UomController@destroyBulk');
	Route::put('/uom/statusBulk','\Werp\Modules\Core\Products\Controllers\UomController@switchStatusBulk');
	Route::resource('/uom','\Werp\Modules\Core\Products\Controllers\UomController');

	// Inventories
	Route::post('/inventories/removeBulk','\Werp\Modules\Core\Products\Controllers\InventoryController@destroyBulk');
	Route::get('/inventories/{id}/detail', '\Werp\Modules\Core\Products\Controllers\InventoryController@indexDetail')->name('inventories.detail.index');
	Route::get('/inventories/{id}/detail/{detail}', '\Werp\Modules\Core\Products\Controllers\InventoryController@showDetail')->name('inventories.detail.show');
	Route::put('/inventories/{id}/detail/{detail}', '\Werp\Modules\Core\Products\Controllers\InventoryController@updateDetail')->name('inventories.detail.update');
	Route::post('/inventories/{id}/detail', '\Werp\Modules\Core\Products\Controllers\InventoryController@storeDetail')->name('inventories.detail.update');
	Route::delete('/inventories/{id}/detail/{detail}', '\Werp\Modules\Core\Products\Controllers\InventoryController@destroyDetail')->name('inventories.detail.update');
	Route::get('/inventories/{id}/process', '\Werp\Modules\Core\Products\Controllers\InventoryController@process')->name('inventories.process');
	Route::get('/inventories/{id}/cancel', '\Werp\Modules\Core\Products\Controllers\InventoryController@cancel')->name('inventories.cancel');
	Route::resource('/inventories','\Werp\Modules\Core\Products\Controllers\InventoryController');

	// Config
	Route::get('/config/edit', '\Werp\Modules\Core\Products\Controllers\ConfigController@edit')->name('config.edit');
	Route::put('/config/update', '\Werp\Modules\Core\Products\Controllers\ConfigController@update')->name('config.update');

	// Stock
	Route::get('/stock', '\Werp\Modules\Core\Products\Controllers\StockController@index')->name('stock.index');

	// Transactions
	Route::get('/transactions', '\Werp\Modules\Core\Products\Controllers\TransactionController@index')->name('transactions.index');

	// Product entry
	Route::post('/product_entry/removeBulk','\Werp\Modules\Core\Products\Controllers\ProductEntryController@destroyBulk');
	Route::get('/product_entry/{id}/detail', '\Werp\Modules\Core\Products\Controllers\ProductEntryController@indexDetail')->name('product_entry.detail.index');
	Route::get('/product_entry/{id}/detail/{detail}', '\Werp\Modules\Core\Products\Controllers\ProductEntryController@showDetail')->name('product_entry.detail.show');
	Route::put('/product_entry/{id}/detail/{detail}', '\Werp\Modules\Core\Products\Controllers\ProductEntryController@updateDetail')->name('product_entry.detail.update');
	Route::post('/product_entry/{id}/detail', '\Werp\Modules\Core\Products\Controllers\ProductEntryController@storeDetail')->name('product_entry.detail.update');
	Route::delete('/product_entry/{id}/detail/{detail}', '\Werp\Modules\Core\Products\Controllers\ProductEntryController@destroyDetail')->name('product_entry.detail.update');
	Route::get('/product_entry/{id}/process', '\Werp\Modules\Core\Products\Controllers\ProductEntryController@process')->name('product_entry.process');
	Route::get('/product_entry/{id}/reverse', '\Werp\Modules\Core\Products\Controllers\ProductEntryController@reverse')->name('product_entry.reverse');
	Route::get('/product_entry/{id}/cancel', '\Werp\Modules\Core\Products\Controllers\ProductEntryController@cancel')->name('product_entry.cancel');
	Route::resource('/product_entry','\Werp\Modules\Core\Products\Controllers\ProductEntryController');

	// Product output
	Route::post('/product_output/removeBulk','\Werp\Modules\Core\Products\Controllers\ProductOutputController@destroyBulk');
	Route::get('/product_output/{id}/detail', '\Werp\Modules\Core\Products\Controllers\ProductOutputController@indexDetail')->name('product_output.detail.index');
	Route::get('/product_output/{id}/detail/{detail}', '\Werp\Modules\Core\Products\Controllers\ProductOutputController@showDetail')->name('product_output.detail.show');
	Route::put('/product_output/{id}/detail/{detail}', '\Werp\Modules\Core\Products\Controllers\ProductOutputController@updateDetail')->name('product_output.detail.update');
	Route::post('/product_output/{id}/detail', '\Werp\Modules\Core\Products\Controllers\ProductOutputController@storeDetail')->name('product_output.detail.update');
	Route::delete('/product_output/{id}/detail/{detail}', '\Werp\Modules\Core\Products\Controllers\ProductOutputController@destroyDetail')->name('product_output.detail.update');
	Route::get('/product_output/{id}/process', '\Werp\Modules\Core\Products\Controllers\ProductOutputController@process')->name('product_output.process');
	Route::get('/product_output/{id}/reverse', '\Werp\Modules\Core\Products\Controllers\ProductOutputController@reverse')->name('product_output.reverse');
	Route::get('/product_output/{id}/cancel', '\Werp\Modules\Core\Products\Controllers\ProductOutputController@cancel')->name('product_output.cancel');
	Route::resource('/product_output','\Werp\Modules\Core\Products\Controllers\ProductOutputController');

	// Movements
	Route::post('/movements/removeBulk','\Werp\Modules\Core\Products\Controllers\MovementController@destroyBulk');
	Route::get('/movements/{id}/detail', '\Werp\Modules\Core\Products\Controllers\MovementController@indexDetail')->name('movements.detail.index');
	Route::get('/movements/{id}/detail/{detail}', '\Werp\Modules\Core\Products\Controllers\MovementController@showDetail')->name('movements.detail.show');
	Route::put('/movements/{id}/detail/{detail}', '\Werp\Modules\Core\Products\Controllers\MovementController@updateDetail')->name('movements.detail.update');
	Route::post('/movements/{id}/detail', '\Werp\Modules\Core\Products\Controllers\MovementController@storeDetail')->name('movements.detail.update');
	Route::delete('/movements/{id}/detail/{detail}', '\Werp\Modules\Core\Products\Controllers\MovementController@destroyDetail')->name('movements.detail.update');
	Route::get('/movements/{id}/process', '\Werp\Modules\Core\Products\Controllers\MovementController@process')->name('movements.process');
	Route::get('/movements/{id}/reverse', '\Werp\Modules\Core\Products\Controllers\MovementController@reverse')->name('movements.reverse');
	Route::get('/movements/{id}/cancel', '\Werp\Modules\Core\Products\Controllers\MovementController@cancel')->name('movements.cancel');
	Route::resource('/movements','\Werp\Modules\Core\Products\Controllers\MovementController');





