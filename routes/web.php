<?php

use App\Jobs\ProcessCSVFile;
use App\Livewire\Datatable;
use App\Livewire\Form;
use App\Livewire\JobBatching;
use App\Livewire\ThirdParty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\LazyCollection;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/third-party', ThirdParty::class);
Route::get('/form', Form::class);
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

Route::get('/test-redis', function () {
    try {
        Redis::set('test_key', 'Redis Connection success!');

        $value = Redis::get('test_key');

        return response()->json([
            'status' => 'success',
            'message' => $value
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 400);
    }
});
