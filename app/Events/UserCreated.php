<?php

namespace App\Events;

use App\User;

class UserCreated extends Event
{
    /**
     * The user who has been created
     * 
     * @var \App\User
     */
    public User $user;

    /**
     * This event is fired when a new user has been created.
     *
     * @param \App\User $user
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
        return env('APP_NAME') . '.' . 'UserCreated';
    }

    /**
     * Get the event payload
     *
     * @return $mixed
     */
    public function getData()
    {
        return $this->user;
    }
}
