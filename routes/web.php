<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\TestController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/test', function () {
    return 'Welcome !!!';
});

Route::get('/test2', function () {
    return view('test.index');  //test/index 와 test.index는 같다
});

Route::get('/test3', function () {
    // 비지니스 로직 처리...
    $name = '홍길동';
    $age = 20;
    // return view('test.show', ['name'=> $name, 'age' => 10]); //데이터보내주기
    return view('test.show', compact('name', 'age')); //데이터 보내주기2
});

Route::get('/test4', [TestController::class, 'index' ]); //클래스 잡고 ctrl+i 해서 tab키 누르면 import된다


Route::get('/posts/create', [PostController::class, 'create']);
//Route::get('/create', 'PostController@create');

Route::get('/posts/edit', [PostController::class, 'edit']);
//Route::get('/create', 'PostController@edit');

Route::get('/posts/show', [PostController::class, 'show']);
//Route::get('/create', 'PostController@show');

Route::get('/posts/index', [PostController::class, 'index']);
//Route::get('/create', 'PostController@index');
