<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = base_path('csvfile/employee_datatable.csv');

        $file = fopen($path, 'r');

        if ($file !== false) {
            $header = array_map(function ($head) {
                return implode('_', explode(' ', strtolower($head)));
            }, fgetcsv($file));

            $data = [];

            if ($header !== false) {
                while (($record = fgetcsv($file)) !== false) {
                    $mapped_record = [];
                    foreach ($record as $key => $value) {
                        $mapped_record[$header[$key]] = $value;
                    }
                    array_push($data, $mapped_record);
                }
                Employee::insert($data);
            }
        }
    }
}
