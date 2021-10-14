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

Route::post('/test', 'MainController@createEmployee');
Route::put('/edit/{id}', 'MainController@updateEmployee');
Route::post('/department', 'MainController@createDepartment');
Route::put('/departmentUpdate/{id}', 'MainController@updateDepartment');
Route::get('/getAll', 'MainController@getAll');
Route::get('/getAllEmployees', 'MainController@getAllEmployees');
Route::delete('/deleteEmployee/{id}', 'MainController@deleteEmployee');
Route::delete('/deleteDepartment/{id}', 'MainController@deleteDepartment');
