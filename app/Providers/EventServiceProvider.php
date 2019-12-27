<?php

namespace App\Providers;

use App\Events\UserCreated;
use App\Events\UserDeleted;
use App\Events\UserUpdated;
use App\Events\PasswordChanged;
use App\Listeners\UserCreatedListener;
use App\Listeners\UserDeletedListener;
use App\Listeners\UserUpdatedListener;
use App\Listeners\PasswordChangedListener;
use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        UserCreated::class => [
            UserCreatedListener::class
        ],

        UserUpdated::class => [
            UserUpdatedListener::class
        ],

        UserDeleted::class => [
            UserDeletedListener::class
        ],

        PasswordChanged::class => [
            PasswordChangedListener::class
        ]
    ];
}
