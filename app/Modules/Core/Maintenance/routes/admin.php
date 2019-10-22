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
	Route::get('/exchange_rates/{currencyFrom}/{currencyTo}/edit', 'ExchangeRateController@loadExchange')->name('exchange_rates.get');
	Route::resource('/exchange_rates','ExchangeRateController');

	Route::get('/db_test/edit', 'DataTestController@edit')->name('db_test.edit');
	Route::put('/db_test/update', 'DataTestController@update')->name('db_test.update');
	Route::post('/db_test/update-from-sql', 'DataTestController@updateFromSql')->name('db_test.update-from-sql');
	Route::post('/db_test/update-production-from-test', 'DataTestController@updateProductionFromTest')->name('db_test.update-production-from-test');

	Route::get('/db_backups', 'DataBackupController@index')->name('db_backups.index');
	Route::get('/db_backups/create', 'DataBackupController@create')->name('db_backups.create');
	Route::get('/db_backups/{date}/download', 'DataBackupController@download')->name('db_backups.download');
	Route::get('/db_backups/{date}/destroy', 'DataBackupController@destroy')->name('db_backups.destroy');

	// Config
	Route::get('/general_config/edit', 'GeneralConfigController@edit')->name('general_config.edit');
	Route::put('/general_config/company', 'GeneralConfigController@updateCompany')->name('general_config.company');
	Route::put('/general_config/currency', 'GeneralConfigController@updateCurrency')->name('general_config.currency');
	Route::put('/general_config/warehouse', 'GeneralConfigController@updateWarehouse')->name('general_config.warehouse');

	// Prices
	Route::put('/price_lists/status','PriceListController@switchStatus')->name('price_list_status');
	Route::post('/price_lists/removeBulk','PriceListController@destroyBulk');
	Route::put('/price_lists/statusBulk','PriceListController@switchStatusBulk');
	Route::get('/price_lists/{id}/lines', 'PriceListController@indexLine')->name('price_lists.lines.index');
	Route::resource('/price_lists','PriceListController');
	Route::get('/price_lists/{id}/lines/{line_id}', 'PriceListController@showLine')->name('price_lists.lines.show');
	Route::put('/price_lists/{id}/lines/{line_id}', 'PriceListController@updateLine')->name('price_lists.lines.update');
	Route::post('/price_lists/{id}/lines', 'PriceListController@storeLine')->name('price_lists.lines.update');
	Route::delete('/price_lists/{id}/lines/{line_id}', 'PriceListController@destroyLine')->name('price_lists.lines.update');
	Route::post('/price_lists/{id}/lines/removeBulk','PriceListController@destroyLinesBulk');

	Route::get('/price_lists/{id}/process', 'PriceListController@process')->name('price_lists.process');
	Route::get('/price_lists/{id}/reverse', 'PriceListController@reverse')->name('price_lists.reverse');

	// Price list type
	Route::put('/price_list_types/status','PriceListTypeController@switchStatus');
	Route::post('/price_list_types/removeBulk','PriceListTypeController@destroyBulk');
	Route::put('/price_list_types/statusBulk','PriceListTypeController@switchStatusBulk');
	Route::resource('/price_list_types','PriceListTypeController');