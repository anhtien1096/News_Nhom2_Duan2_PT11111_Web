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

Route::get('/', function () {
    return view('home');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

// Users CP
Route::group(['middleware' => 'auth'], function () {
	Route::group(['prefix'=>'user'], function(){
		Route::get('/', ['as'=>'user.getProfile','uses'=>'HomeController@getProfile']);
		Route::get('/{id}', ['as'=>'user.getProfileid','uses'=>'HomeController@getProfileid']);
    });
});

// Admin CP
Route::group(['middleware' => 'isroleadmin'], function () {
    Route::group(['prefix'=>'admin'], function(){
    	Route::get('/', ['as'=>'admin.getDashboard','uses'=>'Admin\DashboardController@index']);

    	Route::get('users', ['as'=>'admin.usersList','uses'=>'Admin\UsersController@index']);
    	Route::get('users/setadmin/{id}', ['as'=>'admin.users.setadmin','uses'=>'Admin\UsersController@setadmin']);
    	Route::get('users/delete/{id}', ['as'=>'admin.users.delete','uses'=>'Admin\UsersController@delete']);

    	Route::resource('categories', 'Admin\CategoriesController');
	});


});

// Show not Admin
Route::get('unauthorized',function(){
	return view('errors.404');
});

// Login Socials Routes
Route::get('auth/{provider}', 'Auth\RegisterController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\RegisterController@handleProviderCallback');