<?php

namespace App\Ship\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class BackupManagementController extends Controller
{
    public function backups(): JsonResponse
    {
        // Run the backup:run Artisan command
        Artisan::call('backup:run');
        
        // Get the output from the command
        $output = Artisan::output();
        
        // Return a successful JSON response with the output
        return response()->json([
            'status' => 'success',
            'message' => 'Backup completed successfully.',
            'output' => $output
        ], 200);
    }
}
