<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('home');
});

Volt::route('/booking-form', 'booking-form')->name('booking-form');
