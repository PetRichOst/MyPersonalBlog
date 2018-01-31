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

Route::get('/', 'HomeController@index')->name('post.index');
Route::get('/post/{slug}', 'HomeController@show')->name('post.show');
Route::get('/tag/{slug}', 'HomeController@tag')->name('tag.show');
Route::get('/category/{slug}', 'HomeController@category')->name('category.show');
Route::post('/subscribe', "SubsController@subscribe");
Route::get('/verify/{token}', "SubsController@verify");

Route::group(['middleware' => 'auth'], function (){
    Route::get('/logout', "AuthController@logout");
    Route::get('/profile', "AuthController@profileShow");
    Route::put('/profileUpdate', "AuthController@profileUpdate")->name('profile.update');
    Route::post('/comment', "AuthController@comment")->name('post.comment');
});

Route::group(['middleware' => 'guest'], function (){
    Route::get('/register', "AuthController@registerForm");
    Route::post('/register', "AuthController@register");
    Route::get('/login', "AuthController@loginForm");
    Route::post('/login', "AuthController@login");
});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'admin'],function(){
    Route::get('/','DashboardController@index');
    Route::resource('/categories','CategoriesController');
    Route::resource('/tags','TagsController');
    Route::resource('/users','UsersController');
    Route::resource('/posts','PostsController');
    Route::get('/comments','CommentsController@index');
    Route::get('/comments/toggle/{id}','CommentsController@toggle');
    Route::get('/comments/delete/{id}','CommentsController@delete');
    Route::resource('/subscribers','SubscriptionController');

});

