<?php

namespace App\Services;

use App\Events\UserCreated;
use App\User;
use Exception;

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

    /**
     * Update the user in database
     * 
     * @param array $fields
     * @return App\User $user
     */
    public function update(int $id, array $fields)
    {
        $user = $this->findById($id);

        $user->update($fields);
        // event(new UserCreated($user));
        return $user;
    }

    /**
     * Find the user in the database by id
     * 
     * @param int $id
     * @return App\User $user
     */
    public function findById(int $id)
    {
        $user = User::find($id);

        if (!$user) {
            throw new Exception('User with id: ' . $id . ' not found', 1);
        }

        return $user;
    }
}
