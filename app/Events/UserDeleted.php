<?php

namespace App\Events;

use App\User;

class UserDeleted extends Event
{
    /**
     * The user that has been deleted
     * 
     * @var \App\User
     */
    public User $user;

    /**
     * This event is fired when a user account has been deleted.
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
        return env('APP_NAME') . '.' . 'UserDeleted';
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
