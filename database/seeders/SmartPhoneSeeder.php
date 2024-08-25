<?php

namespace Database\Seeders;


use App\Imports\NewCpuImport;
use Illuminate\Database\Seeder;
use App\Imports\NewSmartPhoneImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SmartPhoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = 'storage/app/imports/smartphoneSample.csv';
        Excel::import(new NewSmartPhoneImport, $filePath);
    }
}
