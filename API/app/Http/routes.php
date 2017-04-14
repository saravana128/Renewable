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

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: PUT, POST, GET, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Requested-With');
header('Access-Control-Allow-Credentials: true');

Route::get('/index', ['uses' => 'AuthenticationsController@index','as' =>'api.info']);
Route::post('/auth /signup',['uses' =>'AuthenticationsController@Signup', 'as' => 'auth.signup']);
Route::post('/auth/verify', ['uses' => 'AuthenticationsController@verify', 'as' =>'auth.verify']);
Route::post('/auth/login', ['uses' => 'UsersController@login', 'as' =>'users.login']);
Route::post('/index', ['uses' => 'AuthensController@index', 'as' => 'api.info']);
Route::post('/auth/signup', ['uses' => 'AuthensController@Signup', 'as' =>'api.info']);
Route::post('/auth/verify', ['uses' => 'AuthensController@verify', 'as' => 'auth.verify']);
Route::post('/auth/login', ['uses' => 'AuthensController@login', 'as' => 'auth.verify']);


Route::group(['middleware' => ['api', 'auth.api']], function ()
{
    Route::post('/details', ['uses' => 'UsersController@details', 'as' => 'users.details']);
   
   Route::post('/location', ['uses' => 'UsersController@store_location', 'as' => 'users.store_location']);

   Route::post('/details', ['uses' =>'SolarsController@details', 'as' => 'user.details']);

   Route::post('/location', ['uses' => 'SolarsController@details', 'as' => 'user.store_location']);
    
});

