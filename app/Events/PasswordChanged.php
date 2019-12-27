<?php

namespace App\Events;

use App\User;

class PasswordChanged extends Event
{
    /**
     * The data that is to be passed with the event
     * 
     * @var App\User
     */
    public User $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the name of the event
     *
     * @return string
     */
    public function getName()
    {
        return env('APP_NAME') . '.' . 'PasswordChanged';
    }

    /**
     * Get the payload of the event
     *
     * @return $mixed
     */
    public function getData()
    {
        return $this->user;
    }
}
