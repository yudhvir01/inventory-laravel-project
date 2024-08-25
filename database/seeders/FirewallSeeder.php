<?php

namespace Database\Seeders;


use App\Imports\NewCpuImport;
use App\Imports\NewSvichImport;
use Illuminate\Database\Seeder;
use App\Imports\NewFirewallImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FirewallSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = 'storage/app/imports/firewallSample.csv';
        Excel::import(new NewFirewallImport, $filePath);
    }
}
