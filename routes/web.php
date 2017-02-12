<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'StudentController@show');
Route::post('/ListByRequest', 'StudentController@show');
Route::get('/students/{student}/edit', 'StudentController@preEdit');
Route::get('/students/{student}/EditStudent', 'StudentController@edit');
Route::get('/AddStudent', 'StudentController@add');
Route::get('/AddStudentForm', 'StudentController@addForm');
Route::post('/DeleteStudent', 'StudentController@delete');
Auth::routes();

Route::get('/home', 'HomeController@index');

/*
** From here on is for testing purposes
*/

Route::get('record', function() {
	return view('record');
});