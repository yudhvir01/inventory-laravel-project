<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NetworkNVR extends Model
{
    public $set;
    protected $table = 'network_n_v_r';
    use HasFactory;
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'unassigned_at' => 'datetime',
        'is_assigned' => 'boolean',
    ];

    protected $fillable = [];

    public function getuidAttribute()
    {
        return '00' . $this->id . '-NVR';
    }
    public function version()
    {
        return $this->belongsTo(Version::class);
    }
    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }


    public function assignable(): MorphMany
    {
        return $this->morphMany(Assign::class, 'assignable');
    }


    public function unassign()
    {
        $latestAssign = $this->assigns()->latest()->first();
        if ($latestAssign) {
            $latestAssign->unassigned_at = now();
            $latestAssign->save();
        }
        $this->is_assigned = false;
        $this->save();
    }
    public function assigns(): MorphMany
    {
        return $this->morphMany(Assign::class, 'assignable');
    }
    public function assetdetail()
    {
        return $this->morphMany(Assign::class, 'assignable');
    }


    public function assign(User $user, Branch $branch, Department $department,Company $company)
    {
        $this->assigns()->create([
            'user_id' => $user->id,
            'branch_id' => $branch->id,
            'department_id' => $department->id,
            'company_id' => $company->id,
        ]);
        $this->is_assigned = 1;
        $this->save();
    }

    public function scopeAssigned(Builder $query): void
    {
        $query->whereHas('assigns', function ($query) {
            return $query->whereNull('unassigned_at');
        });
    }
}
