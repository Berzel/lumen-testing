<?php

namespace App\Events;

use App\User;

class UserCreated extends Event
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

    public function getName()
    {
        return 'userCreated';
    }

    public function getData()
    {
        return $this->user;
    }
}
