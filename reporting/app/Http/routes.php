<?php

    Route::group(['namespace' => 'Auth'], function () {
        Route::get('/', ['as' => 'login_root', 'uses' => 'AuthController@getLogin']);
        Route::post('login', ['as' => 'login', 'uses' => 'AuthController@postLogin']);
        Route::get('logout', ['as' => 'logout', 'uses' => 'AuthController@getLogout']);
    });
    Route::group(['middleware' => 'auth'], function () {
        Route::group(['namespace' => 'Home'], function () {
            Route::get('home', ['as' => 'home', 'uses' => 'HomeController@index']);
            Route::post('fileParse', ['as' => 'home', 'uses' => 'HomeController@getFileRequest']);
        });
        Route::group(['namespace' => 'Reports'], function() {
            Route::get('report/{date}/{file}', ['as' => 'main-report', 'uses' => 'ReportsController@index']);
            Route::post('/getReport', ['as' => 'get-report', 'uses' => 'ReportsController@getReport']);
        });
    });