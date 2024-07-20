<?php

namespace App\Containers\UsersSection\Adminstrator\Controllers;
use App\Containers\UsersSection\Adminstrator\Actions\UpdateAdminAction;
use App\Containers\UsersSection\Adminstrator\Requests\UpdateAdminRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Containers\UsersSection\Adminstrator\Actions\CreateAdminAction;
use App\Http\Requests\StoreAdministratorRequest;
use App\Containers\UsersSection\Adminstrator\Data\Models\Admin;
use App\Containers\UsersSection\Adminstrator\Resources\AdminResource;
use Illuminate\Http\JsonResponse;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = Admin::all();
        return response()->json(['Admins'=>AdminResource::collection($admins)], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdministratorRequest $request): JsonResponse
    {
        $admin = app(CreateAdminAction::class)->run($request);
        return response()->json(['message' => 'Admin created successfully','Admin'=>$admin],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin): JsonResponse
    {
        return response()->json(new AdminResource($admin),200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdminRequest $request, Admin $admin): JsonResponse
    {
        $updatedAdmin = app(UpdateAdminAction::class)->run($request, $admin);
        return response()->json(['message','Admin updated successfully','admin'=>$updatedAdmin],200);
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Admin $admin): JsonResponse
    {
        $admin->delete();
        return response()->json(['message'=>'Admin deleted successfully'],200);
    }
}
