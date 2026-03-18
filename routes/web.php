<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');


Route::get('test', function () {
    $response = \Nextpointer\Prestashop\Facades\Prestashop::products()
        ->limit(10)
        ->offset(0)
        ->only(['id','name'])
        ->get();
    dd($response);
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
