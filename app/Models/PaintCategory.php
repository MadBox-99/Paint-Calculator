<?php

declare(strict_types=1);

namespace App\Models;

use App\Observers\PaintCategoryObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy([PaintCategoryObserver::class])]
class PaintCategory extends Model
{
    /** @use HasFactory<\Database\Factories\PaintCategoryFactory> */
    use HasFactory;

    protected $fillable = ['id', 'name', 'is_active'];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    #[Scope]
    protected static function active($query): void
    {
        $query->where('is_active', true);
    }

    public function paints(): HasMany
    {
        return $this->hasMany(TilePaint::class);
    }
}
