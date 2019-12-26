<?php

namespace App\Services;

use App\Events\UserCreated;
use App\User;

class UserService
{
    /**
     * Save the user to the database
     * 
     * @param array $fields
     * @return App\User $user
     */
    public function create(array $fields)
    {
        $user = User::create($fields);
        event(new UserCreated($user));
        return $user;
    }
}
