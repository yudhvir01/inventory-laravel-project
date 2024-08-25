<?php

namespace Database\Seeders;


use App\Imports\NewCpuImport;
use App\Imports\NewNVRImport;
use Illuminate\Database\Seeder;
use App\Imports\NewBiometricImport;
use App\Imports\NewNetworkNVRImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\NewAccessPointImport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NetworkNVRSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = 'storage/app/imports/networknvrSample.csv';
        Excel::import(new NewNetworkNVRImport, $filePath);
    }
}
