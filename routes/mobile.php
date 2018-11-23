<?php

/*
|--------------------------------------------------------------------------
| Mobile Routes
|--------------------------------------------------------------------------
*/


/*********************************** 手机端路由 *************************************/
Route::group(['namespace' => 'Mobile', 'middleware' => 'app.servicing'], function () {
    Route::get('/', 'IndexController@index')->name('index');

    Route::get('/article/{category_id}', 'ArticleController@index')->name('article-index');
    Route::get('/chapter/{unique_code}', 'ArticleController@chapter')->name('chapter-list');
    Route::get('/detail/{category_id}/{unique_code}', 'ArticleController@detail')->name('chapter-detail');

    Route::get('/updateView', 'ArticleController@updateView')->name('update-view');
});
