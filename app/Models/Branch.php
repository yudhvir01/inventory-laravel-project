<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
    ];
    public function assigns(){
        return $this->hasMany(Assign::class);
    }

    public function company(){
        return $this->belongsTo(Company::class);
    }

    public function department(){
        return $this->hasMany(Department::class);
    }
}
