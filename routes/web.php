<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SiswaController;
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


//Guest

    Route::get('login', [LoginController::class, 'index'])->name('login');
    Route::post('login', [LoginController::class, 'authenticate']);
    Route::get('/', function(){ return view('home'); });
    Route::get('/about', function() { return view('about'); });
    Route::get('/projects', function () { return view('project'); });
    Route::get('/contact', function () { return view('contact'); });




//admin
    Route::resource('dashboard', DashboardController::class);
    Route::get('mastersiswa/{id_siswa}/hapus', [SiswaController::class, 'hapus'])->name('mastersiswa.hapus');
    Route::resource('mastersiswa', SiswaController::class);
    Route::get('masterproject/create/{id_siswa}', [ProjectController::class, 'tambah'])->name('masterproject.tambah');
    Route::resource('masterproject',ProjectController::class);
    Route::resource('masterkontak', KontakController::class);
    Route::post('logout', [LoginController::class, 'logout']);










