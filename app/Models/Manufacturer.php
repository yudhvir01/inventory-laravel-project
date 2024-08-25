<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    use HasFactory;

    public function version()
    {
        return $this->hasMany(Version::class);
    }

    public function processor()
    {
        return $this->hasMany(Processor::class);
    }
}
