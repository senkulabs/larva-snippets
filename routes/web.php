<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('home');
});

Route::get('/third-party', function () {
    return view('third-party');
});
Volt::route('/form', 'form');
Volt::route('/reset-password', 'reset-password');
Volt::route('/alert', 'alert');
Volt::route('/single-select', 'single-select');
Volt::route('/multi-select', 'multi-select');
Volt::route('/nested-sortable', 'nested-sortable');
Volt::route('/datatable', 'datatable');
Volt::route('/job-batching', 'job-batching');

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

Route::get('/phpinfo', function() {
    phpinfo();
});
