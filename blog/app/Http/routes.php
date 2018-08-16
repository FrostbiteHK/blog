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
Route::group(['middleware' => ['web']], function (){

    Route::get('/', function () {
    return view('welcome');
});

    Route::get('/admin/getcode', 'Admin\LoginController@getCode');
    Route::get('/admin/code', 'Admin\LoginController@code');
});


//web中间件从laravel 5.2.27版本以后默认全局加载，不需要自己手动载入，如果自己手动重复载入，会导致session无法加载的情况
Route::group(['middleware' => ['admin.login'],'prefix' => 'admin','namespace'=> 'Admin'], function (){

    Route::get('index', 'IndexController@index');
    Route::get('info', 'IndexController@info');
    Route::get('quit', 'LoginController@quit');
    Route::any('pass', 'IndexController@pass');
    Route::any('login', 'LoginController@login');

});
