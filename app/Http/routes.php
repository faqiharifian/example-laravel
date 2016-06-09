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

Route::get('/', 'HomeController@index');

Route::bind('product', function($id){
    return \App\Models\Product::whereId($id)->first();
});

Route::get('/products', 'ProductController@index');
Route::get('/products/search', 'ProductController@search');

Route::get('/products/{product}', [
    'middleware' => 'auth',
    'uses' => 'ProductController@show'
]);

Route::get('/about-us', 'CompanyInfoController@aboutUs');
Route::get('/contact-us', 'CompanyInfoController@contactUs');
Route::get('/policies', 'CompanyInfoController@policies');
Route::post('/contact-us', 'CompanyInfoController@postContactUs');
Route::get('/custom-furniture', 'ProductController@custom');
Route::post('/custom-furniture-image', 'ProductController@postCustomImage');
Route::post('/remove-custom-furniture-image', 'ProductController@removeCustomImage');
Route::post('/custom-furniture', 'ProductController@postCustom');

Route::get('/admin', 'Admin\AuthController@login');
Route::post('/admin', 'Admin\AuthController@authenticate');
Route::get('/admin/reset', 'Auth\PasswordController@getEmail');
Route::post('/admin/reset', 'Auth\PasswordController@postEmail');
Route::get('/admin/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('/admin/reset/{token}', 'Auth\PasswordController@postReset');

Route::get('/login', 'CustomerAuthController@login');
Route::post('/login', 'CustomerAuthController@authenticate');
Route::post('/register', 'CustomerAuthController@store');
Route::get('/logout', 'CustomerAuthController@logout');
Route::get('/redirect/{provider}', 'CustomerAuthController@redirect');
Route::get('/callback/{provider}', 'CustomerAuthController@callback');

Route::group(['middleware' => 'admin'], function(){
    Route::get('/admin/dashboard', 'Admin\HomeController@index');

    Route::post('/admin/catalog', 'Admin\HomeController@postCatalog');

    Route::get('/admin/products', 'Admin\ProductController@index');
    Route::get('/admin/products/set-page-size', 'Admin\ProductController@setPageSize');
    Route::get('/admin/products/create', 'Admin\ProductController@create');
    Route::post('/admin/products/create', 'Admin\ProductController@store');
    Route::get('/admin/products/{product}', 'Admin\ProductController@show');
    Route::get('/admin/products/{product}/edit', 'Admin\ProductController@edit');
    Route::post('/admin/products/{product}/edit', 'Admin\ProductController@update');
    Route::get('/admin/products/{product}/delete', 'Admin\ProductController@destroy');

    Route::bind('customProduct', function($id){
        return \App\Models\CustomProduct::whereId($id)->first();
    });
    Route::get('/admin/custom-product', 'Admin\CustomProductController@index');
    Route::get('/admin/custom-product/{customProduct}', 'Admin\CustomProductController@show');
    Route::get('/admin/custom-product/{customProduct}/delete', 'Admin\CustomProductController@destroy');

    Route::bind('user', function($id){
        return \App\Models\User::whereId($id)->first();
    });
    Route::get('/admin/users', 'Admin\UserController@index');
    Route::get('/admin/users/create', 'Admin\UserController@create');
    Route::post('/admin/users/create', 'Admin\UserController@store');
    Route::get('/admin/users/{user}', 'Admin\UserController@show');
    Route::post('/admin/users/{user}/edit', 'Admin\UserController@update');
    Route::get('/admin/users/{user}/password', 'Admin\UserController@getPassword');
    Route::post('/admin/users/{user}/password', 'Admin\UserController@postPassword');
    Route::get('/admin/users/{user}/delete', 'Admin\UserController@destroy');

    Route::get('/admin/slider', 'Admin\SliderController@index');
    Route::post('/admin/slider/store', 'Admin\SliderController@store');
    Route::post('/admin/slider/update', 'Admin\SliderController@update');
    Route::get('/admin/slider/toggle', 'Admin\SliderController@toggle');
    Route::get('/admin/slider/delete', 'Admin\SliderController@destroy');

    Route::get('/admin/logout', 'Admin\AuthController@logout');
});

Route::get('/upload', function(){
	return view('upload');
});