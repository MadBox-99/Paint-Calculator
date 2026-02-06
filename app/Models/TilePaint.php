<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TilePaint extends Model
{
    // type: a, b, c mandatory
    // name any string ex: 'HARZO Color Easy Pack'
    /** @use HasFactory<\Database\Factories\TilePaintFactory> */
    use HasFactory;

    protected $fillable = [
        'id',
        'type',
        'name',
        'paint_category_id',
        'description',
        'paint_order',
        'images',
        'inspiration_video',
        'brief_implementation',
        'where_to_buy',
        'expert_help',
        'important_info',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'images' => 'array',
        ];
    }

    public function paintCategory(): BelongsTo
    {
        return $this->belongsTo(PaintCategory::class);
    }

    public function descriptions(): HasMany
    {
        return $this->hasMany(TilePaintDescription::class);
    }
}
