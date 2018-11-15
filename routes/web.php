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
Route::get('/admin/admin/login', 'Admin\AdminController@login')->name('admin.admin.login');
Route::post('/admin/admin/dologin', 'Admin\AdminController@doLogin')->name('admin.admin.do_login');
Route::get('/admin/admin/logout', 'Admin\AdminController@logout')->name('admin.admin.logout');

Route::group(['namespace' => 'Home', 'middleware' => 'app.servicing'], function () {
    Route::get('/', 'IndexController@index')->name('index');

    Route::get('/article/{category_id}', 'ArticleController@index')->name('article-index');
    Route::get('/chapter/{unique_code}', 'ArticleController@chapter')->name('chapter-list');
    Route::get('/detail/{category_id}/{unique_code}', 'ArticleController@detail')->name('chapter-detail');

    Route::get('/updateView', 'ArticleController@updateView')->name('update-view');
});

Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin.login.check'], function () {


    Route::get('/index', 'IndexController@index')->name('admin.index');
    Route::get('/table', 'IndexController@table')->name('admin.table');

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

    Route::resource('author', 'AuthorController', [
        'parameters' => ['author' => 'author_id']
    ]);

    Route::resource('user', 'UserController', [
        'parameters' => ['user' => 'user_id']
    ]);

    // 书本
    Route::get('/book', 'BookController@index')->name('book.index');
    Route::get('/book/create', 'BookController@create')->name('book.create');
    Route::post('/book/store', 'BookController@store')->name('book.store');
    Route::get('/book/{book_id}/edit', 'BookController@edit')->name('book.edit');
    Route::put('/book/{book_id}/update', 'BookController@update')->name('book.update');
    Route::post('/book/finished', 'BookController@updateFinished')->name('book.update.finished');

    // 章节
    Route::get('/chapter/{book_unique_code}', 'ChapterController@index')->name('chapter.index');    // 书本点击过去的章节
    Route::get('/chapter/list/all', 'ChapterController@listAll')->name('chapter.list.all');    // 所有章节的列表
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

    // 书本导入log
    Route::get('/import_log/index', 'ImportLogController@index')->name('import_log.index');
    Route::get('/import_log/show/{import_log_id}', 'ImportLogController@show')->name('import_log.show');
});