<?php

namespace App\Containers\UsersSection\Adminstrator\Actions;

use App\Containers\UsersSection\Adminstrator\Admins;
use App\Ship\Actions\Action;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Containers\UsersSection\Adminstrator\Data\Models\Admin;
use App\Http\Requests\StoreAdministratorRequest;

class CreateAdminAction extends Action
{
    public function run(StoreAdministratorRequest $request)
    {
        $admin=null;
        DB::transaction(function () use ($request, &$admin) {
            $name = $request->validated()['full_name'];
           $user = User::create([
               'name'=>$name,
               'email'=>$request->validated()['email'],
               'password'=>Hash::make($request->validated()['password']),
               'role'=>'admin'
           ]);

           $admin =Admin::create(array_merge($request->validated(), ['user_id'=>$user->id]));

        });
        return $admin;

    }
}
