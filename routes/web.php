<?php
Auth::routes();

Route::get('/', 'IndexController@index')->name('index');
Route::put('/weights', 'IndexController@weights')->name('weights');
Route::get('/get-cities-from', 'IndexController@getCitiesFrom')->name('get.cities.from');
Route::get('/get-cities-to', 'IndexController@getCitiesTo')->name('get.cities.to');
Route::get('/InfoWinLineData', 'IndexController@InfoWinLineData')->name('post.InfoWinLineData');
Route::get('/cityCheck', 'IndexController@cityCheck')->name('get.cityCheck');

Route::get('/register', function () {
   return redirect('/admin/index');
});

Route::group(['namespace' => 'Auth'], function() {
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login');
    Route::get('logout', 'LoginController@logout')->name('logout');
});

Route::group([
        'prefix' => 'admin',
        'as' => 'admin.',
        'namespace' => 'Admin',
        'middleware' => ['auth', 'can:administrator']
    ], function () {
    Route::get('/', 'IndexController@index')->name('index');
    Route::resource('car', 'CarController');
    Route::resource('city', 'CityController');
    Route::get('route/autocomplete', 'RouteController@autocomplete')->name('route.autocomplete');
    Route::resource('route', 'RouteController');
    Route::resource('/manager', 'ManagerController');
});