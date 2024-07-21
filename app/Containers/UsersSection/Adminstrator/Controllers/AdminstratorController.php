<?php

namespace App\Containers\UsersSection\Adminstrator\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Containers\UsersSection\Adminstrator\Data\Models\Admin;
use App\Containers\UsersSection\Adminstrator\Requests\UpdateAdminRequest;
use App\Containers\UsersSection\Adminstrator\Actions\UpdateAdminAction;
use App\Containers\UsersSection\Adminstrator\Resources\AdminResource;
use App\Containers\UsersSection\Adminstrator\Requests\StoreAdminRequest;
use App\Containers\UsersSection\Adminstrator\Actions\CreateAdminstratorAction;
class AdminstratorController extends Controller
{
    public function index (): JsonResponse
    {
        $admins = Admin::all();
        return response()->json(['Admins'=>$admins]);

    }
    public function create ()
    {

    }

    public function store (StoreAdminRequest $request): JsonResponse
    {
        $newAdmin = app(CreateAdminstratorAction::class)->run($request);
        return response()->json(['message'=>'Admin created successfully','Admin'=>$newAdmin],201);
    }
    public function edit ()
    {

    }
    public function delete (Admin $admin): JsonResponse
    {
        $admin->delete();
        return response()->json(['message'=>'Admin deleted successfully','Admin'=>$admin],200);

    }
    public function show (Admin $admin): JsonResponse
    {
        return response()->json(new AdminResource($admin),200);

    }
    public function update(UpdateAdminRequest $request, Admin $admin): JsonResponse
    {
        $updatedAdmin = app(UpdateAdminAction::class)->run($request, $admin);
        return response()->json([
            'message'=>'Admin updated successfully',
            'Admin'=>$updatedAdmin
        ], 200);
    }
}
