<?php

use App\Models\NVR;
use App\Models\User;
use App\Models\Svich;
use App\Models\Firewall;
use App\Models\Biometric;
use App\Models\NetworkNVR;
use App\Models\AccessPoint;
use App\Models\NetworkSwitches;
use Database\Seeders\CpuSeeder;
use Illuminate\Database\Seeder;
use Database\Seeders\SvichSeeder;
use Database\Seeders\LaptopSeeder;
use Illuminate\Support\Facades\DB;
use Database\Seeders\IpPhoneSeeder;
use Database\Seeders\PrinterSeeder;
use Database\Seeders\FirewallSeeder;
use Database\Seeders\BiometricSeeder;
use Database\Seeders\NetworkNVRSeeder;
use Database\Seeders\SmartPhoneSeeder;
use Database\Seeders\AccessPointSeeder;
use Database\Seeders\NetworkSwitchSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::statement('PRAGMA foreign_keys = OFF');
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123'),
        ]);
        $this->call(LaptopSeeder::class);
        $this->call(PrinterSeeder::class);
        $this->call(NetworkSwitchSeeder::class);
        $this->call(FirewallSeeder::class);
        $this->call(NetworkNVRSeeder::class);
        $this->call(BiometricSeeder::class);
        $this->call(AccessPointSeeder::class);
        $this->call(SmartPhoneSeeder::class);
        $this->call(IpPhoneSeeder::class);
        $this->call(CpuSeeder::class);
    }
}
