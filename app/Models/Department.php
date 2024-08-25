<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function assigns()
    {
        return $this->hasMany(Assign::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
