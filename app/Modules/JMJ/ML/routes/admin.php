<?php

    Route::get('/config/edit', 'ConfigController@edit')->name('config.edit');

    Route::get('/login', 'AccessController@login')->name('login.view');
    Route::put('/login', 'AccessController@access')->name('login.post');
    Route::put('/logout', 'AccessController@logout')->name('logout.do');
    Route::get('/callback', 'AccessController@callback')->name('login.callback');

	// UpdatePrices
	Route::get('/update-prices/edit/{priceListId?}', 'UpdatePricesController@edit')->name('update-prices.edit');
	Route::put('/update-prices/update', 'UpdatePricesController@update')->name('update-prices.update');
    Route::put('/update-prices/send-prices', 'UpdatePricesController@sendPrices')->name('update-prices.send');
    Route::get('/export/{priceListId}', 'UpdatePricesController@export')->name('update-prices.export');

    Route::get('/config/edit', 'ConfigController@edit')->name('config.edit');
    Route::put('/config/update', 'ConfigController@update')->name('config.update');

    Route::put('/item/{id}', 'ItemController@update')->name('item.update');
