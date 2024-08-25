<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Assign;
use App\Models\Branch;
use App\Models\Company;
use App\Models\Version;
use App\Models\Biometric;
use App\Models\Department;
use App\Models\AccessPoint;
use App\Models\Manufacturer;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class NewBiometricImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $company = $row['company'] ? Company::firstOrCreate(['name' => $row['company']]) : null;


            // Branch creation or retrieval
            $branch=$row['branch'] ? Branch::firstOrCreate(['name' => $row['branch'], 'company_id' => $company->id]) : null;

            // Department creation or retrieval
            $department=$row['department'] ? Department::firstOrCreate(['name' => $row['department'], 'branch_id' => $branch->id]) : null;

            //manufacturer
            $manufacturer = $row['manufacturer'] ? Manufacturer::firstOrCreate(['name' => $row['manufacturer']]) : null;

            // Version creation or retrieval
            $version = $row['version'] ?
                Version::firstOrCreate(['name' => $row['version'], 'manufacturer_id' => $manufacturer->id]) : null;

            // User creation or retrieval
            $user = $row['user'] ? User::firstOrCreate(['name' => $row['user'], 'email' => $row['email']]) : null;

            Biometric::create([
                'manufacturer_id' => $manufacturer?->id,
                'ip_address' => $row['ip_address'],
                'version_id' => $version?->id,
                'mac_address' => $row['mac_address'],
                'device_id' => $row['device_id'],
                'is_assigned' => $row['is_assigned'],
            ]);

            Assign::create([
                'user_id' => $user->id,
                'company_id' => $company->id,
                'branch_id' => $branch->id,
                'department_id' => $department?->id,
                'assignable_type' => $row['assignable_type'],
                'assignable_id' => $row['assignable_id'],
            ]);
        }
    }
}
