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

Route::get('login', 'Account\LoginController@getLogin')->name('login');
Route::post('login', 'Account\LoginController@postLogin');

Route::group([
    'middleware' => ['web', 'auth'],
], function () {
    Route::get('/', "HomeController@index");
    Route::any('upload_img', "CommonController@uploadImg");
    Route::group(['namespace' => 'Account'], function () {
        Route::get('logout', 'LoginController@getLogout')->name('logout');
        Route::match(['get', 'post'], 'account/profile', 'ProfileController@setting');
    });
    Route::group(['middleware' => 'permission'], function () {

        Route::group(['namespace' => 'System', 'prefix' => 'system'], function () {
            Route::get('role/index', "RoleController@index")->name('role.index');

            Route::match(['get', 'post'], 'role/create', "RoleController@create")->name('role.create');
            Route::match(['get', 'post'], 'role/edit', "RoleController@edit")->name('role.edit');
            Route::get('role/permissions', "RoleController@getPermissions")->name('role.permissions');
            Route::post('role/permissions', "RoleController@postPermissions");
            Route::post( 'role/switch_status', "RoleController@switch_status")->name('role.switch_status');
            Route::post( 'role/delete', "RoleController@delete")->name('role.delete');

            Route::get('user/index', "UserController@index")->name('user.index');
            Route::match(['get', 'post'], 'user/create', "UserController@create")->name('user.create');
            Route::match(['get', 'post'], 'user/edit', "UserController@edit")->name('user.edit');
            Route::post( 'user/switch_status', "UserController@switch_status")->name('user.switch_status');
            Route::post( 'user/delete', "UserController@delete")->name('user.delete');

            Route::get('permission/index', "PermissionController@index")->name('permission.index');
            Route::match(['get', 'post'], 'permission/create', "PermissionController@create")->name('permission.create');
            Route::match(['get', 'post'], 'permission/edit', "PermissionController@edit")->name('permission.edit');
            Route::post('permission/sort', "PermissionController@sort")->name('permission.sort');
            Route::post( 'permission/switch_status', "PermissionController@switch_status")->name('permission.switch_status');
            Route::post( 'permission/delete', "PermissionController@delete")->name('permission.delete');
            Route::get('operatelog/index', 'OperateLogController@index');
        });

        //文章模块
        Route::group(['namespace' => 'Content', 'prefix' => 'content'], function () {
            //文章管理
            Route::get('article/index', "ArticleController@index")->name('article.index');
            Route::match(['get', 'post'], 'article/create', "ArticleController@create")->name('article.create');
            Route::match(['get', 'post'], 'article/edit', "ArticleController@edit")->name('article.edit');
            Route::post('article/delete', "ArticleController@delete")->name('article.delete');
            Route::post('article/switch_status', "ArticleController@switch_status")->name('article.switch_status');
            Route::post('article/recommend', "ArticleController@recommend")->name('article.recommend');
            Route::post('article/top', "ArticleController@top")->name('article.top');

            //分类管理
            Route::get('category/index', "CategoryController@index")->name('category.index');
            Route::match(['get', 'post'], 'category/create', "CategoryController@create")->name('category.create');
            Route::match(['get', 'post'], 'category/edit', "CategoryController@edit")->name('category.edit');
            Route::post('category/operation', "CategoryController@operation")->name('category.operation');
            Route::post('category/sort', "CategoryController@sort")->name('category.sort');
            //分类管理
            Route::get('slide/index', "SlideController@index")->name('category.index');
            Route::match(['get', 'post'], 'slide/create', "SlideController@create")->name('slide.create');
            Route::match(['get', 'post'], 'slide/edit', "SlideController@edit")->name('slide.edit');
            Route::post('slide/operation', "SlideController@operation")->name('category.operation');
            Route::post('slide/delete', "SlideController@delete")->name('category.delete');
            Route::post('slide/sort', "SlideController@sort")->name('category.sort');
        });
        Route::group(['namespace' => 'User', 'prefix' => 'user'], function () {
            //会员管理
            Route::get('index', "IndexController@index")->name('user.index');
            Route::post('index/operation', "IndexController@operation")->name('user.operation');
        });
    });


});
