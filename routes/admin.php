<?php

Route::get('/home', 'Admin\HomeController@index')->name('home');

Route::get('/impersonate/{id}', 'AdminAuth\ImpersonateController@impersonate')->name('impersonate')->middleware('impersonate.protect');
Route::get('/leave-impersonate', 'AdminAuth\ImpersonateController@leaveImpersonation')->name('leave-impersonate');

/**
 * ROLES
 */
 Route::get('/role/{role}/permissions','Admin\RoleController@permissions')->middleware('impersonate.protect');
 Route::get('/rolePermissions','Admin\RoleController@rolePermissions')->name('myrolepermission')->middleware('impersonate.protect');
 Route::get('/roles/all','Admin\RoleController@all')->middleware('impersonate.protect');
 Route::post('/assignPermission','Admin\RoleController@attachPermission')->middleware('impersonate.protect');
 Route::post('/detachPermission','Admin\RoleController@detachPermission')->middleware('impersonate.protect');
 Route::resource('/roles','Admin\RoleController')->middleware('impersonate.protect');

 /**
  * PERMISSIONs
  */
 Route::get('/permissions/all','Admin\PermissionController@all')->middleware('impersonate.protect');
 Route::resource('/permissions','Admin\PermissionController')->middleware('impersonate.protect');


 /**
 * ADMINs
 */
Route::get('/profile','Admin\AdminController@profileEdit')->middleware('impersonate.protect');
Route::put('/profile/{admin}','Admin\AdminController@profileUpdate')->middleware('impersonate.protect');
Route::put('/changepassword/{admin}','Admin\AdminController@changePassword')->middleware('impersonate.protect');
Route::put('/administrator/status','Admin\AdminController@switchStatus')->middleware('impersonate.protect');
Route::post('/administrator/removeBulk','Admin\AdminController@destroyBulk')->middleware('impersonate.protect');
Route::put('/administrator/statusBulk','Admin\AdminController@switchStatusBulk')->middleware('impersonate.protect');
Route::resource('/administrator','Admin\AdminController')->middleware('impersonate.protect');

/**
 * USERS
 */
Route::put('/user/status','Admin\UserController@switchStatus')->name('user_status');
Route::post('/user/removeBulk','Admin\UserController@destroyBulk');
Route::put('/user/statusBulk','Admin\UserController@switchStatusBulk');
Route::get('/user/{id}/cellar','Admin\UserController@showUserCellar');
Route::resource('/user','Admin\UserController');


