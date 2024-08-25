<?php

namespace Database\Seeders;


use App\Imports\NewCpuImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CpuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = 'storage/app/imports/cpuSample.csv';
        Excel::import(new NewCpuImport, $filePath);
    }
}
