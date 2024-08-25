<?php

namespace Database\Seeders;


use App\Imports\NewCpuImport;
use App\Imports\NewSvichImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\NewNetworkSwitchImport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NetworkSwitchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = 'storage/app/imports/networkswitchSample.csv';
        Excel::import(new NewNetworkSwitchImport, $filePath);
    }
}
