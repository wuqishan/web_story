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

// 登陆
Route::get('/admin/user/login', 'Admin\UserController@login')->name('admin.user.login');
Route::post('/admin/user/dologin', 'Admin\UserController@doLogin')->name('admin.user.do_login');
Route::get('/admin/user/logout', 'Admin\UserController@logout')->name('admin.user.logout');

Route::group(['namespace' => 'Home', 'middleware' => 'app.servicing'], function () {
    Route::get('/', 'IndexController@index')->name('index');

    Route::get('/article/{category_id}', 'ArticleController@index')->name('article-index');
    Route::get('/chapter/{unique_code}', 'ArticleController@chapter')->name('chapter-list');
    Route::get('/detail/{category_id}/{unique_code}', 'ArticleController@detail')->name('chapter-detail');

    Route::get('/updateView', 'ArticleController@updateView')->name('update-view');
});

Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'login.check'], function () {


    Route::get('/index', 'IndexController@index')->name('admin.index');

    // 附件
//    Route::get('upload/delete/{id}', 'UploadController@delete')->name('upload.delete');
//    Route::post('upload', 'UploadController@upload')->name('upload');

    // 分类
    Route::resource('category', 'CategoryController', [
        'parameters' => ['category' => 'category_id']
    ]);

    // 友情链接
    Route::resource('friend_link', 'FriendLinkController', [
        'parameters' => ['friend_link' => 'friend_link_id']
    ]);

    Route::resource('common_article', 'CommonArticleController', [
        'parameters' => ['common_article' => 'common_article_id']
    ]);

    // 书本
    Route::get('/book', 'BookController@index')->name('book.index');
    Route::get('/book/create', 'BookController@create')->name('book.create');
    Route::post('/book/store', 'BookController@store')->name('book.store');
    Route::get('/book/{book_id}/edit', 'BookController@edit')->name('book.edit');
    Route::put('/book/{book_id}/update', 'BookController@update')->name('book.update');
    Route::post('/book/finished', 'BookController@updateFinished')->name('book.update.finished');

    // 章节
    Route::get('/chapter/{book_unique_code}', 'ChapterController@index')->name('chapter.index');
//    Route::get('/chapter/{chapter_id}/{category_id}', 'ChapterController@edit')->name('chapter.edit');
    Route::post('/chapter/update', 'ChapterController@update')->name('chapter.update');
    Route::post('/chapter/delete/all', 'ChapterController@deleteAllChapter')->name('chapter.delete.all');

    // 内容
    Route::post('/content/update', 'ChapterContentController@updateContent')->name('content.update');
    Route::get('/content/detail/{content_id}/{category_id}', 'ChapterContentController@detail')->name('content.detail');

    // 检测信息
    Route::get('/check_info', 'CheckInfoController@index')->name('check_info.index');
    Route::post('/check_info/delete', 'CheckInfoController@delete')->name('check_info.delete');
    Route::post('/check_info/update', 'CheckInfoController@update')->name('check_info.update');

    // 图片检测
    Route::get('/image', 'ImageController@index')->name('image.index');
    Route::post('/image/check', 'ImageController@check')->name('image.check');
    Route::post('/image/update', 'ImageController@update')->name('image.update');

    // 设置
    Route::get('/setting/banner', 'SettingController@banner')->name('setting.banner');
    Route::post('/setting/banner', 'SettingController@banner')->name('setting.banner.post');
    Route::delete('/setting/delete', 'SettingController@delete')->name('setting.delete');
    Route::get('/setting/logo', 'SettingController@logo')->name('setting.logo');
    Route::post('/setting/logo', 'SettingController@logo')->name('setting.logo.post');
    Route::get('/setting/seo', 'SettingController@seo')->name('setting.seo');
    Route::post('/setting/seo', 'SettingController@seo')->name('setting.seo.post');
    Route::post('/setting/reset_cache', 'SettingController@resetCache')->name('setting.reset_cache');
});