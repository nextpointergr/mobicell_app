<?php

use Illuminate\Support\Facades\Route;
use NextPointer\Pylon\Facades\Pylon;
Route::view('/', 'welcome');


Route::get('test', function () {

    $slug = central_store_slug();


    if (!$slug) {
        dd('No central store slug found');
    }

    $store = Pylon::store($slug);
    dd($store->payments()->all()->dto());


});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
