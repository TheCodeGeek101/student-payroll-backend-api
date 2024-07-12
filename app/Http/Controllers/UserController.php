<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Ship\Actions\CreateUserAction;
use App\Ship\Actions\UpdateUserAction;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UpdateUserRequest;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return response()->json(['message' => 'Users retrieved successfully', 'users' => $users], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $newUser = app(CreateUserAction::class)->execute($request);
        return response()->json(['message' => 'User created successfully', 'user' => $newUser], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return response()->json(new UserResource($user), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $updatedUser = app(UpdateUserAction::class)->execute($request, $user);
        return response()->json(['message' => 'User updated successfully', 'user' => $updatedUser], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Example: Delete the user
        $user->delete();
        return response()->json(['message' => 'User deleted successfully'], 200);
    }
}
