<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Utillities\HttpStatus;

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
