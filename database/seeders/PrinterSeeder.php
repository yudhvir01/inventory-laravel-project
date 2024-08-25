<?php

namespace Database\Seeders;


use App\Imports\NewCpuImport;
use Illuminate\Database\Seeder;
use App\Imports\NewPrinterImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PrinterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = 'storage/app/imports/printerSample.csv';
        Excel::import(new NewPrinterImport, $filePath);
    }
}
