<?php

use App\Jobs\ProcessCsvFile;
use App\Livewire\Alert;
use App\Livewire\Button;
use App\Livewire\Form;
use App\Livewire\NestedSortable;
use App\Livewire\Select;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/button', Button::class);
Route::get('/select', Select::class);
Route::get('/alert', Alert::class);
Route::get('/nested-sortable', NestedSortable::class);
Route::get('/form', Form::class);

// Queue and Job batching
Route::get('/process-csv-file', function () {
    $path = storage_path('app/2010-capitalbikeshare-tripdata.csv');

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
                $batch->add(new ProcessCsvFile($arrs));
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
    if ($request->hasFile('file')) {
        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('uploads', $fileName, 'public');
        $fileUrl = Storage::url($filePath);

        return response()->json(['url' => $fileUrl], 200);
    }
});
