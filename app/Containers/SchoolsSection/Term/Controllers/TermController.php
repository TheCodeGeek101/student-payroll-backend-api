<?php

namespace App\Containers\SchoolsSection\Term\Controllers;

use App\Containers\SchoolsSection\Term\Actions\CreateAcademicTermAction;
use App\Containers\SchoolsSection\Term\Data\Models\Term;
use App\Http\Controllers\Controller;
use App\Containers\SchoolsSection\Term\Requests\StoreTermRequest;
use App\Containers\SchoolsSection\Term\Requests\UpdateTermRequest;
use App\Containers\SchoolsSection\Term\Actions\UpdateTermAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class TermController extends Controller
{
    public function index(): JsonResponse
    {
        $terms = Term::all();
        return response()->json(['terms' => $terms], 200);
    }

    public function store(StoreTermRequest $request): JsonResponse
    {
        try {
            // Execute the CreateAcademicTermAction to store the term
            $term = app(CreateAcademicTermAction::class)->run($request);
    
            // Return the created term in the response
            return response()->json(['term' => $term], 201);
    
        } catch (ValidationException $e) {
            // Catch validation exceptions and return error messages
            return response()->json([
                'message' => 'Failed to create term.',
                'errors' => $e->errors(),
            ], 422);
            
        } catch (HttpResponseException $e) {
            // Catch the 409 conflict exception when a term exists within the date range
            return $e->getResponse();
    
        } catch (\Exception $e) {
            // Catch any other unexpected exceptions
            return response()->json([
                'message' => 'An error occurred while creating the term.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
    public function show(Term $term): JsonResponse
    {
        return response()->json(['term' => $term], 200);
    }

    public function update(UpdateTermRequest $request, Term $term): JsonResponse
    {
        try {
            // Execute the UpdateTermAction to update the term
            $updatedTerm = app(UpdateTermAction::class)->run($request, $term);

            // Return the updated term in the response
            return response()->json(['term' => $updatedTerm], 200);

        } catch (ValidationException $e) {
            // Handle validation errors if necessary
            return response()->json([
                'message' => 'Failed to update term.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            // Catch any other exceptions
            return response()->json([
                'message' => 'An error occurred while updating the term.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(Term $term): JsonResponse
    {
        $term->delete();
        return response()->json(['message' => 'Term deleted successfully'], 200);
    }
}
