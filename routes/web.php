<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GoogleController;  
use App\Http\Controllers\ExportController;
use App\Models\User;

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


    Route::get('/file-import',[UserController::class,
            'importView'])->name('import-view'); 
    Route::post('/import',[UserController::class,
            'import'])->name('import'); 
    Route::get('/export-users',[UserController::class,
            'exportUsers'])->name('export-users');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::get('/', function () {
        $users = User::all();
        return view('index', ['users' => $users]);
    });

Route::get('/export', [ExportController::class, 'export']);

