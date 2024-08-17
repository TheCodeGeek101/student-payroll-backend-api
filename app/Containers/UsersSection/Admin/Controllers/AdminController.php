<?php
namespace App\Containers\UsersSection\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Containers\UsersSection\Admin\Actions\CreateAdministratorAction;
use App\Containers\UsersSection\Admin\Actions\UpdateAdminAction;
use App\Containers\UsersSection\Admin\Requests\StoreAdminRequest;
use App\Containers\UsersSection\Admin\Requests\UpdateAdminRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Containers\UsersSection\Admin\Data\Models\Adminstrator;

class AdminController extends Controller
{
    public function index(): JsonResponse
    {
        $admins = Adminstrator::all();
        return response()->json(['admins' => $admins]);
    }

    public function store(StoreAdminRequest $request): JsonResponse
    {
        $newAdmin = app(CreateAdministratorAction::class)->run($request);

        if ($newAdmin) {
            return response()->json([
                'success' => true,
                'admin' => $newAdmin
            ], 201);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to create admin'
        ], 500);
    }

    public function show(Administrator $administrator): JsonResponse
    {
        return response()->json(['admin' => $administrator]);
    }

    public function update(UpdateAdminRequest $request, Administrator $administrator): JsonResponse
    {
        $updateAdmin = app(UpdateAdminAction::class)->run($request, $administrator);

        if ($updateAdmin) {
            return response()->json([
                'success' => true,
                'admin' => $updateAdmin
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to update admin'
        ], 500);
    }

    public function delete(Administrator $administrator): JsonResponse
    {
        try {
            $administrator->delete();
            return response()->json([
                'success' => true,
                'message' => 'Admin deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete admin'
            ], 500);
        }
    }
}
