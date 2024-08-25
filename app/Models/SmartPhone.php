<?php

namespace App\Models;

use App\Models\Assign;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SmartPhone extends Model
{
    public $set;
    protected $table = 'smart_phones';
    use HasFactory;
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'unassigned_at' => 'datetime',
        'is_assigned' => 'boolean',
    ];

    protected $fillable = [
        'manufacturer_id',
        'processor_id',
        'version_id',
        'system_serial_number',
        'ram',
        'memory_type',
        'memory_size',
        'uid',
    ];

    public function getuidAttribute()
    {
        return '00' . $this->id . '-SMP';
    }

    public function version()
    {
        return $this->belongsTo(Version::class);
    }



    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }

    public function processor()
    {
        return $this->belongsTo(Processor::class);
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
    public function assetdetail()
    {
        return $this->morphMany(Assign::class, 'assignable');
    }


    public function scopeAssigned(Builder $query): void
    {
        $query->whereHas('assigns', function ($query) {
            return $query->whereNull('unassigned_at');
        });
    }
}
