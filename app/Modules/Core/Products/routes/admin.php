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
	Route::post('/products/{id}/limits','ProductController@limits')->name('products.limits');
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
	Route::get('/inventories/{id}/lines', 'InventoryController@indexLine')->name('inventories.lines.index');
	Route::get('/inventories/{id}/lines/{line_id}', 'InventoryController@showLine')->name('inventories.lines.show');
	Route::put('/inventories/{id}/lines/{line_id}', 'InventoryController@updateLine')->name('inventories.lines.update');
	Route::post('/inventories/{id}/lines', 'InventoryController@storeLine')->name('inventories.lines.update');
	Route::delete('/inventories/{id}/lines/{line_id}', 'InventoryController@destroyLine')->name('inventories.lines.update');
	Route::get('/inventories/{id}/process', 'InventoryController@process')->name('inventories.process');
	Route::get('/inventories/{id}/cancel', 'InventoryController@cancel')->name('inventories.cancel');
	Route::get('/inventories/{id}/copy', 'InventoryController@copy')->name('inventories.copy');
	Route::resource('/inventories','InventoryController');


	// Stock
	Route::get('/stock', 'StockController@index')->name('stock.index');

	// Transactions
	Route::get('/transactions', 'TransactionController@index')->name('transactions.index');

	// Product entry
	Route::post('/product_entry/removeBulk','ProductEntryController@destroyBulk');
	Route::get('/product_entry/{id}/lines', 'ProductEntryController@indexLine')->name('product_entry.lines.index');
	Route::get('/product_entry/{id}/lines/{line_id}', 'ProductEntryController@showLine')->name('product_entry.lines.show');
	Route::put('/product_entry/{id}/lines/{line_id}', 'ProductEntryController@updateLine')->name('product_entry.lines.update');
	Route::post('/product_entry/{id}/lines', 'ProductEntryController@storeLine')->name('product_entry.lines.update');
	Route::delete('/product_entry/{id}/lines/{line_id}', 'ProductEntryController@destroyLine')->name('product_entry.lines.update');
	Route::get('/product_entry/{id}/process', 'ProductEntryController@process')->name('product_entry.process');
	Route::get('/product_entry/{id}/reverse', 'ProductEntryController@reverse')->name('product_entry.reverse');
	Route::get('/product_entry/{id}/cancel', 'ProductEntryController@cancel')->name('product_entry.cancel');
	Route::resource('/product_entry','ProductEntryController');

	// Product output
	Route::post('/product_output/removeBulk','ProductOutputController@destroyBulk');
	Route::get('/product_output/{id}/lines', 'ProductOutputController@indexLine')->name('product_output.lines.index');
	Route::get('/product_output/{id}/lines/{line_id}', 'ProductOutputController@showLine')->name('product_output.lines.show');
	Route::put('/product_output/{id}/lines/{line_id}', 'ProductOutputController@updateLine')->name('product_output.lines.update');
	Route::post('/product_output/{id}/lines', 'ProductOutputController@storeLine')->name('product_output.lines.update');
	Route::delete('/product_output/{id}/lines/{line_id}', 'ProductOutputController@destroyLine')->name('product_output.lines.update');
	Route::get('/product_output/{id}/process', 'ProductOutputController@process')->name('product_output.process');
	Route::get('/product_output/{id}/reverse', 'ProductOutputController@reverse')->name('product_output.reverse');
	Route::get('/product_output/{id}/cancel', 'ProductOutputController@cancel')->name('product_output.cancel');
	Route::get('/product_output/{id}/print', 'ProductOutputController@print')->name('product_output.print');
	Route::resource('/product_output','ProductOutputController');

	// Movements
	Route::post('/movements/removeBulk','MovementController@destroyBulk');
	Route::get('/movements/{id}/lines', 'MovementController@indexLine')->name('movements.lines.index');
	Route::get('/movements/{id}/lines/{line_id}', 'MovementController@showLine')->name('movements.lines.show');
	Route::put('/movements/{id}/lines/{line_id}', 'MovementController@updateLine')->name('movements.lines.update');
	Route::post('/movements/{id}/lines', 'MovementController@storeLine')->name('movements.lines.update');
	Route::delete('/movements/{id}/lines/{line_id}', 'MovementController@destroyLine')->name('movements.lines.update');
	Route::get('/movements/{id}/process', 'MovementController@process')->name('movements.process');
	Route::get('/movements/{id}/reverse', 'MovementController@reverse')->name('movements.reverse');
	Route::get('/movements/{id}/cancel', 'MovementController@cancel')->name('movements.cancel');
	Route::resource('/movements','MovementController');





