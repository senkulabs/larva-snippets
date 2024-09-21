<?php

use App\Jobs\ProcessBikeShareFile;
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

Route::get('/button', Button::class);
Route::get('/third-party', ThirdParty::class);
Route::get('/nested-sortable', NestedSortable::class);
Route::get('/form', Form::class);
Route::get('/reset-password', ResetPassword::class);
Route::get('/datatable', Datatable::class);
Route::get('/job-batching', JobBatching::class);

// Queue and Job batching
Route::get('/process-csv-file', function () {
    $path = base_path('csvfile/2010-capitalbikeshare-tripdata.csv');
    // Truncate
    DB::table('bike_share')->truncate();

    $path = base_path('csvfile/2010-capitalbikeshare-tripdata.csv');

    $file = fopen($path, 'r');

    if ($file !== false) {
        $header = array_map(function ($head) {
            return implode('_', explode(' ', strtolower($head)));
        }, fgetcsv($file));
        $data = [];
        if ($header !== false) {
            while (($record = fgetcsv($file)) !== false) {
                array_push($data, $record);
            }

            $batch = Bus::batch([])->dispatch();
            collect($data)->chunk(100)->each(function ($chunk) use ($header, $batch) {
                $arrs = [];
                foreach ($chunk as $item) {
                    $arr = array_combine($header, $item);
                    array_push($arrs, $arr);
                }
                $batch->add(new ProcessBikeShareFile($arrs));
            });
        }
    }
});

Route::get('/trix-plain', function () {
    return view('trix-plain');
});

Route::get('/trix-tailwind', function () {
    return view('trix-tailwind');
});

Route::post('/store', function (Request $request) {
    return $request->content;
});

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
