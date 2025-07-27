<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Category;
use App\Models\Post;
use App\Traits\ClearPostCache;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use League\CommonMark\GithubFlavoredMarkdownConverter;
use Log;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use ClearPostCache;

    public function index()
    {

        // $this->enableQueryLoggingOnce();

        $user = auth()->user();

        $baseQuery = Post::with(['user', 'media'])
            ->where('published_at', '<=', now())
            ->withCount('upReacts');

        if ($user) {
            $followingIds = $user->following()->pluck('users.id');

            if ($followingIds->isEmpty()) {
                $cacheKey = 'random-posts-user-' . $user->id;

                $posts = Cache::remember($cacheKey, now()->addMinutes(3), function () use ($baseQuery, $user) {
                    return (clone $baseQuery)
                        ->where('user_id', '!=', $user->id)
                        ->inRandomOrder()
                        ->simplePaginate(5);
                });
            } else {
                $posts = $baseQuery
                    ->whereIn('user_id', $followingIds)
                    ->where('user_id', '!=', $user->id)
                    ->latest()
                    ->simplePaginate(5);
            }
        } else {
            $posts = Cache::remember('random-posts-guest', now()->addMinutes(3), function () use ($baseQuery) {
                return (clone $baseQuery)
                    ->inRandomOrder()
                    ->simplePaginate(5);
            });
        }

        $postIds = $posts->pluck('id')->toArray();

        $userUpReactedPostIds = [];
        if ($user && count($postIds) > 0) {
            $userUpReactedPostIds = \DB::table('up_reacts')
                ->where('user_id', $user->id)
                ->whereIn('post_id', $postIds)
                ->pluck('post_id')
                ->toArray();
        }

        return view('post.index', compact('posts', 'userUpReactedPostIds'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::get();

        return view('post.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostCreateRequest $request)
    {
        $this->clearRandomPostCaches();

        $data = $request->validated();

        $data['user_id'] = Auth::id();
        $data['slug'] = Str::slug($data['title']);

        $post = Post::create($data);

        $post->addMediaFromRequest('image')
            ->toMediaCollection();

        return redirect()->route('dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $username, Post $post)
    {
        // $this->enableQueryLoggingOnce();

        $post->load(['user', 'media', 'category'])->loadCount('upReacts');

        $user = auth()->user();
        $hasUpReact = false;

        if ($user) {
            $hasUpReact = $user->hasUpReact($post);
        }

        $converter = new GithubFlavoredMarkdownConverter([
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);
        $post->content_html = $converter->convert($post->content)->getContent();

        return view('post.show', compact('post', 'hasUpReact'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        // $this->enableQueryLoggingOnce();

        if ($post->user_id !== Auth::id()) {
            abort(403);
        }
        $categories = Category::get();

        return view('post.edit', [
            'post' => $post,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostUpdateRequest $request, Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }
        $data = $request->validated();

        $post->update($data);

        if ($data['image'] ?? false) {
            $post->addMediaFromRequest('image')
                ->toMediaCollection();
        }

        return to_route('myPosts');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        // $this->enableQueryLoggingOnce();

        $post->delete();

        return to_route('myPosts')->with('success', 'Post deleted successfully!');
    }

    public function category(Category $category)
    {
        // $this->enableQueryLoggingOnce();

        $user = auth()->user();

        $query = $category->posts()
            ->where('published_at', '<=', now(config('app.timezone'))->seconds(0))
            ->with(['user', 'media'])
            ->withCount('upReacts')
            ->latest();

        if ($user) {
            $ids = $user->following()->pluck('users.id');
            $query->whereIn('user_id', $ids);
        }

        $posts = $query->simplePaginate(5);

        return view('post.index', compact('posts'));
    }

    public function myPosts()
    {
        // $this->enableQueryLoggingOnce();

        $user = auth()->user();
        $posts = $user->posts()
            ->with(['user', 'media'])
            ->withCount('upReacts')
            ->latest()
            ->simplePaginate(5);

        return view('post.index', compact('posts'));
    }

    private function clearRandomPostCaches(): void
    {
        Cache::forget('random-posts-guest');
        Cache::forget('random-posts-user-' . auth()->id());
    }

    private function enableQueryLoggingOnce(): void
    {
        if (!app()->runningInConsole() && !app()->bound('query.listener')) {
            DB::listen(function ($query) {
                Log::info('SQL Query Executed', [
                    'sql' => $query->sql,
                    'bindings' => $query->bindings,
                    'time' => $query->time . ' ms',
                ]);
            });

            app()->singleton('query.listener');
        }
    }
}
