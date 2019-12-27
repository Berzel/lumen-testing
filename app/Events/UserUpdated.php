<?php

namespace App\Events;

use App\User;

class UserUpdated extends Event
{
    /**
     * The user that has been updated
     * 
     * @var \App\User
     */
    public User $user;

    /**
     * This event is fired when a user has been updated.
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
        return env('APP_NAME') . '.' . 'UserUpdated';
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
