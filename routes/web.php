<?php

use App\Http\Controllers\ChartController;
use App\Http\Controllers\PostController;
use App\Models\Post;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';


Route::post('/posts/comment', [PostController::class, 'comment'])->name('posts.comment');

Route::get('/posts/search', [PostController::class, 'search'])->name('posts.search');

Route::get('/chart/index', [ChartController::class, 'index'])->name('chart.index');

Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');/*->middleware(['auth'])*/; //로그인하면 원래 요청했던 곳으로 간다
//Route::get('/create', 'PostController@create');

Route::post('/posts/store', [PostController::class, 'store'])/*->middleware(['auth'])*/->name('posts.store');

Route::get('/posts/index', [PostController::class, 'index'])->name('posts.index');

Route::get('/posts/show/{id}', [PostController::class, 'show'])->name('posts.show');

Route::get('/posts/myIndex', [PostController::class, 'myIndex'])->name('posts.myIndex');

Route::get('/posts/{post}', [PostController::class, 'edit'])->name('posts.edit');

Route::put('/posts/{id}', [PostController::class, 'update'])/*->middleware(['auth'])*/->name('posts.update');

Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.delete');




