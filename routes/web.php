<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Models\Post;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

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

Route::get('/home', function () {
    return view('post.index');
})->name('home');

Route::get('/about', function () {
    return view('post.about');
})->name('about');

// Route::get('/welcome', function () {

//     return view('welcome');
// });

Route::get('/', function () {
    return view('post.index');
})->middleware('auth');

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/search', 'App\Http\Controllers\PostController@search')->name('search')->middleware('auth');

Route::resource('/post','App\Http\Controllers\PostController');

// Route::get('/perma',function () {


//     //     // $role = Role::findOrFail(3);
// //     // $role->givePermissionTo(['view models','edit models']);

//     $user = User::findOrFail(2);
//     $user->assignRole(['viewer']);
// //     $user = User::findOrFail(1);
// //     $user->givePermissionTo('view models');

// // $user = User::findOrFail(2);
// // $user->revokePermissionTo('view models');

// // return 'hello';
//  });

Route::get('/create-post', function () {

    Post::create(['title'=>'Java', 'description'=>'Java Post']);
    Post::create(['title'=>'PHP', 'description'=>'PHP Post']);
    Post::create(['title'=>'Dwain', 'description'=>'Dwain Post']);
    Post::create(['title'=>'Hello World', 'description'=>'Hello World Post']);
    Post::create(['title'=>'Today', 'description'=>'Today Post']);

});
