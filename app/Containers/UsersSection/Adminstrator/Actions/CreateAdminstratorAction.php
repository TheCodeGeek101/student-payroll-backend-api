<?php

namespace App\Containers\UsersSection\Adminstrator\Actions;

use App\Models\User;
use App\Ship\Actions\Action;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Containers\UsersSection\Adminstrator\Requests\StoreAdminRequest;
use App\Containers\UsersSection\Adminstrator\Data\Models\Admin;

class CreateAdminstratorAction extends Action
{
    public function run(StoreAdminRequest $request)
    {
        $admin = null;
        DB::transaction(function () use ($request, &$admin) {

            $user = User::create([
                'name' => $request->validated()['full_name'],
                'email' => $request->validated()['email'],
                'password' => Hash::make('SecuredKey@2024'),
                'role' => 'admin',
            ]);

            $admin = Admin::create(array_merge(
                $request->validated(),
                ['user_id' => $user->id, 'registered_by' => 1]
            ));
        });
        return $admin;
    }
}
