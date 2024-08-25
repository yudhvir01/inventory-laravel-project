<?php

namespace Database\Seeders;


use App\Imports\NewCpuImport;
use Illuminate\Database\Seeder;
use App\Imports\NewIpphoneImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class IpPhoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = 'storage/app/imports/ipphoneSample.csv';
        Excel::import(new NewIpphoneImport, $filePath);
    }
}
