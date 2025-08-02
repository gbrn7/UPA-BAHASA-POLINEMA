<?php

namespace App\Providers;

use App\Models\MailSetting;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Config;
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
        if (Schema::hasTable('mail_setting')) {
            $mailsetting = MailSetting::first();
            if ($mailsetting) {
                $data = [
                    'driver'            => $mailsetting->mail_transport,
                    'host'              => $mailsetting->mail_host,
                    'port'              => $mailsetting->mail_port,
                    'encryption'        => $mailsetting->mail_encryption,
                    'username'          => $mailsetting->mail_username,
                    'password'          => $mailsetting->mail_password,
                    'from'              => [
                        'address' => $mailsetting->mail_from,
                        'name'   => env('APP_NAME')
                    ]
                ];
                Config::set('mail', $data);
            }
        }

        Relation::enforceMorphMap([
            'post' => \App\Models\News::class,
        ]);
    }
}
