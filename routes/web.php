<?php

use App\Jobs\ProcessCsvFile;
use App\Livewire\Alert;
use App\Livewire\Button;
use App\Livewire\Form;
use App\Livewire\NestedSortable;
use App\Livewire\Select;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/button', Button::class);
Route::get('/select', Select::class);
Route::get('/alert', Alert::class);
Route::get('/nested-sortable', NestedSortable::class);
Route::get('/form', Form::class);

// Test job batching
Route::get('/process-csv-file', function () {
    // NOT RECOMMENDED: Increase memory limit
    // ini_set('memory_limit', '256M');

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
