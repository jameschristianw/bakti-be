<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Family extends Model
{
    use HasFactory, SoftDeletes, HasUuids, LogsActivity;

    protected $table = 'families';

    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'family_name',
        'address',
        'notes',
        'start_at',
    ];

    protected $casts = [
        'start_at' => 'date',
    ];

    public function members()
    {
        return $this->hasMany(FamilyMember::class, 'family_uuid', 'uuid');
    }

    public function congregations()
    {
        return $this->belongsToMany(Congregation::class, 'family_members', 'family_uuid', 'congregation_uuid', 'uuid', 'uuid')
            ->withPivot(['uuid', 'role', 'is_primary', 'start_date', 'end_date', 'created_at', 'updated_at', 'deleted_at']);
    }
}
