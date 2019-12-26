<?php

namespace App\Services;

use App\User;
use App\Events\UserCreated;
use App\Events\UserDeleted;
use App\Events\UserUpdated;

class UserService
{
    /**
     * Save the user to the database
     * 
     * @param array $fields
     * @return \App\User $user
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
     * @return \App\User $user
     */
    public function update(int $id, array $fields)
    {
        $user = $this->findById($id);
        $user->update($fields);
        event(new UserUpdated($user));
        return $user;
    }

    /**
     * Find the user in the database by id
     * 
     * @param int $id
     * @return \App\User $user
     */
    public function findById(int $id)
    {
        $user = User::findOrFail($id);

        if (!$user) {
            throw new \Exception('User with id: ' . $id . ' not found', 1);
        }

        return $user;
    }

    /**
     * Delete a user from storage
     * 
     * @return void
     */
    public function delete(int $id)
    {
        try {
            $user = $this->findById($id);
            $user->delete();
            event(new UserDeleted($user));
        }

        // 
        catch (\Throwable $th) {
            # Code...
        }
    }
}
