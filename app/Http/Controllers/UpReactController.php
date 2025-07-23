<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Traits\ClearPostCache;
use Illuminate\Http\JsonResponse;

class UpReactController extends Controller
{
    use ClearPostCache;

    public function upReact(Post $post): JsonResponse
    {
        $user = auth()->user();

        $this->clearRandomPostCaches();

        $upReact = $post->upReacts()->where('user_id', $user->id)->first();

        if ($upReact) {
            $upReact->delete();
        } else {
            $post->upReacts()->create(['user_id' => $user->id]);
        }

        $upReactCount = $post->upReacts()->count();

        return response()->json([
            'upReactCounts' => $upReactCount,
        ]);
    }
}
