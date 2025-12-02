<?php 

use App\Http\Route;

Route::get('/',                     'HomeController@index');

Route::post('/admin/create',        'AdminController@create');
Route::post('/admin/login',         'AdminController@login');
Route::get('/admin/index',          'AdminController@index');
Route::put('/admin/update',         'AdminController@update');
Route::delete('/admin/{id}/delete', 'AdminController@remove');