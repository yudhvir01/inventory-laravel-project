<?php

namespace App\Nova\Filters;

use Laravel\Nova\Filters\BooleanFilter;
use Laravel\Nova\Http\Requests\NovaRequest;

class AssetTypeFilter extends BooleanFilter
{
    public $name = 'Asset Type';

    public function apply(NovaRequest $request, $query, $value)
    {
        $selectedTypes = array_keys(array_filter($value));

        if (!empty($selectedTypes)) {
            return $query->whereIn('assignable_type', $selectedTypes);
        }

        return $query;
    }

    public function options(NovaRequest $request)
    {
        return [
            'Laptop' => \App\Models\Laptop::class,
            'CPU' => \App\Models\CPU::class,
            'IP Phone' => \App\Models\IpPhone::class,
            'Smartphone' => \App\Models\SmartPhone::class,
            'Access Point' => \App\Models\AccessPoint::class,
            'Biometric' => \App\Models\Biometric::class,
            'Firewall' => \App\Models\Firewall::class,
            'Network NVR' => \App\Models\NetworkNVR::class,
            'Network Switches' => \App\Models\NetworkSwitch::class,
            'Printer' => \App\Models\Printer::class,
        ];
    }


}
