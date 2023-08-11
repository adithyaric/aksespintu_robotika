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
    })->name('home');
    Route::resource('users', \App\Http\Controllers\UserController::class);
    Route::get('profile/{id}', [\App\Http\Controllers\UserController::class, 'profile'])->name('profile');
    Route::resource('akses', \App\Http\Controllers\AksesPintuController::class);
    Route::get('akses-print', [\App\Http\Controllers\AksesPintuController::class, 'print'])->name('akses.print');
    Route::get('/akses/{id}/approved-at', [\App\Http\Controllers\AksesPintuController::class, 'updateApprovedAt'])->name('akses.approved_at');
    Route::get('/akses/{id}/accept', [\App\Http\Controllers\AksesPintuController::class, 'accept'])->name('akses.accept');

    Route::get('/admin/akses', [\App\Http\Controllers\AksesPintuController::class, 'aksesPintuRequests'])->name('akses.akses-pintu-requests.index');
    Route::get('/admin/akses-pintu-requests/{aksesPintuRequest}/approve', [\App\Http\Controllers\AksesPintuController::class, 'approveAksesPintuRequest'])->name('admin.akses-pintu-requests.approve');
    Route::get('/admin/akses-pintu-requests/{aksesPintuRequest}/reject', [\App\Http\Controllers\AksesPintuController::class, 'rejectAksesPintuRequest'])->name('admin.akses-pintu-requests.reject');

    Route::resource('pengguna', \App\Http\Controllers\PenggunaAksesPintuController::class);
});
