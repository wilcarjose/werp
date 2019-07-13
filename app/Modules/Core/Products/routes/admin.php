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

	// Config
	Route::get('/config/edit', '\Werp\Modules\Core\Products\Controllers\ConfigController@edit')->name('config.edit');
	Route::put('/config/update', '\Werp\Modules\Core\Products\Controllers\ConfigController@update')->name('config.update');

	// Prices
	Route::put('/price_lists/status','\Werp\Modules\Core\Products\Controllers\PriceListController@switchStatus')->name('price_list_status');
	Route::post('/price_lists/removeBulk','\Werp\Modules\Core\Products\Controllers\PriceListController@destroyBulk');
	Route::put('/price_lists/statusBulk','\Werp\Modules\Core\Products\Controllers\PriceListController@switchStatusBulk');
	Route::get('/price_lists/{id}/detail', '\Werp\Modules\Core\Products\Controllers\PriceListController@indexDetail')->name('price_lists.detail.index');
	Route::resource('/price_lists','\Werp\Modules\Core\Products\Controllers\PriceListController');
	Route::get('/price_lists/{id}/detail/{detail}', '\Werp\Modules\Core\Products\Controllers\PriceListController@showDetail')->name('price_lists.detail.show');
	Route::put('/price_lists/{id}/detail/{detail}', '\Werp\Modules\Core\Products\Controllers\PriceListController@updateDetail')->name('price_lists.detail.update');
	Route::post('/price_lists/{id}/detail', '\Werp\Modules\Core\Products\Controllers\PriceListController@storeDetail')->name('price_lists.detail.update');
	Route::delete('/price_lists/{id}/detail/{detail}', '\Werp\Modules\Core\Products\Controllers\PriceListController@destroyDetail')->name('price_lists.detail.update');
	Route::get('/price_lists/{id}/process', '\Werp\Modules\Core\Products\Controllers\PriceListController@process')->name('price_lists.process');
	Route::get('/price_lists/{id}/reverse', '\Werp\Modules\Core\Products\Controllers\PriceListController@reverse')->name('price_lists.reverse');

	// Price list type
	Route::put('/price_list_types/status','\Werp\Modules\Core\Products\Controllers\PriceListTypeController@switchStatus')->name('price_list_types_status');
	Route::post('/price_list_types/removeBulk','\Werp\Modules\Core\Products\Controllers\PriceListTypeController@destroyBulk');
	Route::put('/price_list_types/statusBulk','\Werp\Modules\Core\Products\Controllers\PriceListTypeController@switchStatusBulk');
	Route::resource('/price_list_types','\Werp\Modules\Core\Products\Controllers\PriceListTypeController');






