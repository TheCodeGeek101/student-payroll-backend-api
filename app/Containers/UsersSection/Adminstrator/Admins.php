<?php

namespace App\Containers\UsersSection\Adminstrator;
use App\Containers\UsersSection\Adminstrator\Data\Models\Admin;
use App\Containers\UsersSection\Adminstrator\Resources\AdminResource;
use App\Containers\UsersSection\Adminstrator\Resources\AdminResourceCollection;

class Admins
{
    public function resource(Admin $admin): AdminResource
    {
        return new AdminResource($admin);
    }
    public function resourceCollection($admins): AdminResourceCollection
    {
        return new AdminResourceCollection($admins);
    }

}
