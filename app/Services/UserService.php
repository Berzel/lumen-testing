<?php

namespace App\Services;

use App\User;
use App\Events\UserCreated;
use App\Events\UserDeleted;
use App\Events\UserUpdated;
use App\Events\PasswordChanged;
use App\Exceptions\UserNotFoundException;

class UserService
{
    /**
     * Get all users from the database. By default users are paginated 15 per page
     * 
     * @param int $perPage The number of users to show per page
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAll($perPage = 15)
    {
        return User::paginate($perPage);
    }

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
     * @param int $id The id of the user to update
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
     * @param int $id The id of the user to fetch
     * @return \App\User The user instance
     * @throws \App\Exceptions\UserNotFoundException
     */
    public function findById(int $id)
    {
        $user = User::find($id);

        if (!$user) {
            throw new UserNotFoundException('The user with id: ' . $id . ', was not found');
        }

        return $user;
    }

    /**
     * Delete a user from storage. The method does not throw an error if user
     * is not found, it simply ignores the exception
     * 
     * @param int $id The id of the user to delete from storage
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

    /**
     * Change a user's password in storage
     * 
     * @param int $id The id of the user
     * @param string $newPassword The new password to be assigned
     * @return void
     */
    public function changePassword(int $id, string $newPassword)
    {
        $user = $this->findById($id);
        $user->password = $newPassword;
        $user->save();
        event(new PasswordChanged($user));
    }
}
