<?php

namespace App\Providers;

use App\Services\AMQPService;
use Illuminate\Support\ServiceProvider;

class AMQPServiceProvider extends ServiceProvider
{
    /**
     * Register amqp application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(AMQPService::class, AMQPService::class);
    }

    /**
     * Boot the amqp services for the application.
     *
     * @return void
     */
    public function boot()
    {
        # Code ...
    }
}
