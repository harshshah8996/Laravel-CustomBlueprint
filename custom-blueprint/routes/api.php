
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['prefix' => 'auth'], function () {
    Route::post('/sign-up', 'AuthController@signUp');
    Route::post('/login', 'AuthController@login');
});

Route::group(['prefix' => 'admin'], function () {

    Route::group(['middleware' => ['auth:api','admin']], function () {

        Route::get('/roles','RoleController@getAllRoles');
        Route::post('/role','RoleController@createRole');
        Route::get('/role/{id}','RoleController@getRole');
        Route::post('/role/{id}','RoleController@updateRole');
        Route::delete('/role/{id}','RoleController@deleteRole');

        Route::get('/users','AdminController@getAllUsers');
        Route::post('/user','AdminController@saveUser');
        Route::get('/user/{id}','AdminController@getUser');
        Route::post('/user/{id}','AdminController@updateUser');

    });
});