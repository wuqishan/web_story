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

Route::get('/user/login', 'UserController@login')->name('login');
Route::post('/user/dologin', 'UserController@doLogin')->name('do_login');

Route::group(['namespace' => 'Home'], function () {
    Route::get('/', 'IndexController@index')->name('index');

    Route::get('/article/{category_id}', 'ArticleController@index')->name('article-index');
    Route::get('/chapter/{unique_code}', 'ArticleController@chapter')->name('chapter-list');
    Route::get('/detail/{unique_code}', 'ArticleController@detail')->name('chapter-detail');

    Route::get('/updateView', 'ArticleController@updateView')->name('update-view');
});

Route::group(['namespace' => 'Update', 'prefix' => 'update', 'middleware' => ['check.update']], function () {
    Route::get('/book', 'BookController@index')->name('update-book-index');
    Route::get('/chapter', 'ChapterController@index')->name('update-chapter-index');
    Route::get('/chapter/update', 'ChapterController@updateMethod')->name('update-chapter-update');
});