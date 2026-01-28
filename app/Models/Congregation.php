<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Congregation extends Model
{
    use HasFactory, SoftDeletes, HasUuids, LogsActivity;

    protected $table = 'congregations';

    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'full_name',
        'nickname',
        'email',
        'phone_number',
        'address',
        'birth_date',
        'gender',
        'occupation',
        'education_uuid',
    ];

    protected $casts = [
        'birth_date' => 'datetime',
    ];

    public function education()
    {
        return $this->belongsTo(Education::class, 'education_uuid', 'uuid');
    }

    public function familyMembers()
    {
        return $this->hasMany(FamilyMember::class, 'congregation_uuid', 'uuid');
    }

    public function families()
    {
        return $this->belongsToMany(Family::class, 'family_members', 'congregation_uuid', 'family_uuid', 'uuid', 'uuid')
            ->withPivot(['uuid', 'role', 'is_primary', 'start_date', 'end_date', 'created_at', 'updated_at', 'deleted_at']);
    }
}
