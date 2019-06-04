<?php

Route::get('/home', 'Admin\HomeController@index')->name('home');

/**
 * ROLES
 */
 Route::get('/role/{role}/permissions','Admin\RoleController@permissions');
 Route::get('/rolePermissions','Admin\RoleController@rolePermissions')->name('myrolepermission');
 Route::get('/roles/all','Admin\RoleController@all');
 Route::post('/assignPermission','Admin\RoleController@attachPermission');
 Route::post('/detachPermission','Admin\RoleController@detachPermission');
 Route::resource('/roles','Admin\RoleController');

 /**
  * PERMISSIONs
  */
 Route::get('/permissions/all','Admin\PermissionController@all');
 Route::resource('/permissions','Admin\PermissionController');


 /**
 * ADMINs
 */
Route::get('/profile','Admin\AdminController@profileEdit');
Route::put('/profile/{admin}','Admin\AdminController@profileUpdate');
Route::put('/changepassword/{admin}','Admin\AdminController@changePassword');
Route::put('/administrator/status','Admin\AdminController@switchStatus');
Route::post('/administrator/removeBulk','Admin\AdminController@destroyBulk');
Route::put('/administrator/statusBulk','Admin\AdminController@switchStatusBulk');
Route::resource('/administrator','Admin\AdminController');

/**
 * USERS
 */
Route::put('/user/status','Admin\UserController@switchStatus')->name('user_status');
Route::post('/user/removeBulk','Admin\UserController@destroyBulk');
Route::put('/user/statusBulk','Admin\UserController@switchStatusBulk');
Route::get('/user/{id}/cellar','Admin\UserController@showUserCellar');
Route::resource('/user','Admin\UserController');

/**
 * CATEGORIES
 */
Route::put('/categories/status','\Werp\Modules\Core\Controllers\CategoryController@switchStatus')->name('category_status');
Route::post('/categories/removeBulk','\Werp\Modules\Core\Controllers\CategoryController@destroyBulk');
Route::put('/categories/statusBulk','\Werp\Modules\Core\Controllers\CategoryController@switchStatusBulk');
Route::get('/categories/{id}/cellar','\Werp\Modules\Core\Controllers\CategoryController@showCategoryCellar');
Route::resource('/categories','\Werp\Modules\Core\Controllers\CategoryController');

