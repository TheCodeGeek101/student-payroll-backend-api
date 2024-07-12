<?php

namespace App\Ship\Actions;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Ship\Actions\Action;
use App\Http\Requests\UserRequest;
class CreateUserAction extends Action
{
    public function execute(UserRequest $request)
    {
        // Validate request data
        $user = null;
        DB::transaction(function () use ($request, &$user) {
//            $validated = $request->validate([
//                'email' => 'required|email|unique:users,email',
//                'name' => 'required',
//                'role' => 'required',
//                'password' => 'required|min:8|confirmed',
//            ]);

            // Hash the password
//            $validated['password'] = Hash::make($validated['password']);
            // Create the user
            $user = User::create(array_merge($request->validated()));

        });
        return $user;
    }
}
