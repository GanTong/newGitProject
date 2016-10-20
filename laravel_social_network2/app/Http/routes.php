<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});



Route::group(['middleware' => 'web'], function () {


Route::auth();

Route::any('/home', ['as' => 'home', 'uses' => 'HomeController@index']);


Route::post('/createpost', [

	'uses' => 'PostController@postCreatePost',

	'as' => 'post.create',

	'middleware' => 'auth'

	]);

Route::any('/home', ['as' => 'home', 'uses' => 'PostController@showPost']);

Route::get('/delete-post/{post_id}', [

	'uses' => 'PostController@getDeletePost',

	'as' => 'post.delete',

	'middleware' => 'auth'

	]);

Route::get('/account', ['as' => 'account', 'uses' => 'PostController@getAccount']);

Route::post('/updateaccount', ['uses' => 'PostController@postSaveAccount', 'as' => 'account.save']);

Route::get('/userimage/{filename}', ['uses' => 'PostController@getUserImage', 'as' => 'account.image']);

});