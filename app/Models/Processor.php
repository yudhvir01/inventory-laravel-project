<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Processor extends Model
{
    use HasFactory;
    public function laptop()
    {
        return $this->hasMany(Laptop::class);
    }
    public function assignable(): MorphMany
    {
        return $this->morphMany(Assign::class, 'assignable');
    }
    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }
}
