<?php
Auth::routes();

Route::get('/', 'IndexController@index')->name('index');

Route::get('/register', function () {
   return redirect('/admin/index');
});

Route::group(['namespace' => 'Auth'], function() {
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login');
    Route::get('logout', 'LoginController@logout')->name('logout');
});

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => 'auth'], function () {
    Route::resource('car', 'CarController');
    Route::resource('city', 'CityController');
});