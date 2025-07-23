<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait ClearPostCache
{
    public function clearRandomPostCaches(): void
    {
        Cache::forget('random-posts-guest');

        if (auth()->check()) {
            Cache::forget('random-posts-user-'.auth()->id());
        }
    }
}
