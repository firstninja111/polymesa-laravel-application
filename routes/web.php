<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\FontController;
use App\Http\Controllers\Admin\DictionaryController;
use App\Http\Controllers\Admin\CryptoController;


use App\Http\Controllers\Customer\DashboardController;
use App\Http\Controllers\Customer\StatisticController;
use App\Http\Controllers\Customer\MediaController;
use App\Http\Controllers\Customer\ProfileController;




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


Auth::routes();

// ============= Guest Mode Routes ============= //
Route::get('/', [HomeController::class, 'root']);           // Guest Mode
Route::get('/donate', [HomeController::class, 'donate']);   // Guest Mode

Route::get('/faqs', [HomeController::class, 'faqs']);   // Guest Mode
Route::get('/license', [HomeController::class, 'license']);   // Guest Mode
Route::get('/termsOfService', [HomeController::class, 'termsOfService']);   // Guest Mode
Route::get('/privacyPolicy', [HomeController::class, 'privacyPolicy']);   // Guest Mode
Route::get('/cookiesPolicy', [HomeController::class, 'cookiesPolicy']);   // Guest Mode
Route::get('/aboutUs', [HomeController::class, 'aboutUs']);   // Guest Mode
Route::get('/forum', [HomeController::class, 'forum']);   // Guest Mode

Route::get('/media-detail/{id}', [MediaController::class, 'mediaDetail'])->name('media-detail');        // Guest Mode
Route::post('/media-download', [MediaController::class, 'mediaDownload'])->name('media-download');      // Guest Mode
Route::post('/media-share', [MediaController::class, 'mediaShare'])->name('media-share');      // Guest Mode


Route::get('/media-search/{id}', [MediaController::class, 'mediaSearch'])->name('media-search');

Route::get('/donation/{id}', [HomeController::class, 'donation'])->name('donation');

Route::post('/medias/mediasByCategory',       [MediaController::class, 'mediasByCategory'])->name('medias/mediasByCategory');
Route::get('/users/{username}',                 [MediaController::class, 'staticLink'])->name('staticLink');

Route::get('resetPassword',                 [UserController::class, 'resetPassword'])->name('resetPassword');
Route::post('sendResetEmail',                 [UserController::class, 'sendResetEmail'])->name('sendResetEmail');

Route::post('changePasswordToken',          [UserController::class, 'changePasswordToken12'])->name('changePasswordToken');



// =========== Auth Mode Routes =========== // (Means )

Route::group(['middleware' => ['auth']], function () {
    // APIs for tags search 
    Route::post('/tags/search',           [TagController::class, 'search'])->name('tags/search');   // Auth Role

    Route::post('/media-setLike', [MediaController::class, 'mediaSetLike'])->name('media-setLike');         // Auth role
    Route::post('/media-addcomment', [MediaController::class, 'mediaAddComment'])->name('media-addcomment');    // Auth role

    Route::get('/contacts-profile', [ProfileController::class, 'index'])->name('contacts-profile'); // Auth role
    Route::get('/contacts-profile-edit', [ProfileController::class, 'edit'])->name('contacts-profile-edit'); // Auth role
    Route::post('/contacts-profile/update', [ProfileController::class, 'update'])->name('contacts-profile/update'); // Auth role
    Route::post('/contacts-profile/changeStatus',     [ProfileController::class, 'changeStatus'])->name('contacts-profile/changeStatus');   // Auth role

    Route::get('/upload',           [MediaController::class, 'upload'])->middleware('auth');    // Auth role
    Route::post('/upload/store',    [MediaController::class, 'store'])->name('upload/store');   // Auth role
    Route::post('/upload/delete',   [MediaController::class, 'fileDestroy'])->name('upload/delete');    // Auth role
    Route::post('/upload/addMedia', [MediaController::class, 'addMedia'])->name('upload/addMedia'); // Auth role    

    Route::post('/categories/getInfo',   [CategoryController::class, 'getInfo'])->name('categories/getInfo');   // Auth Role
    Route::post('/subcategories/getFromCategory',    [CategoryController::class, 'getFromCategory'])->name('subcategories/getFromCategory');    // Admin Role

    Route::post('/media/remove',     [MediaController::class, 'remove'])->name('media/remove'); // Customer role

});

// ============= Admin Role Routes ============= //

Route::group(['middleware' => ['admin']], function () {
    Route::get('/admin-medias', [MediaController::class, 'adminList'])->name('admin-medias');
    Route::post('/media/changeStatus', [MediaController::class, 'changeStatus'])->name('media/changeStatus');    

    Route::get('/admin-unapproved-medias', [MediaController::class, 'unapprovedAdminList'])->name('admin-unapproved-medias');

    Route::get('/users',   [UserController::class, 'index'])->name('user-list');                        // Admin Role
    Route::get('/users/add',     [UserController::class, 'create'])->name('users/add');                 // Admin Role
    Route::post('/users/store',     [UserController::class, 'store'])->name('users/store');             // Admin Role
    Route::get('/users/edit/{id}',     [UserController::class, 'edit'])->name('users/edit');            // Admin Role
    Route::post('/users/update/{id}',     [UserController::class, 'update'])->name('users/update');     // Admin Role
    Route::post('/users/changeStatus',     [UserController::class, 'changeStatus'])->name('users/changeStatus');    // Admin Role
    Route::post('/users/destroy/{id}',    [UserController::class, 'destroy'])->name('users/destroy');               // Admin Role


    Route::get('/categories',   [CategoryController::class, 'index']);  // Admin Role
    Route::post('/categories/add',   [CategoryController::class, 'create'])->name('categories/add');    // Admin Role
    Route::post('/categories/destroy',   [CategoryController::class, 'destroy'])->name('categories/destroy');   // Admin Role

    Route::get('/subcategories/{id}',    [CategoryController::class, 'subcategoryIndex'])->name('subcategories');   // Admin Role
    Route::post('/subcategories/destroy',    [CategoryController::class, 'destroy_subcategory'])->name('subcategories/destroy');    // Admin Role
    Route::post('/subcategories/add',    [CategoryController::class, 'subcategory_add'])->name('subcategories/add');    // Admin Role


    Route::get('/cryptos',                 [CryptoController::class, 'index']); // Admin Role
    Route::post('/cryptos-add',            [CryptoController::class, 'addCrypto'])->name('cryptos/add');    // Admin Role
    Route::post('/cryptos/destroy/{id}',   [CryptoController::class, 'destroy'])->name('cryptos/destroy');  // Admin Role

    Route::get('/tags',                 [TagController::class, 'index']);   // Admin Role
    Route::post('/tags-add',            [TagController::class, 'addFeaturedTag'])->name('tags/add');    // Admin Role
    Route::post('/tags/destroy/{id}',   [TagController::class, 'destroy'])->name('tags/destroy');   // Admin Role

    Route::get('/settings',             [SettingController::class, 'index']);      // Admin Role
    Route::post('/settings/update',     [SettingController::class, 'update'])->name('settings/update');   // Admin Role

    Route::get('/admin-fonts',  [FontController::class, 'index']);      // Admin Role
});

// ============= Customer Role Routes ============= //
Route::group(['middleware' => ['customer']], function () {
    Route::get('/user-dashboard',   [DashboardController::class, 'index']); // Customer role
    Route::get('/user-statistics',  [StatisticController::class, 'index']); // Cusotmer role

    Route::get('/media-curation', [MediaController::class, 'curation']); // Customer role
    Route::post('/media/vote',     [MediaController::class, 'vote'])->name('media/vote'); // Customer role
});


