<?php

	// Company
	Route::get('/company/edit', 'CompanyController@edit')->name('company.edit');
	Route::put('/company/update', 'CompanyController@update')->name('company.update');

	// Price list type
	Route::put('/amount_operations/status','AmountOperationController@switchStatus')->name('amount_operations_status');
	Route::post('/amount_operations/removeBulk','AmountOperationController@destroyBulk');
	Route::put('/amount_operations/statusBulk','AmountOperationController@switchStatusBulk');
	Route::resource('/amount_operations','AmountOperationController');

	// Config
	Route::get('/config/edit', 'ConfigController@edit')->name('config.edit');
	Route::put('/config/update', 'ConfigController@update')->name('config.update');

	// Currencies
	Route::put('/currencies/status','CurrencyController@switchStatus')->name('currencies_status');
	Route::post('/currencies/removeBulk','CurrencyController@destroyBulk');
	Route::put('/currencies/statusBulk','CurrencyController@switchStatusBulk');
	Route::resource('/currencies','CurrencyController');

	// Exchange rates
	Route::put('/exchange_rates/status','ExchangeRateController@switchStatus')->name('exchange_rates_status');
	Route::post('/exchange_rates/removeBulk','ExchangeRateController@destroyBulk');
	Route::put('/exchange_rates/statusBulk','ExchangeRateController@switchStatusBulk');
	Route::get('/exchange_rates/{currencyFrom}/{currencyTo}/edit', 'ExchangeRateController@loadExchange');
	Route::resource('/exchange_rates','ExchangeRateController');
