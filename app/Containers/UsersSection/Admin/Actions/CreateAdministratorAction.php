<?php

namespace App\Containers\UsersSection\Admin\Actions;

use App\Ship\Actions\Action;
use App\Containers\UsersSection\Admin\Data\Models\Adminstrator;
use App\Models\User;
use App\Containers\UsersSection\Admin\Requests\StoreAdminRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class CreateAdministratorAction extends Action
{
    public function run(StoreAdminRequest $request)
    {
        $admin = null;

        try {
            DB::transaction(function () use ($request, &$admin) {
                Log::info('Starting transaction for creating an admin.');

                // Create user
                $user = User::create([
                    'name' => $request->validated()['full_name'],
                    'email' => $request->validated()['email'],
                    'password' => Hash::make('SecuredKey@2024'),
                    'role' => 'admin',
                ]);

                Log::info('User created: ', ['user' => $user]);

                // Create admin
                $admin = Adminstrator::create(array_merge(
                    $request->validated(),
                    ['user_id' => $user->id, 'registered_by' => 1]
                ));

                Log::info('Admin created: ', ['admin' => $admin]);
            });
            Log::info('Transaction completed successfully.');
        } catch (\Exception $e) {
            Log::error('Error during transaction: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to create admin'], 500);
        }

        return $admin ? response()->json(['admin' => $admin], 201) : response()->json(['error' => 'Admin not created'], 500);
    }
}
