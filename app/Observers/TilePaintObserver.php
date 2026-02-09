<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\TilePaint;
use Illuminate\Support\Facades\Storage;

class TilePaintObserver
{
    /**
     * Handle the TilePaint "deleting" event.
     */
    public function deleting(TilePaint $tilePaint): void
    {
        foreach ($tilePaint->images ?? [] as $image) {
            Storage::disk('public')->delete($image);
        }
    }
}
