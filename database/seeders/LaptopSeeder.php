<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Imports\NewLaptopsImport;
use Maatwebsite\Excel\Facades\Excel;
use SebastianBergmann\CodeCoverage\Report\Xml\Tests;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LaptopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = 'storage/app/imports/laptopsSample.csv';
        Excel::import(new NewLaptopsImport, $filePath);
    }
}
