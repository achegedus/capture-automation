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


Route::group(['middleware' => ['web']], function () {
    Route::get('/auth0/callback', '\Auth0\Login\Auth0Controller@callback');
    
    Route::get('/', 'TestController@index');
    Route::get('/admin/summary/{id}', 'AdminController@summary');
    Route::get('/admin/history/{id}', 'AdminController@history');
    Route::get('/admin/settings/{id}', 'AdminController@settings');
    Route::get('/testauth', 'TestController@auth');
    Route::get('/admin/', 'AdminController@clientList');
    
    
    Route::get('/logout', function () {
        Auth::logout();
        return redirect('');
    });
});
