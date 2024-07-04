<?php

namespace App\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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
    public function boot(): void
    {

            /*
            $settingsConfigArray = DB::table('settings')->where("group_key", "=", "email_settings")->get();
            $settingsConfig = [];

            foreach ($settingsConfigArray as $config) {
                $settingsConfig[$config->key] = $config->value;
            }

            $mail = [
                "driver" => $settingsConfig['mailer_driver'],
                "host" => $settingsConfig['mailer_host'],
                "port" => (int)$settingsConfig['mailer_port'],
                "encryption" => $settingsConfig['mailer_encryption'],
                "username" => $settingsConfig['mailer_username'],
                "password" => $settingsConfig['mailer_password'],
                "from" => [
                    "address" => $settingsConfig['mailer_from_address'],
                    "name" => $settingsConfig['mailer_from_name'],
                ]
            ];

            Config::set('mail', $mail);
*/
    }
}
