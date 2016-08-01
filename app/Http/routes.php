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

    # Authentication Routes
    Route::get('/auth0/callback', '\Auth0\Login\Auth0Controller@callback');
    Route::get('/logout', function () {
        Auth::logout();
        return redirect('');
    });


    # Client UI Routes
    Route::get('/', 'ClientController@index');


    # Admin UI Routes
    Route::group(['namespace' => 'Admin'], function () {
        Route::get('/admin/', 'AdminController@clientList');
        Route::get('/admin/summary/{id}', 'AdminController@summary');
        Route::get('/admin/history/{id}', 'AdminController@history');
        Route::get('/admin/settings/{id}', 'AdminController@settings');
    });

    Route::get('/upload', 'UploadController@client_upload');
    Route::post('/process_upload', 'UploadController@upload_process');


});
