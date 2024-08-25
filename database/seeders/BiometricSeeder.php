<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Imports\NewBiometricImport;
use Maatwebsite\Excel\Facades\Excel;

class BiometricSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = 'storage/app/imports/biometricsSample.csv';
        Excel::import(new NewBiometricImport, $filePath);
    }
}
