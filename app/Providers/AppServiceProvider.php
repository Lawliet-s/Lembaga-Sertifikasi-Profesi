<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        View::composer('*', function ($view) {
            $setting = SiteSetting::first();
            $view->with('site_setting', $setting);

            $logos = [];
            if ($setting) {
                foreach (['logo', 'logo2', 'logo3', 'logo4'] as $col) {
                    if ($setting->$col) {
                        $logos[] = $setting->$col;
                    }
                }
            }
            $view->with('logos', $logos);
        });
    }
}
