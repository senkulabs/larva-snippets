<?php

use App\Livewire\Alert;
use App\Livewire\Button;
use App\Livewire\Form;
use App\Livewire\NestedSortable;
use App\Livewire\Select;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/button', Button::class);
Route::get('/select', Select::class);
Route::get('/alert', Alert::class);
Route::get('/nested-sortable', NestedSortable::class);
Route::get('/form', Form::class);