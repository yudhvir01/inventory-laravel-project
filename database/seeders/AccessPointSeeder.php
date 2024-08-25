<?php

namespace Database\Seeders;


use App\Imports\NewCpuImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\NewAccessPointImport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AccessPointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = 'storage/app/imports/accesspointSample.csv';
        Excel::import(new NewAccessPointImport, $filePath);
    }
}
