<?php

use App\Jobs\ProcessBikeShareFile;
use App\Livewire\Basic;
use App\Livewire\Button;
use App\Livewire\Datatable;
use App\Livewire\Form;
use App\Livewire\JobBatching;
use App\Livewire\NestedSortable;
use App\Livewire\ResetPassword;
use App\Livewire\ThirdParty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/basic', Basic::class);
Route::get('/third-party', ThirdParty::class);
Route::get('/nested-sortable', NestedSortable::class);
Route::get('/form', Form::class);
Route::get('/reset-password', ResetPassword::class);
Route::get('/datatable', Datatable::class);
Route::get('/job-batching', JobBatching::class);

Route::post('/upload-file', function (Request $request) {
    if ($request->has('file')) {
        $path = request()->file('file')->store('trix-attachments', 'public');
        return response()->json([
            'image_url' => Storage::disk('public')->url($path),
            'image_path' => $path
        ], 200);
    }

    return response()->json(['error' => 'No file uploaded'], 400);
});
