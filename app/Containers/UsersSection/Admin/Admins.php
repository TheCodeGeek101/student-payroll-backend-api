<?php

namespace App\Containers\UsersSection\Admin;
use App\Containers\UsersSection\Admin\Data\Models\Adminstrator;
use App\Containers\UsersSection\Admin\Resources\AdminResource;
use App\Containers\UsersSection\Admin\Resources\AdminResourceCollection;
class Admins
{
    public function resource(Adminstrator $adminstrator): AdminResource
    {
        return new AdminResource($adminstrator);
    }
    public function resourceCollection($adminstrators): AdminResourceCollection
    {
        return new AdminResourceCollection($adminstrators);
    }

}
