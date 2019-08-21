<?php

    // Categories
	Route::put('/categories/status','CategoryController@switchStatus')->name('category_status');
	Route::post('/categories/removeBulk','CategoryController@destroyBulk');
	Route::put('/categories/statusBulk','CategoryController@switchStatusBulk');
	//Route::get('/categories/{id}/cellar','CategoryController@showCellar');
	Route::resource('/categories','CategoryController');

	// Products
	Route::get('/products/stock','ProductController@getProductsStock');
	Route::put('/products/status','ProductController@switchStatus')->name('product_status');
	Route::post('/products/removeBulk','ProductController@destroyBulk');
	Route::put('/products/statusBulk','ProductController@switchStatusBulk');
	Route::get('/products/import','ProductController@showImport')->name('products.showimport');
	Route::post('/products/import','ProductController@import')->name('products.import');
	//Route::get('/products/{id}/cellar','ProductController@showCellar');
	Route::resource('/products','ProductController');

	// Warehouses
	Route::put('/warehouses/status','WarehouseController@switchStatus')->name('warehouse_status');
	Route::post('/warehouses/removeBulk','WarehouseController@destroyBulk');
	Route::put('/warehouses/statusBulk','WarehouseController@switchStatusBulk');
	//Route::get('/warehouses/{id}/cellar','WarehouseController@showCellar');
	Route::resource('/warehouses','WarehouseController');

	// Brands
	Route::put('/brands/status','BrandController@switchStatus')->name('brand_status');
	Route::post('/brands/removeBulk','BrandController@destroyBulk');
	Route::put('/brands/statusBulk','BrandController@switchStatusBulk');
	Route::resource('/brands','BrandController');

	// Uom
	Route::put('/uom/status','UomController@switchStatus')->name('brand_status');
	Route::post('/uom/removeBulk','UomController@destroyBulk');
	Route::put('/uom/statusBulk','UomController@switchStatusBulk');
	Route::resource('/uom','UomController');

	// Inventories
	Route::post('/inventories/removeBulk','InventoryController@destroyBulk');
	Route::get('/inventories/{id}/detail', 'InventoryController@indexDetail')->name('inventories.detail.index');
	Route::get('/inventories/{id}/detail/{detail}', 'InventoryController@showDetail')->name('inventories.detail.show');
	Route::put('/inventories/{id}/detail/{detail}', 'InventoryController@updateDetail')->name('inventories.detail.update');
	Route::post('/inventories/{id}/detail', 'InventoryController@storeDetail')->name('inventories.detail.update');
	Route::delete('/inventories/{id}/detail/{detail}', 'InventoryController@destroyDetail')->name('inventories.detail.update');
	Route::get('/inventories/{id}/process', 'InventoryController@process')->name('inventories.process');
	Route::get('/inventories/{id}/cancel', 'InventoryController@cancel')->name('inventories.cancel');
	Route::resource('/inventories','InventoryController');

	
	// Stock
	Route::get('/stock', 'StockController@index')->name('stock.index');

	// Transactions
	Route::get('/transactions', 'TransactionController@index')->name('transactions.index');

	// Product entry
	Route::post('/product_entry/removeBulk','ProductEntryController@destroyBulk');
	Route::get('/product_entry/{id}/detail', 'ProductEntryController@indexDetail')->name('product_entry.detail.index');
	Route::get('/product_entry/{id}/detail/{detail}', 'ProductEntryController@showDetail')->name('product_entry.detail.show');
	Route::put('/product_entry/{id}/detail/{detail}', 'ProductEntryController@updateDetail')->name('product_entry.detail.update');
	Route::post('/product_entry/{id}/detail', 'ProductEntryController@storeDetail')->name('product_entry.detail.update');
	Route::delete('/product_entry/{id}/detail/{detail}', 'ProductEntryController@destroyDetail')->name('product_entry.detail.update');
	Route::get('/product_entry/{id}/process', 'ProductEntryController@process')->name('product_entry.process');
	Route::get('/product_entry/{id}/reverse', 'ProductEntryController@reverse')->name('product_entry.reverse');
	Route::get('/product_entry/{id}/cancel', 'ProductEntryController@cancel')->name('product_entry.cancel');
	Route::resource('/product_entry','ProductEntryController');

	// Product output
	Route::post('/product_output/removeBulk','ProductOutputController@destroyBulk');
	Route::get('/product_output/{id}/detail', 'ProductOutputController@indexDetail')->name('product_output.detail.index');
	Route::get('/product_output/{id}/detail/{detail}', 'ProductOutputController@showDetail')->name('product_output.detail.show');
	Route::put('/product_output/{id}/detail/{detail}', 'ProductOutputController@updateDetail')->name('product_output.detail.update');
	Route::post('/product_output/{id}/detail', 'ProductOutputController@storeDetail')->name('product_output.detail.update');
	Route::delete('/product_output/{id}/detail/{detail}', 'ProductOutputController@destroyDetail')->name('product_output.detail.update');
	Route::get('/product_output/{id}/process', 'ProductOutputController@process')->name('product_output.process');
	Route::get('/product_output/{id}/reverse', 'ProductOutputController@reverse')->name('product_output.reverse');
	Route::get('/product_output/{id}/cancel', 'ProductOutputController@cancel')->name('product_output.cancel');
	Route::get('/product_output/{id}/print', 'ProductOutputController@print')->name('product_output.print');
	Route::resource('/product_output','ProductOutputController');

	// Movements
	Route::post('/movements/removeBulk','MovementController@destroyBulk');
	Route::get('/movements/{id}/detail', 'MovementController@indexDetail')->name('movements.detail.index');
	Route::get('/movements/{id}/detail/{detail}', 'MovementController@showDetail')->name('movements.detail.show');
	Route::put('/movements/{id}/detail/{detail}', 'MovementController@updateDetail')->name('movements.detail.update');
	Route::post('/movements/{id}/detail', 'MovementController@storeDetail')->name('movements.detail.update');
	Route::delete('/movements/{id}/detail/{detail}', 'MovementController@destroyDetail')->name('movements.detail.update');
	Route::get('/movements/{id}/process', 'MovementController@process')->name('movements.process');
	Route::get('/movements/{id}/reverse', 'MovementController@reverse')->name('movements.reverse');
	Route::get('/movements/{id}/cancel', 'MovementController@cancel')->name('movements.cancel');
	Route::resource('/movements','MovementController');





