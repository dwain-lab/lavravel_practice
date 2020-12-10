<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Models\Post;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;

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

/*
|--------------------------------------------------------------------------
| Middleware Verifed only
|--------------------------------------------------------------------------
|
| Only users with verifed accounts can access this section
|
*/

Route::group(['middleware' => ['verified']], function () {

    Route::get('/search', 'App\Http\Controllers\PostController@search')->name('search');

    Route::resource('/post','App\Http\Controllers\PostController');


});

Route::group(['middleware' => ['auth']], function () {

    Route::get('/', function () {
        return view('post.index');
    });

    Route::get('/home', function () {
        return view('post.index');
    })->name('home');

    Route::get('/about', function () {
        return view('post.about');
    })->name('about')->middleware('verified');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/create-post', function () {

    Post::create(['title'=>'Java', 'description'=>'Java Post']);
    Post::create(['title'=>'PHP', 'description'=>'PHP Post']);
    Post::create(['title'=>'Dwain', 'description'=>'Dwain Post']);
    Post::create(['title'=>'Hello World', 'description'=>'Hello World Post']);
    Post::create(['title'=>'Today', 'description'=>'Today Post']);
});

Route::get('/welcome', function () {
    $user = User::findOrFail(1);
    $user->assignRole(['viewer']);
   //return view('welcome');
});

Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    ->middleware(['auth', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

// Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
//     ->middleware(['auth', 'throttle:6,1'])
//     ->name('verification.send');

// Route::get('/verify-email', [EmailVerificationPromptController::class, '__invoke'])
//     ->middleware('auth')
//     ->name('verification.notice');





Route::resource('phone', 'PhoneController');


Route::resource('phone', 'PhoneController');


Route::resource('phone', 'PhoneController');


Route::resource('phone', 'PhoneController');


Route::resource('phone', 'PhoneController');


Route::resource('phone', 'PhoneController');


Route::resource('phone', 'PhoneController');


Route::resource('phone', 'PhoneController')->only('index', 'show');


Route::resource('phone', 'PhoneController');


Route::resource('phone', 'PhoneController')->except('create');


Route::resource('phone', 'PhoneController')->except('create', 'store');


Route::resource('phone', 'PhoneController')->only('index', 'show');


Route::resource('phone', 'PhoneController')->except('destroy');


Route::resource('phone', 'PhoneController')->only('index', 'show');


Route::resource('phone', 'PhoneController')->except('destroy');


Route::resource('phone', 'PhoneController')->except('update', 'destroy');


Route::resource('phone', 'PhoneController')->except('create', 'update', 'destroy');


Route::resource('phone', 'PhoneController')->only('index', 'store', 'show');


Route::resource('phone', 'PhoneController')->only('index', 'show');


Route::resource('phone', 'PhoneController')->only('index', 'show', 'edit');


Route::resource('phone', 'PhoneController')->only('index');


Route::resource('phone', 'PhoneController')->only('index', 'store');


Route::resource('phone', 'PhoneController')->only('index', 'show');


Route::resource('phone', 'PhoneController')->only('index', 'show', 'edit');


Route::resource('phone', 'PhoneController')->except('create', 'store', 'destroy');


Route::resource('phone', 'PhoneController')->except('create', 'store', 'destroy');


Route::resource('phone', 'PhoneController')->except('create', 'store', 'destroy');


Route::resource('phone', 'PhoneController')->except('create', 'store', 'destroy');


Route::resource('phone', 'PhoneController')->except('create', 'store', 'destroy');


Route::resource('phone', 'PhoneController')->except('create', 'store', 'destroy');


Route::resource('phone', 'PhoneController')->except('create', 'store', 'destroy');


Route::resource('phone', 'PhoneController')->except('create', 'store', 'destroy');


Route::resource('phone', 'PhoneController')->except('create', 'store', 'destroy');


Route::resource('phone', 'PhoneController')->except('store', 'destroy');


Route::resource('phone', 'PhoneController')->except('store', 'destroy');


Route::resource('phone', 'PhoneController')->except('store', 'destroy');


Route::resource('phone', 'PhoneController')->except('store', 'destroy');


Route::resource('phone', 'PhoneController')->except('store', 'destroy');


Route::resource('phone', 'PhoneController')->except('store', 'destroy');


Route::resource('phone', 'PhoneController')->except('store', 'destroy');


Route::resource('phone', 'PhoneController')->except('destroy');


Route::resource('phone', 'PhoneController');


Route::resource('phone', 'PhoneController');

Route::resource('service', 'ServiceController');
