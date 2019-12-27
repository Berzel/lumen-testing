<?php

namespace App\Events;

use App\User;

class PasswordChanged extends Event
{
    /**
     * The user whose's password just changed
     * 
     * @var App\User
     */
    public User $user;

    /**
     * This event is fired when a users password has been changed.
     *
     * @param \App\User $user The user whose password changed
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
     * Get the event payload
     *
     * @return $mixed
     */
    public function getData()
    {
        return $this->user;
    }
}
