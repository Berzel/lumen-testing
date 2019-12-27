<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Utillities\HttpStatus;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * The UserService implementation
     * 
     * @var \App\Services\UserService
     */
    private UserService $userService;

    /**
     * Create a new controller instance.
     *
     * @param \App\Services\UserService
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Get a single use instance
     * 
     * @param int $id The id of the user
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(int $id)
    {
        $user = $this->userService->findById($id);
        return response()->json($user, HttpStatus::OK);
    }

    /**
     * Get a list of the users
     * 
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $perPage = $request->input('_size');
        $users = $this->userService->getAll($perPage);
        return response()->json($users, HttpStatus::OK);
    }

    /**
     * Create a user
     * 
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $input = $this->validate($request, [
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed'
        ]);

        $user = $this->userService->create($input);

        return response()->json($user, HttpStatus::CREATED);
    }

    /**
     * Update a user
     * 
     * @param \Illuminate\Http\Request
     * @param int $id The id of the user to be updated
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id)
    {
        $user = $this->userService->findById($id);

        $input = $this->validate($request, [
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $id . ',id'
        ]);

        $user = $this->userService->update($id, $input);

        return response()->json($user, HttpStatus::OK);
    }

    /**
     * Update a user's password
     * 
     * @param \Illuminate\Http\Request
     * @param int $id The id of the user
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePassword(Request $request, int $id)
    {
        $user = $this->userService->findById($id);

        $input = $this->validate($request, [
            'old_password' => 'required|min:8',
            'new_password' => 'required|min:8|confirmed'
        ]);

        $oldPasswordValid = Hash::check($input['old_password'], $user->password);

        if (!$oldPasswordValid) {
            return response()->json([
                'old_password' => [
                    'The old password is not correct.'
                ]
            ], HttpStatus::UNPROCESSABLE_ENTITY);
        }

        $similar = Hash::check($input['new_password'], $user->password);

        if ($similar) {
            return response()->json([
                'new_password' => [
                    'The new password should be different from the old password.'
                ]
            ], HttpStatus::UNPROCESSABLE_ENTITY);
        }

        $this->userService->changePassword($id, $input['new_password']);

        return response()->json([
            'message' => 'The password has been changed successfully'
        ], HttpStatus::OK);
    }

    /**
     * Delete a user
     * 
     * @param int $id The id of the user to be deleted
     * @return Illuminate\Http\Response
     */
    public function delete(int $id)
    {
        $this->userService->delete($id);
        return response()->json(null, HttpStatus::NO_CONTENT);
    }
}
