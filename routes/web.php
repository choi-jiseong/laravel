<?php

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

Route::get('/posts/create', [PostController::class, 'create'])/*->middleware(['auth'])*/; //로그인하면 원래 요청했던 곳으로 간다
//Route::get('/create', 'PostController@create');

Route::post('/posts/store', [PostController::class, 'store'])/*->middleware(['auth'])*/->name('posts.store');

Route::get('/posts/index', [PostController::class, 'index'])->name('posts.index');

Route::get('/posts/show/{id}', [PostController::class, 'show'])->name('posts.show');

Route::get('/posts/edit', [PostController::class, 'edit'])->name('posts.edit');