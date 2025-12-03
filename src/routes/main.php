<?php 

use App\Http\Route;
Route::post('/admin/login',         'AdminController@login');

Route::post('/admin/create/user',        'AdminController@create');
Route::post('/admin/create/student',    'AdminController@createStudent');
Route::post('/admin/create/classroom',  'AdminController@createClassroom');
Route::post('/admin/create/enrollments', 'AdminController@createEnrollments');
Route::post('/admin/create/attendance', 'AdminController@createAttendance');

Route::get('/admin/index',          'AdminController@index');
Route::get('/admin/index/teacher',  'AdminController@indexTeacher');
Route::get('/admin/index/student', 'AdminController@indexStudent');
Route::get('/admin/index/classroom', 'AdminController@indexClassroom');
Route::get('/admin/index/enrollments', 'AdminController@indexEnrollments');

Route::get('/admin/show/{id}',         'AdminController@show');
Route::put('/admin/update/{id}', 'AdminController@update');
Route::delete('/admin/delete/{id}', 'AdminController@delete');
