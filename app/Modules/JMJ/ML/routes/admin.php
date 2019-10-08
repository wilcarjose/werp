<?php

	// UpdatePrices
	Route::get('/update-prices/edit', 'UpdatePricesController@edit')->name('update-prices.edit');
	Route::put('/update-prices/update', 'UpdatePricesController@update')->name('update-prices.update');