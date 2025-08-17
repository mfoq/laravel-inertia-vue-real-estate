<?php

namespace App\Providers;

use App\Policies\NotificationPolicy;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        /**
         * هاي انا سويتها
         * Manual Policy Registration لأنه موديل الداتا بيز نوتفيكيشن مش مني من لارافيل نفسها ا مضطر اعرفها هون بالسيرفس بروفايدر
         */
        Gate::policy(DatabaseNotification::class, NotificationPolicy::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
