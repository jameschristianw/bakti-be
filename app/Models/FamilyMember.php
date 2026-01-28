<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FamilyMember extends Model
{
    use HasFactory, SoftDeletes, HasUuids, LogsActivity;

    protected $table = 'family_members';

    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'family_uuid',
        'congregation_uuid',
        'role',
        'is_primary',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(static function (self $familyMember): void {
            if ($familyMember->start_date) {
                return;
            }

            if (! $familyMember->family_uuid) {
                return;
            }

            $family = Family::query()
                ->where('uuid', $familyMember->family_uuid)
                ->first(['start_at', 'created_at']);

            if (! $family) {
                return;
            }

            if ($family->start_at) {
                $familyMember->start_date = $family->start_at;
                return;
            }

            if ($family->created_at) {
                $familyMember->start_date = $family->created_at;
            }
        });

        static::saved(static function (self $familyMember): void {
            if (! $familyMember->is_primary) {
                return;
            }

            self::query()
                ->where('congregation_uuid', $familyMember->congregation_uuid)
                ->whereKeyNot($familyMember->getKey())
                ->where('is_primary', true)
                ->whereNull('deleted_at')
                ->update([
                    'is_primary' => false,
                    'updated_at' => now(),
                ]);
        });
    }

    public function family()
    {
        return $this->belongsTo(Family::class, 'family_uuid', 'uuid');
    }

    public function congregation()
    {
        return $this->belongsTo(Congregation::class, 'congregation_uuid', 'uuid');
    }
}
