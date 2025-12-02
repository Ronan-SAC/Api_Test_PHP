<?php 

use App\Http\Route;

Route::post('/admin/create',        'AdminController@create');
Route::post('/admin/login',         'AdminController@login');
Route::get('/admin/index',          'AdminController@index');
Route::get('/admin/show/{id}',         'AdminController@show');
Route::put('/admin/update/{id}', 'AdminController@update');
Route::delete('/admin/delete/{id}', 'AdminController@delete');