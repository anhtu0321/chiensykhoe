<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/home', 'HomeController@getHome')->name('home');
Route::get('/', 'LoginController@getLogin')->name('login');
Route::post('/', 'LoginController@postLogin');
Route::get('/logout','LoginController@logOut')->name('logout');

// Trang quản trị
Route::group(['prefix'=>'admin'], function(){
    route::get('/','AdminController@getHome')->name('admin.home');
    // Permission
    route::get('/listChucNang','PermissionController@index')->middleware('can:view_permission');
    route::post('/addChucNang','PermissionController@store')->middleware('can:add_permission');
    route::post('/updateChucNang/{id}','PermissionController@update')->middleware('can:edit_permission');
    route::get('/deleteChucNang/{id}','PermissionController@destroy')->middleware('can:delete_permission');
    route::get('/listChucNangCha','PermissionController@listCha');
    route::get('/getChucNang/{id}','PermissionController@edit');
    // Role
    Route::get('/listRole', 'RoleController@index')->middleware('can:view_role');
    Route::post('/addRole','RoleController@store')->middleware('can:add_role');
    Route::post('/updateRole/{id}', 'RoleController@update')->middleware('can:edit_role');
    Route::get('/deleteRole/{id}', 'RoleController@destroy')->middleware('can:delete_role');
    Route::get('/listRoleFull', 'RoleController@list_role');
    Route::get('/getRole/{id}','RoleController@edit');
    // User
    Route::get('/listUser', 'UserController@index')->middleware('can:view_user');
    Route::post('/addUser', 'UserController@store')->middleware('can:add_user');
    Route::post('/editUser/{id}','UserController@update')->middleware('can:edit_user');
    Route::get('/deleteUser/{id}','UserController@destroy')->middleware('can:delete_user');
    Route::get('/getUser/{id}','UserController@edit');

});
