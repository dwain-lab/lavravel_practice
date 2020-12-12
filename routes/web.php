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
use App\Models\Phone;
use Illuminate\Support\Facades\DB;

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

Auth::routes();

// Route::get('/phone', 'App\Http\Controllers\PhoneController');

// Route::group(['middleware' => ['verified']], function () {

    Route::get('/search', 'App\Http\Controllers\PostController@search')->name('search');

    Route::get('/search-phone', 'App\Http\Controllers\PhoneController@searchPhone')->name('search-phone');

    Route::get('/search-service', 'App\Http\Controllers\ServiceController@searchService')->name('search-service');

    Route::get('/phone_service', 'App\Http\Controllers\PhoneController@listPhoneService')->name('phone_service.index');

    Route::post('/phone_service/{phone}/{service}/destroy', 'App\Http\Controllers\PhoneController@destroyPhoneService')->name('phone_service.destroy');

    // Route::get('/phone_service/destroy', 'App\Http\Controllers\PhoneController@destroyPhoneService')->name('phone_service.destroy');

    Route::resource('/post','App\Http\Controllers\PostController');

    Route::resource('/phone', 'App\Http\Controllers\PhoneController');

    Route::resource('/service', 'App\Http\Controllers\ServiceController');
// });


Route::get('syncNow', function () {

    // $phone = Phone::find(6);
    // dd($phone->services);
    // foreach ($phone->services as $service) {
    //     echo $service->name; // This will echo out the role name
    // }

    // $phone = DB::table('phones')
    //     ->join('phone_service', 'phones.id', '=', 'phone_service.phone_id')
    //     ->join('services', 'services.id', '=', 'phone_service.service_id')
    //     ->select('phones.number', 'services.name', 'phone_service.updated_at')
    //     ->get();

    //     dd($phone);

    //     foreach($phone as $key => $value) {
    //         echo $value->number." ".$value->name;
    //         echo "\n";
    //     }

    $phones = Phone::join('phone_service', 'phones.id', '=', 'phone_service.phone_id')
        ->join('services', 'services.id', '=', 'phone_service.service_id')
        ->get(['phones.number', 'services.name', 'phone_service.updated_at']);

    dd($phones);

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
