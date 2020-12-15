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
use App\Http\Controllers\PhoneController;
use App\Models\Phone;

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
| Middleware Verified only
|--------------------------------------------------------------------------
|
| Only users with verified accounts can access this section
|
*/

Auth::routes();

// Route::get('/phone', 'App\Http\Controllers\PhoneController');

Route::group(['middleware' => ['verified']], function () {

    Route::get('/search', 'App\Http\Controllers\PostController@search')->name('search');

    Route::get('/search-phone', 'App\Http\Controllers\PhoneController@searchPhone')->name('search-phone');

    Route::get('/search-service', 'App\Http\Controllers\ServiceController@searchService')->name('search-service');

    Route::get('/search-phone_service', 'App\Http\Controllers\PhoneController@searchPhoneService')->name('search-phone_service');

    Route::get('/phone_service', 'App\Http\Controllers\PhoneController@listPhoneService')->name('phone_service.index');

    Route::post('/phone_service/{phone}/{service}/destroy', 'App\Http\Controllers\PhoneController@destroyPhoneService')->name('phone_service.destroy');

    Route::post('/phone_service/{phone}/destroyAll', 'App\Http\Controllers\PhoneController@phone_serviceDeleteAllServiceAttached')->name('phone_service.destroyAll');

    Route::get('/phone_service/create', 'App\Http\Controllers\PhoneController@createPhoneService')->name('phone_service.create');

    Route::post('/phone_service', 'App\Http\Controllers\PhoneController@phone_serviceStore')->name('phone_service.store');

    Route::get('/phone_service/{phone}/edit', 'App\Http\Controllers\PhoneController@phone_serviceEdit')->name('phone_service.edit');

    Route::put('/phone_service/{phone}', 'App\Http\Controllers\PhoneController@phone_serviceUpdate')->name('phone_service.update');

    Route::resource('/post','App\Http\Controllers\PostController');

    Route::resource('/phone', 'App\Http\Controllers\PhoneController');

    Route::resource('/service', 'App\Http\Controllers\ServiceController');

    Route::get('phone-export', 'App\Http\Controllers\PhoneController@fileExport')->name('phone.file-export');

    Route::get('/phone-import', 'App\Http\Controllers\PhoneController@phoneImportUpload')->name('phone.file-import');

    Route::post('/phone-import', 'App\Http\Controllers\PhoneController@phoneImportStore')->name('phone.import-store');

    Route::get('service-export', 'App\Http\Controllers\ServiceController@serviceExport')->name('service.file-export');

    Route::get('/service-import', 'App\Http\Controllers\ServiceController@serviceImportUpload')->name('service.file-import');

    Route::post('/service-import', 'App\Http\Controllers\ServiceController@serviceImportStore')->name('service.import-store');

});

/*
|--------------------------------------------------------------------------
| Middleware Auth Verified only
|--------------------------------------------------------------------------
|
| Only users with login accounts can access this section
|
*/

// Route::group(['middleware' => ['auth']], function () {

    Route::get('/', function () {
        return view('home');
    });

    Route::get('/home', function () {
        return view('home');
    })->name('home');

    Route::get('/about', function () {
        return view('about');
    })->name('about')->middleware('verified');
// });

/*
|--------------------------------------------------------------------------
| Auth Routes Defined
|--------------------------------------------------------------------------
|
| This defined because the function to assign POST is not working when Auth::routes('TRUE') is set.  When done this way the POST automatice assignment works
|
*/

Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    ->middleware(['auth', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

Route::get('/verify-email', [EmailVerificationPromptController::class, '__invoke'])
    ->middleware('auth')
    ->name('verification.notice');

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


Route::get('/phonesss', function() {

    $phone =  Phone::findOrFail(1);

    // $phone->services()->detach([6,2]);
    $phone->services()->syncwithoutDetaching([1]);


});
