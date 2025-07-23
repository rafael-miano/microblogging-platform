<?php

namespace App\Http\Controllers;

use App\Models\User;

class PublicProfileController extends Controller
{
    public function show(User $user)
    {
        $posts = $user->posts()
            ->where('published_at', '<=', now())
            ->with(['media', 'upReacts'])
            ->withCount('upReacts')
            ->latest()
            ->simplePaginate(10);

        return view('profile.show', compact('user', 'posts'));
    }
}
