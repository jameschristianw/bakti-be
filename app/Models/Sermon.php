<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Sermon extends Model
{
    use HasFactory, HasUuids, LogsActivity;

    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'title',
        'slug',
        'main_verse',
        'pastor_uuid',
        'sermon_date',
        'youtube_link',
        'tag',
        'content',
        'author_uuid',
        'created_at',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($sermon) {
            if (empty($sermon->slug) || $sermon->isDirty(['title', 'sermon_date'])) {
                $sermon->slug = \Illuminate\Support\Str::slug($sermon->sermon_date . '-' . $sermon->title);
            }
        });
    }

    protected function casts(): array
    {
        return [
            'sermon_date' => 'date',
        ];
    }

    public function pastor(): BelongsTo
    {
        return $this->belongsTo(Pastor::class, 'pastor_uuid', 'uuid');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_uuid', 'uuid');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'sermon_tag', 'sermon_uuid', 'tag_uuid');
    }
}
