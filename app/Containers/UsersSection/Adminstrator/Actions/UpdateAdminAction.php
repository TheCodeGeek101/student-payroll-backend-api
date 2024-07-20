<?php

namespace App\Containers\UsersSection\Adminstrator\Actions;

use App\Ship\Actions\Action;
use App\Containers\UsersSection\Adminstrator\Requests\UpdateAdminRequest;
use App\Containers\UsersSection\Adminstrator\Data\Models\Admin;
class UpdateAdminAction extends Action
{
    public function run(UpdateAdminRequest $request, Admin $admin)
    {
        $updatedAdmin = $admin->update($request->validated());
        return $updatedAdmin;
    }
}
