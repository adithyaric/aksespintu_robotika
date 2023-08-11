<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Auth::routes(['verify' => true]);

Route::group(['middleware' => ['web', 'auth', 'verified']], function () {
    Route::get('/home', function () {
        return view('home');
    })->name('home')->middleware('auth');
    Route::resource('users', \App\Http\Controllers\UserController::class);
    Route::resource('akses', \App\Http\Controllers\AksesPintuController::class);
    Route::get('akses-print', [\App\Http\Controllers\AksesPintuController::class, 'print'])->name('akses.print');
    Route::get('/akses/{id}/approved-at', [\App\Http\Controllers\AksesPintuController::class, 'updateApprovedAt'])->name('akses.approved_at');
    Route::get('/akses/{id}/accept', [\App\Http\Controllers\AksesPintuController::class, 'accept'])->name('akses.accept');

    Route::resource('pengguna', \App\Http\Controllers\PenggunaAksesPintuController::class);
});
