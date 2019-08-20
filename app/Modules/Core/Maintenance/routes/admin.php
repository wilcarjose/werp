<?php

	// Price list type
	Route::put('/amount_operations/status','AmountOperationController@switchStatus')->name('amount_operations_status');
	Route::post('/amount_operations/removeBulk','AmountOperationController@destroyBulk');
	Route::put('/amount_operations/statusBulk','AmountOperationController@switchStatusBulk');
	Route::resource('/amount_operations','AmountOperationController');

	// Config
	Route::get('/config/edit', 'ConfigController@edit')->name('config.edit');
	Route::put('/config/update', 'ConfigController@update')->name('config.update');

	// Price list type
	Route::put('/currencies/status','CurrencyController@switchStatus')->name('currencies_status');
	Route::post('/currencies/removeBulk','CurrencyController@destroyBulk');
	Route::put('/currencies/statusBulk','CurrencyController@switchStatusBulk');
	Route::resource('/currencies','CurrencyController');

