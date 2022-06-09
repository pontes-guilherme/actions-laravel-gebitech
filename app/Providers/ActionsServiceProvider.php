<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ActionsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Contracts\Actions\ApproveUserContract::class, \App\Actions\Auth\ApproveUser::class);
        $this->app->bind(\App\Contracts\Actions\RegisterUserContract::class, \App\Actions\Auth\RegisterUser::class);
        $this->app->bind(\App\Contracts\Actions\SendOnboardEmailContract::class, \App\Actions\Notifications\SendOnboardEmail::class);
        // $this->app->bind(\App\Contracts\Actions\OnboardUserContract::class, \App\Actions\Onboarding\OnboardUser::class);
        $this->app->bind(\App\Contracts\Actions\OnboardUserContract::class, \App\Actions\Onboarding\OnboardAndApproveUser::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
