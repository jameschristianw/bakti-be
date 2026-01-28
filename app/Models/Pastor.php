<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pastor extends Model
{
    use HasFactory, HasUuids, LogsActivity;

    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'picture_url',
        'bio',
        'created_at',
    ];

    public function sermons(): HasMany
    {
        return $this->hasMany(Sermon::class, 'pastor_uuid', 'uuid');
    }
}
