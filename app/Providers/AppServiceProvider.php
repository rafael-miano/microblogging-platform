<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $user = Auth::user();

            if (!$user) {
                $view->with('avatarUrl', null);
                return;
            }

            $nameParts = preg_split('/\s+/', trim($user->name));
            $first = strtoupper(substr($nameParts[0] ?? '', 0, 1));
            $last = strtoupper(substr(end($nameParts) !== $nameParts[0] ? end($nameParts) : '', 0, 1));
            $initials = ($first . $last) ?: 'U';
            $avatar = $user->imageUrl() ?: "https://ui-avatars.com/api/?name={$initials}&length=2&background=gray&color=fff&rounded=true";

            $view->with('avatarUrl', $avatar);
            $view->with('avatarInitials', $initials);

        });
    }
}
