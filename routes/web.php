<?php
use Illuminate\Support\Facades\Route;
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
Route::post('comments', 'CommentController@store')->name('comments');
Route::post('storeReply','Replycontroller@store')->name('storeReply');




Route::get('contact', 'ContactFormController@create');
Route::post('contact','ContactFormController@store');

Route::get('search','FrontController@getSearch');

Route::get('latest','FrontController@getLatest');

Route::get('category/{id}/{slug}','FrontController@getCategory');
// route('postCategory',['id'=>$id,'slug'=>$slug])

Route::get('article/{slug}','FrontController@getArticle');

Route::get('/','FrontController@getIndex');
//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
