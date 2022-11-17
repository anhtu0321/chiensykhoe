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
    Route::post('/doimatkhau','UserController@doimatkhau');
    // donvi
    Route::get('/listDonvi', 'DonviController@index')->middleware('can:view_donvi');
    Route::post('/addDonvi', 'DonviController@store')->middleware('can:add_donvi');
    Route::post('/editDonvi/{id}','DonviController@update')->middleware('can:edit_donvi');
    Route::get('/deleteDonvi/{id}','DonviController@destroy')->middleware('can:delete_donvi');
    Route::get('/getDonvi/{id}','DonviController@edit');
    // canbo
    Route::get('/listCanbo', 'CanboController@index')->middleware('can:view_canbo');
    Route::post('/addCanbo', 'CanboController@store')->middleware('can:add_canbo');
    Route::post('/editCanbo/{id}','CanboController@update')->middleware('can:edit_canbo');
    Route::get('/deleteCanbo/{id}','CanboController@destroy')->middleware('can:delete_canbo');
    Route::get('/getCanbo/{id}','CanboController@edit');

});
// Dữ liệu liên quan
    Route::get('/listKhoi','Dulieulienquan@listKhoi');
    Route::get('/listCapbac','Dulieulienquan@listCapbac');
    Route::get('/listChucvu','Dulieulienquan@listChucvu');
    Route::get('/listDonvi','Dulieulienquan@listDonvi');
    Route::post('/searchCanbo','Dulieulienquan@searchCanbo');


// XỬ LÝ TẠI FRONT END
    // danh sach
    Route::get('/listDanhsach','DanhsachController@index');
    Route::post('/addDanhsach','DanhsachController@store');
    Route::get('/editDanhsach/{id}','DanhsachController@edit');
    Route::post('/updateDanhsach/{id}','DanhsachController@update');
    Route::get('/deleteDanhsach/{id}','DanhsachController@deleted');
    // quy tac
    Route::get('/listQuytac','QuytacController@index');
    Route::get('/editQuytac/{id}','QuytacController@edit');
    Route::post('/updateQuytac/{id}','QuytacController@update');
    Route::post('/addQuyTac','QuytacController@store');
    Route::get('/deleteQuytac/{id}','QuytacController@deleted');
    // môn thi
    Route::get('/listMonthi','MonthiController@index');
    Route::get('/editMonthi/{id}','MonthiController@edit');
    Route::post('/updateMonthi/{id}','MonthiController@update');
    Route::post('/addMonthi','MonthiController@store');
    Route::get('/deleteMonthi/{id}','MonthiController@deleted');
    // Luật
    Route::get('/listLuat/{id_quy_tac}','LuatController@index');
    Route::get('/editLuat/{id}','LuatController@edit');
    Route::post('/updateLuat/{id}','LuatController@update');
    Route::post('/addLuat','LuatController@store');
    Route::get('/deleteLuat/{id}','LuatController@deleted');
    // Thêm cán bộ vào danh sach
    Route::post('/addCanboToDanhsach','CanbotodanhsachController@store');
    Route::post('/listCanboOfDanhsach/{id}','CanbotodanhsachController@index');

    