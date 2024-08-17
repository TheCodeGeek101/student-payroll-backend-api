<?php

namespace App\Containers\UsersSection\Admin\Actions;

use App\Ship\Actions\Action;
use App\Containers\UsersSection\Admin\Request\UpdateAdminRequest;
use App\Containers\UsersSection\Admin\Data\Models\Adminstrator;
class UpdateAdminAction extends Action
{
    public function run(UpdateAdminRequest $request, Adminstrator $adminstrator): Adminstrator
    {
        $updatedAdmin = $adminstrator->update($request->validated());
        return $updatedAdmin;

    }

}
