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
    route::post('/addChucNang','PermissionController@store');
    route::get('/listChucNangCha','PermissionController@listCha');
    route::get('/listChucNang','PermissionController@index');
    route::get('/getChucNang/{id}','PermissionController@edit');
    route::post('/updateChucNang/{id}','PermissionController@update');
    route::get('/deleteChucNang/{id}','PermissionController@destroy');
    // Role
    Route::post('/addRole','RoleController@store');
    Route::get('/listRole', 'RoleController@index');
    Route::get('/listRoleFull', 'RoleController@list_role');
    Route::get('/getRole/{id}','RoleController@edit');
    Route::post('/updateRole/{id}', 'RoleController@update');
    Route::get('/deleteRole/{id}', 'RoleController@destroy');
    // User
    Route::get('/listUser', 'UserController@index');
    Route::post('/addUser', 'UserController@store');
    Route::get('/getUser/{id}','UserController@edit');
    Route::post('/editUser/{id}','UserController@update');

});
