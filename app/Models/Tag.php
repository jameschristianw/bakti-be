<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use HasFactory, SoftDeletes, HasUuids, LogsActivity;

    protected $table = 'tags';

    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'slug',
        'hex_color',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($tag) {
            $slug = $tag->slug ?: \Illuminate\Support\Str::slug($tag->name);
            $originalSlug = $slug;
            $count = 1;

            while (static::withTrashed()->where('slug', $slug)->when($tag->exists, fn ($q) => $q->where('uuid', '!=', $tag->uuid))->exists()) {
                $slug = "{$originalSlug}-{$count}";
                $count++;
            }

            $tag->slug = $slug;

            if (empty($tag->hex_color)) {
                $tag->hex_color = self::generateRandomColor();
            }
        });
    }

    private static function generateRandomColor(): string
    {
        $existingColors = self::pluck('hex_color')->filter()->toArray();
        $maxAttempts = 50;

        for ($i = 0; $i < $maxAttempts; $i++) {
            $color = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
            
            if (self::isColorDistinct($color, $existingColors)) {
                return $color;
            }
        }

        // Fallback if no distinct color found after max attempts
        return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    }

    private static function isColorDistinct(string $newColor, array $existingColors, int $threshold = 30): bool
    {
        if (empty($existingColors)) {
            return true;
        }

        $r1 = hexdec(substr($newColor, 1, 2));
        $g1 = hexdec(substr($newColor, 3, 2));
        $b1 = hexdec(substr($newColor, 5, 2));

        foreach ($existingColors as $existingColor) {
            $r2 = hexdec(substr($existingColor, 1, 2));
            $g2 = hexdec(substr($existingColor, 3, 2));
            $b2 = hexdec(substr($existingColor, 5, 2));

            // Calculate Euclidean distance in RGB space
            $distance = sqrt(pow($r1 - $r2, 2) + pow($g1 - $g2, 2) + pow($b1 - $b2, 2));

            if ($distance < $threshold) {
                return false; // Too similar
            }
        }

        return true;
    }

    public function sermons(): BelongsToMany
    {
        return $this->belongsToMany(Sermon::class, 'sermon_tag', 'tag_uuid', 'sermon_uuid');
    }
}
